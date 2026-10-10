<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer - POS System</title>
</head>
<body>
    <?= view('partials/navigation') ?>

    <h1>Edit Customer</h1>

    <?php $errors = session()->getFlashdata('errors') ?? []; ?>
    <?php if ($errors !== []) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= site_url('customers/edit/' . $customer['id']) ?>" method="post">
        <?= csrf_field() ?>
        <p>
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" maxlength="100" required value="<?= esc(old('full_name', $customer['full_name'])) ?>">
        </p>
        <p>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" maxlength="100" required value="<?= esc(old('email', $customer['email'])) ?>">
        </p>
        <p>
            <label for="phone">Phone (optional)</label>
            <input type="text" id="phone" name="phone" maxlength="20" value="<?= esc(old('phone', $customer['phone'] ?? '')) ?>">
        </p>
        <button type="submit">Save Changes</button>
    </form>
    <p><a href="<?= site_url('customers') ?>">Back to Customer Accounts</a></p>
</body>
</html>
