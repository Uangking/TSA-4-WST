<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS System</title>
</head>
<body>
    <nav>
        <a href="<?= site_url('/') ?>">Home</a>
        <a href="<?= site_url('about') ?>">About</a>
        <a href="<?= site_url('login') ?>">Login</a>
    </nav>

    <h1>Login</h1>

    <?php $errors = session()->getFlashdata('errors') ?? []; ?>
    <?php if ($errors !== []) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= site_url('login') ?>" method="post">
        <?= csrf_field() ?>
        <p>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" maxlength="50" required value="<?= esc(session()->getFlashdata('login_username') ?? '') ?>">
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" maxlength="255" required autocomplete="current-password">
        </p>
        <button type="submit">Login</button>
    </form>
</body>
</html>
