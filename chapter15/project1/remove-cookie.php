<?php
if (isset($_COOKIE['theme'])) {
    unset($_COOKIE['theme']);
    setcookie("theme", "", time() - 3600, "/");
}

if (isset($_COOKIE['philosopher'])) {
    unset($_COOKIE['philosopher']);
    setcookie("philosopher", "", time() - 3600, "/");
}

header("Location: ch15-proj1.php");
exit;
?>