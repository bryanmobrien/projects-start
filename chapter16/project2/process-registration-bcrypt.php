<?php
require_once __DIR__ . '/auth-functions.inc.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectTo('registration-form-bcrypt.php');
}

$first = trim($_POST['first'] ?? '');
$last = trim($_POST['last'] ?? '');
$city = trim($_POST['city'] ?? '');
$country = trim($_POST['country'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($first === '' || $last === '' || $city === '' || $country === '' || $email === '' || $password === '') {
    redirectTo('registration-form-bcrypt.php?error=missing');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirectTo('registration-form-bcrypt.php?error=email');
}

$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

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
        ':password' => $hash,
        ':salt' => '',
        ':password_sha256' => ''
    ]);

    redirectTo('login-form-bcrypt.php?registered=1');
} catch (PDOException $e) {
    redirectTo('registration-form-bcrypt.php?error=duplicate');
}
