<?php
require_once __DIR__ . '/auth.php';

if (current_user()) {
    redirect_to('dashboard.php');
}

$pageTitle = 'Login';
$activePage = 'login';
$bodyClass = 'login-page';
$message = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $result = login_user($email, $password);

    if ($result['ok']) {
        redirect_to('dashboard.php');
    }

    $message = $result['message'];
}

require __DIR__ . '/partials/header.php';
?>
<section class="zad-login-layout">
    <div class="login-visual-panel">
        <a class="back-button" href="register.php">←</a>
        <div class="visual-logo">
            <img class="login-logo" src="assets/images/django-girls-sierra-leone-logo.png" alt="Django Girls Sierra Leone logo">
        </div>
    </div>

    <form class="auth-card zad-login-card" method="post" action="login.php">
        <h2>Participants Login</h2>
        <p class="welcome-text">Welcome</p>
        <?php if ($message): ?>
            <div class="alert error"><?= e($message) ?></div>
        <?php endif; ?>

        <label for="email">Email Address</label>
        <div class="input-row"><span>@</span><input id="email" name="email" type="email" value="<?= e($email) ?>" required></div>

        <div class="label-row">
            <label for="password">Password</label>
            <a href="#">I forgot my password</a>
        </div>
        <div class="input-row"><span>▣</span><input id="password" name="password" type="password" required></div>

        <button type="submit">Login</button>
        <p class="form-link">For help with logging in please visit our <a href="#">FAQ page</a></p>
    </form>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>

