<?php
$env_file = __DIR__ . "/.env.php";
$env = file_exists($env_file) ? require $env_file : [];

if (!is_array($env)) {
    die('Config file did not return an array!');
}

define('DB_HOST', $env['DB_HOST'] ?? 'localhost');
define('DB_NAME', $env['DB_NAME'] ?? 'sej84_db');
define('DB_USER', $env['DB_USER'] ?? 'root');
define('DB_PASS', $env['DB_PASS'] ?? 'root');

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


