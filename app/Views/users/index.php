<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Accounts - POS System</title>
</head>
<body>
    <?= view('partials/navigation') ?>

    <h1>User Accounts</h1>

    <?php $message = session()->getFlashdata('message'); ?>
    <?php if ($message) : ?>
        <p><?= esc($message) ?></p>
    <?php endif; ?>

    <p><a href="<?= site_url('users/new') ?>">Add New User</a></p>

    <?php if (! empty($users)) : ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Created At</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <?php
                        $avatarFilename = $user['avatar'] ?? '';
                        $avatarPath = 'images/avatar-placeholder.svg';
                        if ($avatarFilename !== '' && basename($avatarFilename) === $avatarFilename
                            && is_file(FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR . $avatarFilename)
                        ) {
                            $avatarPath = 'uploads/avatars/' . rawurlencode($avatarFilename);
                        }
                        ?>
                        <td><img src="<?= esc(base_url($avatarPath), 'attr') ?>" alt="Avatar for <?= esc($user['full_name'], 'attr') ?>" width="60" height="60" style="object-fit: cover;"></td>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= esc($user['full_name']) ?></td>
                        <td><?= esc($user['created_at']) ?></td>
                        <td><a href="<?= site_url('users/edit/' . $user['id']) ?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No user records available.</p>
    <?php endif; ?>
</body>
</html>
