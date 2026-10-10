<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Accounts - POS System</title>
</head>
<body>
    <?= view('partials/navigation') ?>

    <h1>Customer Accounts</h1>

    <?php $message = session()->getFlashdata('message'); ?>
    <?php if ($message) : ?>
        <p><?= esc($message) ?></p>
    <?php endif; ?>

    <p><a href="<?= site_url('customers/new') ?>">Add New Customer</a></p>

    <?php if (! empty($customers)) : ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer) : ?>
                    <tr>
                        <td><?= esc($customer['full_name']) ?></td>
                        <td><?= esc($customer['email']) ?></td>
                        <td><?= esc($customer['phone']) ?></td>
                        <td><a href="<?= site_url('customers/edit/' . $customer['id']) ?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No customer records available.</p>
    <?php endif; ?>
</body>
</html>
