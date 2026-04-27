<?php
require_once __DIR__ . '/auth-functions.inc.php';

$error = $_GET['error'] ?? '';
$message = '';

if ($error === 'missing') {
    $message = 'Please fill out every field.';
} elseif ($error === 'email') {
    $message = 'Please enter a valid email address.';
} elseif ($error === 'duplicate') {
    $message = 'That email address is already registered.';
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
<div class="flex flex-col max-w-md px-4 py-8 bg-white rounded-lg shadow dark:bg-gray-800 sm:px-6 md:px-8 lg:px-10">
    <div class="self-center mb-2 text-xl font-light text-gray-800 sm:text-2xl dark:text-white">
        Register (bcrypt)
    </div>

    <span class="justify-center text-sm text-center text-gray-500 flex-items-center dark:text-gray-400">
        Already have an account?
        <a href="login-form-bcrypt.php" class="text-sm text-blue-500 underline hover:text-blue-700">
            Sign in
        </a>
    </span>

    <?php if ($message !== ''): ?>
        <div class="mt-4 text-red-600 text-sm text-center"><?= h($message) ?></div>
    <?php endif; ?>

    <div class="p-6 mt-2">
        <form action="process-registration-bcrypt.php" method="post">
            <div class="flex gap-4 mb-2">
                <input type="text" name="first" placeholder="First name" class="rounded-lg border border-gray-300 w-full py-2 px-4">
                <input type="text" name="last" placeholder="Last name" class="rounded-lg border border-gray-300 w-full py-2 px-4">
            </div>

            <div class="flex flex-col mb-2">
                <input type="text" name="city" placeholder="City" class="rounded-lg border border-gray-300 w-full py-2 px-4">
            </div>

            <div class="flex flex-col mb-2">
                <input type="text" name="country" placeholder="Country" class="rounded-lg border border-gray-300 w-full py-2 px-4">
            </div>

            <div class="flex flex-col mb-2">
                <input type="text" name="email" placeholder="Email" class="rounded-lg border border-gray-300 w-full py-2 px-4">
            </div>

            <div class="flex flex-col mb-2">
                <input type="password" name="password" placeholder="Password" class="rounded-lg border border-gray-300 w-full py-2 px-4">
            </div>

            <div class="flex w-full my-4">
                <button type="submit" class="py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white w-full rounded-lg">
                    Register
                </button>
            </div>

            <div class="flex items-center justify-center mt-2">
                <a href="registration-form-salt.php" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-100">
                    Register with salt/SHA-256 instead.
                </a>
            </div>

            <div class="flex items-center justify-center mt-2">
                <a href="home-page.php" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-100">
                    Return to home.
                </a>
            </div>
        </form>
    </div>
</div>
</main>

</body>
</html>
