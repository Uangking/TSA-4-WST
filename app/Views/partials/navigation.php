<nav>
    <a href="<?= site_url('/') ?>">Home</a>
    <a href="<?= site_url('about') ?>">About</a>
    <?php if (session()->get('isLoggedIn') === true) : ?>
        <a href="<?= site_url('customers') ?>">Customer Accounts</a>
        <a href="<?= site_url('users') ?>">User Accounts</a>
        <form action="<?= site_url('logout') ?>" method="post" style="display: inline;">
            <?= csrf_field() ?>
            <button type="submit">Logout (<?= esc(session()->get('username')) ?>)</button>
        </form>
    <?php else : ?>
        <a href="<?= site_url('login') ?>">Login</a>
    <?php endif; ?>
</nav>
