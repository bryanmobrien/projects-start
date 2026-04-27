<?php
require_once __DIR__ . '/auth-functions.inc.php';

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['pass'] ?? '';

    if ($email === '' || $pass === '') {
        $error = 'Please enter both email and password.';
    } else {
        $user = findUserByEmail($email);

        if ($user && !empty($user['password']) && password_verify($pass, $user['password'])) {
            setLoggedInUser($user);
            redirectTo('home-page.php');
        }

        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chapter 16</title>
    <meta charset="utf-8">
    <link href="css/tailwind.css" rel="stylesheet">
</head>
<body class="bg-gray-700">

<main class="m-4 flex items-center justify-center h-screen">
<section class="flex flex-col w-full max-w-md px-4 py-8 bg-white rounded-lg shadow dark:bg-gray-800 sm:px-6 md:px-8 lg:px-10">
    <div class="self-center mb-6 text-xl font-light text-gray-600 sm:text-2xl dark:text-white">
        Login (bcrypt version)
    </div>

    <form method="post" action="login-form-bcrypt.php" autocomplete="off">
        <div class="flex flex-col mb-2">
            <input type="text" name="email" id="login-email"
                   value="<?= h($email) ?>"
                   class="rounded-lg border border-gray-300 w-full py-2 px-4 bg-white text-gray-700"
                   placeholder="Your email">
        </div>

        <div class="flex flex-col mb-4">
            <input type="password" name="pass" id="login-pass"
                   class="rounded-lg border border-gray-300 w-full py-2 px-4 bg-white text-gray-700"
                   placeholder="Your password">
        </div>

        <?php if ($error !== ''): ?>
            <div class="mb-4 text-red-600 text-sm">
                <?= h($error) ?>
            </div>
        <?php endif; ?>

        <button type="submit"
                class="py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white w-full rounded-lg">
            Login
        </button>
    </form>

    <div class="flex items-center justify-center mt-6">
        <a href="registration-form.php" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-100">
            You don't have an account? Register here.
        </a>
    </div>

    <div class="flex items-center justify-center mt-2">
        <a href="login-form-salt.php" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-100">
            Try salt/SHA-256 login.
        </a>
    </div>

    <div class="flex items-center justify-center mt-2">
        <a href="home-page.php" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-100">
            Return to home.
        </a>
    </div>
</section>
</main>

</body>
</html>
