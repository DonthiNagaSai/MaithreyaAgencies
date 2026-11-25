<?php

// Database settings. The defaults match a fresh local XAMPP install
// (user "root" with no password). Set these environment variables to
// use different credentials instead of editing this file.
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_port = (int) (getenv('DB_PORT') ?: 3306);
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'maithreyaagencies';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
   $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);
   mysqli_set_charset($conn, 'utf8mb4');
} catch (mysqli_sql_exception $e) {
   error_log('Database connection failed: ' . $e->getMessage());
   http_response_code(500);
   exit('Could not connect to the database. Check config.php and that MySQL is running.');
}

// Escape text before printing it into HTML.
function e($value)
{
   return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
