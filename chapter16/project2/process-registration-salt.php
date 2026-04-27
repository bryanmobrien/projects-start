<?php
require_once __DIR__ . '/auth-functions.inc.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectTo('registration-form-salt.php');
}

$first = trim($_POST['first'] ?? '');
$last = trim($_POST['last'] ?? '');
$city = trim($_POST['city'] ?? '');
$country = trim($_POST['country'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($first === '' || $last === '' || $city === '' || $country === '' || $email === '' || $password === '') {
    redirectTo('registration-form-salt.php?error=missing');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirectTo('registration-form-salt.php?error=email');
}

$salt = bin2hex(random_bytes(16));
$digest = hash('sha256', $password . $salt);

try {
    $stmt = db()->prepare(
        'INSERT INTO users (email, firstname, lastname, city, country, password, salt, password_sha256)
         VALUES (:email, :firstname, :lastname, :city, :country, :password, :salt, :password_sha256)'
    );

    $stmt->execute([
        ':email' => $email,
        ':firstname' => $first,
        ':lastname' => $last,
        ':city' => $city,
        ':country' => $country,
        ':password' => '',
        ':salt' => $salt,
        ':password_sha256' => $digest
    ]);

    redirectTo('login-form-salt.php?registered=1');
} catch (PDOException $e) {
    redirectTo('registration-form-salt.php?error=duplicate');
}
