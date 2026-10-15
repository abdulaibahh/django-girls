
<?php
require_once __DIR__ . '/auth.php';

$user = require_login();
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
$bodyClass = 'dashboard-page';

require __DIR__ . '/partials/header.php';
$displayName = $user['full_name'];
$initials = strtoupper(substr($displayName, 0, 1));
?>

<div class="breadcrumb">Home › Dashboard</div>

<section class="lms-layout">
    <aside class="left-column">
        <section class="widget menu-widget">
            <a href="#"><span>▣</span> Schedule <strong>›</strong></a>
            <a href="#"><span>✱</span> Grades report</a>
        </section>

        <section class="widget grades-widget">
            <h3>Current semester grades:</h3>
            <p><span>HTML & CSS</span><strong>86 / 100</strong></p>
            <p><span>PHP Basics</span><strong>91 / 100</strong></p>
            <p><span>Authentication</span><strong>94 / 100</strong></p>
            <p><span>Database Design</span><strong>88 / 100</strong></p>
            <p><span>Dashboard UI</span><strong>92 / 100</strong></p>
        </section>

        <section class="widget certificate-widget">
            <h3>Certificate of Enrollment</h3>
            <div class="certificate-preview">
                <img
                    class="certificate-logo"
                    src="assets/images/django-girls-sierra-leone-logo.png"
                    alt="Django Girls Sierra Leone logo"
                >
                <strong>Certificate of Enrollment</strong>
                <small><?= e($displayName) ?></small>
            </div>
            <p>Keep your profile data correct so your enrollment certificate can be generated accurately.</p>
            <a class="blue-button" href="#">Edit Personal Profile</a>
            <a class="green-button" href="#">Download certificate</a>
        </section>
    </aside>

    <section class="center-column">
        <section class="semester-hero">
            <div>
                <h1>Welcome, <?= e($displayName) ?></h1>
                <p>We welcome you to this great opportunity to learn, build, and share knowledge.</p>
            </div>
        </section>

        <section class="welcome-copy">
            <p>Django Girls Sierra Leone welcomes learners into a practical environment for developing web programming skills. Your profile, courses, schedule, and progress are organized here so you can follow the semester clearly.</p>
        </section>

        <?php
        $courses = [
            ['HTML & CSS', 'Build clean page structure, responsive layouts, and polished interface styling.', 'blue'],
            ['PHP Authentication', 'Create secure forms, verify users, manage sessions, and protect private pages.', 'teal'],
            ['MySQL Database', 'Store real user details with relational tables and prepared SQL statements.', 'green'],
            ['Dashboard Design', 'Organize profile information, course panels, reports, and account controls.', 'orange'],
            ['Security Practice', 'Use password hashing, validation, and safe output escaping across the app.', 'red'],
            ['Project Submission', 'Prepare screenshots, documentation, and the final assignment explanation.', 'purple'],
        ];
        ?>

        <div class="course-list">
            <?php foreach ($courses as $course): ?>
                <article class="course-card <?= e($course[2]) ?>">
                    <div>
                        <h2><?= e($course[0]) ?></h2>
                        <p><?= e($course[1]) ?></p>
                    </div>
                    <div class="course-thumb">
                        <?= e(substr($course[0], 0, 1)) ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <aside class="right-column">
        <section class="widget tv-widget">
            <h3>DG TV Channel</h3>
            <div class="video-box"></div>
        </section>

        <section class="widget schedule-widget">
            <h3>Weekly Schedule</h3>
            <p><strong>Monday</strong><span>08:00 - 08:35 PHP Basics</span></p>
            <p><strong>Tuesday</strong><span>08:40 - 09:00 MySQL</span></p>
            <p><strong>Wednesday</strong><span>09:05 - 09:25 Authentication</span></p>
            <p><strong>Thursday</strong><span>08:50 - 09:10 Dashboard UI</span></p>
            <p><strong>Friday</strong><span>09:10 - 09:45 Project Work</span></p>
        </section>

        <section class="widget store-widget">
            <h3>Learning Store</h3>
            <div class="store-poster">Django Girls resources are available for participants.</div>
            <a class="blue-button" href="#">Visit the store</a>
        </section>

        <section class="widget profile-widget">
            <h3>Profile Details</h3>
            <p><span>Email</span><?= e($user['email']) ?></p>
            <p><span>Phone</span><?= e($user['phone']) ?></p>
            <p><span>Location</span><?= e($user['location']) ?></p>
            <p>
                <span>Joined</span>
                <?= e(date('M j, Y', strtotime($user['created_at']))) ?>
            </p>
        </section>
    </aside>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
