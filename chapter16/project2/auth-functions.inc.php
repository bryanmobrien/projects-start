<?php
require_once __DIR__ . '/config.inc.php';

if (session_status() === PHP_SESSION_NONE) {
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}

function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    return $pdo;
}

function h(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function findUserByEmail(string $email): ?array
{
    $stmt = db()->prepare(
        'SELECT email, firstname, lastname, city, country, password, salt, password_sha256
         FROM users
         WHERE email = :email'
    );

    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    return $user ?: null;
}

function setLoggedInUser(array $user): void
{
    session_regenerate_id(true);

    $_SESSION['user'] = [
        'email' => $user['email'],
        'firstname' => $user['firstname'],
        'lastname' => $user['lastname'],
        'city' => $user['city'],
        'country' => $user['country']
    ];
}

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

function redirectTo(string $path): never
{
    header("Location: $path");
    exit;
}
