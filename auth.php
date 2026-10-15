<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

ensure_database_schema();

function find_user_by_email(string $email): ?array
{
    $email = strtolower(trim($email));
    $statement = db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $statement->execute([$email]);
    $user = $statement->fetch();

    return $user ?: null;
}



function register_user(array $input): array
{
    $name = trim($input['name'] ?? '');
    $email = strtolower(trim($input['email'] ?? ''));
    $phone = trim($input['phone'] ?? '');
    $location = trim($input['location'] ?? '');
    $password = $input['password'] ?? '';
    $confirmPassword = $input['confirm_password'] ?? '';

    if (
        $name === '' ||
        $email === '' ||
        $phone === '' ||
        $location === '' ||
        $password === '' ||
        $confirmPassword === ''
    ) {
        return ['ok' => false, 'message' => 'All fields are required.'];
    }

    if ($password !== $confirmPassword) {
        return ['ok' => false, 'message' => 'Passwords do not match.'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['ok' => false, 'message' => 'Please enter a valid email address.'];
    }

    if (strlen($password) < 6) {
        return ['ok' => false, 'message' => 'Password must be at least 6 characters.'];
    }

    if (find_user_by_email($email) !== null) {
        return ['ok' => false, 'message' => 'An account already exists with that email.'];
    }

    $statement = db()->prepare(
        'INSERT INTO users (full_name, email, phone, location, password_hash)
         VALUES (?, ?, ?, ?, ?)'
    );

    $statement->execute([
        $name,
        $email,
        $phone,
        $location,
        password_hash($password, PASSWORD_DEFAULT),
    ]);

    return [
        'ok' => true,
        'message' => 'Account created successfully. You can now sign in.'
    ];
}



function login_user(string $email, string $password): array
{
    $user = find_user_by_email($email);

    if ($user === null || !password_verify($password, $user['password_hash'] ?? '')) {
        return ['ok' => false, 'message' => 'Invalid email or password.'];
    }

    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['full_name'],
        'email' => $user['email'],
    ];

    return ['ok' => true, 'message' => 'Login successful.'];
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function require_login(): array
{
    $user = current_user();

    if ($user === null) {
        redirect_to('login.php');
    }

    $statement = db()->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
    $statement->execute([$user['id']]);
    $freshUser = $statement->fetch();

    if (!$freshUser) {
        logout_user();
        redirect_to('login.php');
    }

    return $freshUser;
}

function logout_user(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
}

