<?php
require_once __DIR__ . '/auth.php';

if (current_user()) {
    redirect_to('dashboard.php');
}

$pageTitle = 'Create Account';
$activePage = 'register';
$bodyClass = 'registration-page';
$message = '';
$messageType = '';
$form = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'program' => 'BIT',
    'semester' => 'Sem 5',
    'student_id' => '',
    'location' => '',
    'role' => 'Student',
    'bio' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($form as $key => $value) {
        $form[$key] = $_POST[$key] ?? '';
    }

    if (($_POST['password'] ?? '') !== ($_POST['confirm_password'] ?? '')) {
        $message = 'Passwords do not match.';
        $messageType = 'error';
    } else {
        $result = register_user($_POST);
        $message = $result['message'];
        $messageType = $result['ok'] ? 'success' : 'error';

        if ($result['ok']) {
            foreach ($form as $key => $value) {
                $form[$key] = '';
            }
            $form['program'] = 'BIT';
            $form['semester'] = 'Sem 5';
            $form['role'] = 'Student';
        }
    }
}

require __DIR__ . '/partials/header.php';
?>
<section class="registration-banner">
    <div>Admission & Registration</div>
</section>

<section class="admission-intro">
    <div>
        <h1>Admission & Registration</h1>
        <p>Through a simplified registration procedure, aspiring Django Girls participants can easily join the learning platform and begin their web programming journey. Below are the steps involved in the admission process.</p>
    </div>
    <a class="register-now" href="#registration-form">Register Now</a>
</section>

<section class="process-steps" aria-label="Registration steps">
    <article class="step-card">
        <span class="step-number">01</span>
        <div class="step-icon">▤</div>
        <h2>Registration</h2>
        <p>Complete the registration form during the open registration period. Provide your real details so your dashboard and certificate information are accurate.</p>
    </article>
    <article class="step-card">
        <span class="step-number bottom">02</span>
        <div class="step-icon">☑</div>
        <h2>Confirmation</h2>
        <p>After submitting the form, your participant account is saved in the Django Girls dashboard database and prepared for secure login.</p>
    </article>
    <article class="step-card">
        <span class="step-number">03</span>
        <div class="step-icon">▣</div>
        <h2>Account Activation</h2>
        <p>Once the account is created, you can log in and access course resources, schedule information, profile details, and study materials.</p>
    </article>
</section>

<section class="registration-dates">
    <h2>Beginning and End of Registration</h2>
    <div class="date-panel">
        <article>
            <span>▤</span>
            <p>Start of Registration Period</p>
            <strong>01 September 2026</strong>
        </article>
        <article>
            <span>▣</span>
            <p>Deadline for Registration</p>
            <strong>20 December 2026</strong>
        </article>
        <article>
            <span>▱</span>
            <p>Start of New Semester</p>
            <strong>17 January 2027</strong>
        </article>
    </div>
</section>

<section id="registration-form" class="registration-form-section">
    <form class="auth-card wide-form admission-form" method="post" action="register.php#registration-form">
        <h2>Participant Registration Form</h2>
        <p class="form-subtitle">Enter your details exactly as you want them to appear on your dashboard.</p>
        <?php if ($message): ?>
            <div class="alert <?= e($messageType) ?>"><?= e($message) ?></div>
        <?php endif; ?>

        <div class="form-grid">
            <div>
                <label for="name">Full Name</label>
                <input id="name" name="name" type="text" value="<?= e($form['name']) ?>" required>
            </div>

            <div>
                <label for="email">Email Address</label>
                <input id="email" name="email" type="email" value="<?= e($form['email']) ?>" required>
            </div>

            <div>
                <label for="phone">Phone Number</label>
                <input id="phone" name="phone" type="tel" value="<?= e($form['phone']) ?>" required>
            </div>


            <div>
                <label for="location">Location</label>
                <input id="location" name="location" type="text" value="<?= e($form['location']) ?>" placeholder="Freetown, Sierra Leone" required>
            </div>


            <div>
                <label for="password">Password</label>
                <input id="password" name="password" type="password" minlength="6" required>
            </div>

            <div>
                <label for="confirm_password">Confirm Password</label>
                <input id="confirm_password" name="confirm_password" type="password" minlength="6" required>
            </div>
        </div>

        <button type="submit">Create Account</button>
        <p class="form-link">Already registered? <a href="login.php">Login here</a></p>
    </form>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>

