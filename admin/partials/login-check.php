<?php
// Authorization - Access Control
// Check whether the user is logged in or not

if (!isset($_SESSION['user'])) {
    // User not logged in
    // Set message and redirect to login page
    $_SESSION['no-login-message'] = "<div class='error'>Please login to access Admin Panel.</div>";
    // Redirect to login page
    header('Location: ' . SITEURL . 'admin/login.php');
    exit(); // Ensure script stops after redirect
}
