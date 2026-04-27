<?php
define('DBHOST', 'localhost');
define('DBNAME', 'security');
define('DBUSER', 'root');
define('DBPASS', '');

define('DBCONNSTRING', 'sqlite:' . __DIR__ . '/database/security.db');
// define('DBCONNSTRING', "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");

$connectionDetails = [DBCONNSTRING, DBUSER, DBPASS];
