<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - POS System</title>
</head>
<body>
    <?= view('partials/navigation') ?>

    <h1>Edit User</h1>

    <?php $errors = session()->getFlashdata('errors') ?? []; ?>
    <?php if ($errors !== []) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= site_url('users/edit/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <p>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" maxlength="50" required value="<?= esc(old('username', $user['username'])) ?>">
        </p>
        <p>
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" maxlength="100" required value="<?= esc(old('full_name', $user['full_name'])) ?>">
        </p>
        <p>
            <label for="avatar">Avatar (optional JPG or PNG, maximum 2 MB)</label>
            <input type="file" id="avatar" name="avatar" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
        </p>
        <button type="submit">Save Changes</button>
    </form>
    <p><a href="<?= site_url('users') ?>">Back to User Accounts</a></p>
</body>
</html>
