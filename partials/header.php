<?php
$pageTitle = $pageTitle ?? APP_NAME;
$activePage = $activePage ?? '';
$bodyClass = $bodyClass ?? '';
$headerUser = current_user();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="assets/css/styles.css?v=20261013-logo1">
</head>
<body class="<?= e($bodyClass) ?>">
    <header class="site-header">
        <div class="top-strip">
            <a class="brand" href="index.php" aria-label="<?= e(APP_NAME) ?> home">
                <img class="brand-logo" src="assets/images/django-girls-sierra-leone-logo.png" alt="Django Girls Sierra Leone logo">
            </a>
            <?php if ($headerUser): ?>
                <div class="header-user">
                    <strong><?= e(strtoupper($headerUser['name'])) ?></strong>
                    <span class="header-avatar"><?= e(strtoupper(substr($headerUser['name'], 0, 1))) ?></span>
                </div>
            <?php else: ?>
                <div class="language-link">En</div>
            <?php endif; ?>
        </div>
        <nav class="nav">
            <a class="home-tab" href="dashboard.php">Home</a>
            <?php if (current_user()): ?>
                <a class="<?= $activePage === 'dashboard' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
                <a href="#">Academy Support</a>
                <a href="#">Django Library</a>
                <a href="#">Schedule</a>
                <a href="#">My Courses</a>
                <a href="logout.php">Logout</a>
                <span class="nav-search">Search...</span>
            <?php else: ?>
                <a class="<?= $activePage === 'login' ? 'active' : '' ?>" href="login.php">Participants Login</a>
                <a class="<?= $activePage === 'register' ? 'active' : '' ?>" href="register.php">Create Account</a>
                <span class="nav-search">Search...</span>
            <?php endif; ?>
        </nav>
    </header>
    <main>

