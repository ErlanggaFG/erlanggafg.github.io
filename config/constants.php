<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Create Constants to Store Non-Repeating Values
if (!defined('SITEURL')) {
    define('SITEURL', 'http://localhost/food-order/'); // Update with your URL
}

if (!defined('LOCALHOST')) {
    define('LOCALHOST', 'localhost');
}

if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', 'root'); // Update with your database username
}

if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', ''); // Update with your database password
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'food_order'); // Update with your database name
}

// Connect to database
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connection successful!<br>";
}
