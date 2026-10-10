<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Images\Exceptions\ImageException;

class Users extends BaseController
{
    public function index(): string
    {
        $users = (new UserModel())->findAllPublic();

        return view('users/index', ['users' => $users]);
    }

    public function new(): string
    {
        return view('users/new');
    }

    public function create()
    {
        $rules = [
            'username'  => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
            'password'  => 'required|min_length[8]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->with('form_values', [
                    'username'  => $this->request->getPost('username'),
                    'full_name' => $this->request->getPost('full_name'),
                ]);
        }

        try {
            $created = (new UserModel())->insert([
                'username'   => $this->request->getPost('username'),
                'full_name'  => $this->request->getPost('full_name'),
                'created_at' => date('Y-m-d H:i:s'),
                'password'   => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            ]);
        } catch (DatabaseException $exception) {
            log_message('error', 'Could not create user: {message}', ['message' => $exception->getMessage()]);

            return redirect()->back()
                ->with('errors', ['username' => 'The user could not be saved. Please try again.'])
                ->with('form_values', [
                    'username'  => $this->request->getPost('username'),
                    'full_name' => $this->request->getPost('full_name'),
                ]);
        }

        if (! $created) {
            log_message('error', 'Could not create a user record.');

            return redirect()->back()
                ->with('errors', ['username' => 'The user could not be saved. Please try again.'])
                ->with('form_values', [
                    'username'  => $this->request->getPost('username'),
                    'full_name' => $this->request->getPost('full_name'),
                ]);
        }

        return redirect()->to(site_url('users'))->with('message', 'User added successfully.');
    }

    public function edit(string $id): string
    {
        $user = (new UserModel())->findPublicById($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('users/edit', ['user' => $user]);
    }

    public function update(string $id)
    {
        $model = new UserModel();
        $user  = $model->findPublicById($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'username'  => 'required|max_length[50]|is_unique[users.username,id,' . (int) $id . ']',
            'full_name' => 'required|max_length[100]',
        ];
        $avatar = $this->request->getFile('avatar');
        $hasNewAvatar = $avatar instanceof UploadedFile && $avatar->getError() !== UPLOAD_ERR_NO_FILE;

        if ($hasNewAvatar) {
            $rules['avatar'] = 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png]|max_size[avatar,2048]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $newAvatarPath = null;
        $newAvatarName = null;

        if ($hasNewAvatar) {
            $extension = $avatar->getMimeType() === 'image/png' ? 'png' : 'jpg';
            $fileName  = bin2hex(random_bytes(16)) . '.' . $extension;
            $stagingDirectory = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars';
            $avatarDirectory  = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars';

            foreach ([$stagingDirectory, $avatarDirectory] as $directory) {
                if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
                    log_message('error', 'Could not create the avatar directory: {directory}', ['directory' => $directory]);

                    return redirect()->back()->withInput()->with('errors', [
                        'avatar' => 'The avatar could not be saved. Please try again.',
                    ]);
                }
            }

            $stagingPath   = $stagingDirectory . DIRECTORY_SEPARATOR . $fileName;
            $newAvatarPath = $avatarDirectory . DIRECTORY_SEPARATOR . $fileName;

            try {
                $image = service('image')
                    ->withFile($avatar->getTempName())
                    ->resize(300, 300, true, 'auto');

                if (! $image->save($stagingPath, 90) || ! rename($stagingPath, $newAvatarPath)) {
                    if (is_file($stagingPath)) {
                        unlink($stagingPath);
                    }
                    log_message('error', 'Could not finish processing an avatar for user ID {id}.', ['id' => $id]);

                    return redirect()->back()->withInput()->with('errors', [
                        'avatar' => 'The avatar could not be processed. Please choose another image.',
                    ]);
                }
            } catch (ImageException $exception) {
                if (is_file($stagingPath)) {
                    unlink($stagingPath);
                }
                log_message('error', 'Avatar processing failed for user ID {id}: {message}', [
                    'id'      => $id,
                    'message' => $exception->getMessage(),
                ]);

                return redirect()->back()->withInput()->with('errors', [
                    'avatar' => 'The uploaded file could not be processed as an image.',
                ]);
            }

            $newAvatarName = $fileName;
        }

        $changes = [
            'username'  => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
        ];

        if ($newAvatarName !== null) {
            $changes['avatar'] = $newAvatarName;
        }

        try {
            $updated = $model->update($id, $changes);
        } catch (DatabaseException $exception) {
            if ($newAvatarPath !== null && is_file($newAvatarPath)) {
                unlink($newAvatarPath);
            }
            log_message('error', 'Could not update user ID {id}: {message}', [
                'id'      => $id,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->back()->withInput()->with('errors', [
                'username' => 'The user could not be updated. Please try again.',
            ]);
        }

        if (! $updated) {
            if ($newAvatarPath !== null && is_file($newAvatarPath)) {
                unlink($newAvatarPath);
            }

            return redirect()->back()->withInput()->with('errors', [
                'username' => 'The user could not be updated. Please try again.',
            ]);
        }

        return redirect()->to(site_url('users'))->with('message', 'User updated successfully.');
    }
}
