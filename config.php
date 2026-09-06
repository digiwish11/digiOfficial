<?php
/* ==================================================================
   config.php — MySQL connection for XAMPP
   ------------------------------------------------------------------
   Recommendation: this is the ONLY file where you should ever type
   your DB host / username / password. Every other PHP file does
   require 'config.php'; and reuses the $conn it creates here.

   Default XAMPP settings: host = localhost, user = root, password =
   "" (empty). Change DB_PASS if you've set a MySQL root password.
   ================================================================== */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'digiwish');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error .
        ' — Have you run digiwish.sql in phpMyAdmin?');
}

$conn->set_charset('utf8mb4');
