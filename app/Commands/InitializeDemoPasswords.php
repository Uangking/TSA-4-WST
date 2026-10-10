<?php

namespace App\Commands;

use App\Models\UserModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Exceptions\DatabaseException;

class InitializeDemoPasswords extends BaseCommand
{
    protected $group       = 'Users';
    protected $name        = 'users:initialize-demo-passwords';
    protected $description = 'Generate local-only temporary passwords for the five sample users.';

    private const DEMO_USERNAMES = [
        'admin01',
        'mgr_santos',
        'cashier_lee',
        'mgr_fernandez',
        'cashier_vega',
    ];

    public function run(array $params)
    {
        $outputPath = WRITEPATH . 'demo-passwords.txt';
        if (is_file($outputPath)) {
            CLI::error('A local password file already exists. Move it somewhere safe before running this command again.');

            return EXIT_ERROR;
        }

        $model = new UserModel();
        $users = $model->select('id, username, password')
            ->whereIn('username', self::DEMO_USERNAMES)
            ->findAll();

        if (count($users) !== count(self::DEMO_USERNAMES)) {
            CLI::error('The five expected sample users were not found. No passwords were changed.');

            return EXIT_ERROR;
        }

        $passwords = [];
        foreach ($users as $user) {
            $passwords[$user['username']] = bin2hex(random_bytes(16));
        }

        $lines = [
            'Temporary demo passwords generated locally. Keep this file private.',
            'Run php spark users:initialize-demo-passwords again only after moving this file safely.',
            '',
        ];
        foreach ($passwords as $username => $password) {
            $lines[] = $username . ': ' . $password;
        }

        $temporaryPath = $outputPath . '.' . bin2hex(random_bytes(8)) . '.tmp';
        if (file_put_contents($temporaryPath, implode(PHP_EOL, $lines) . PHP_EOL, LOCK_EX) === false) {
            CLI::error('Could not write the local password file. No passwords were changed.');

            return EXIT_ERROR;
        }

        if (! rename($temporaryPath, $outputPath)) {
            unlink($temporaryPath);
            CLI::error('Could not save the local password file. No passwords were changed.');

            return EXIT_ERROR;
        }

        chmod($outputPath, 0600);
        $db = db_connect();
        $db->transBegin();

        try {
            foreach ($users as $user) {
                if ($user['password'] !== null && $user['password'] !== '') {
                    throw new \RuntimeException('A sample user already has a password hash. No passwords were changed.');
                }

                $updated = $model->update($user['id'], [
                    'password' => password_hash($passwords[$user['username']], PASSWORD_DEFAULT),
                ]);

                if (! $updated) {
                    throw new \RuntimeException('Could not initialize every sample user password.');
                }
            }

            if (! $db->transStatus()) {
                throw new DatabaseException('The sample password transaction failed.');
            }

            $db->transCommit();
        } catch (\RuntimeException|DatabaseException $exception) {
            $db->transRollback();
            unlink($outputPath);
            log_message('error', 'Demo password initialization failed: {message}', [
                'message' => $exception->getMessage(),
            ]);
            CLI::error($exception->getMessage());

            return EXIT_ERROR;
        }

        CLI::write('Temporary passwords were saved locally to: ' . $outputPath);
        CLI::write('Keep that file private. The database stores password hashes only.');

        return EXIT_SUCCESS;
    }
}
