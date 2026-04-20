<?php
if (isset($_POST['theme']) && isset($_POST['philosopher'])) {
    $theme = $_POST['theme'];
    $philosopher = $_POST['philosopher'];

    // set persistent cookie for 1 day
    if ($theme != "0") {
        setcookie("theme", $theme, time() + 86400, "/");
    }

    // set session cookie
    if ($philosopher != "0") {
        setcookie("philosopher", $philosopher, 0, "/");
    }
}

header("Location: ch15-proj1.php");
exit;
?>