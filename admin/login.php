<?php
include('../config/constants.php');

// Check whether the submit button is clicked
if (isset($_POST['submit'])) {
    // Get the data from the login form
    $username = mysqli_real_escape_string($conn, $_POST['username']); // Using mysqli_real_escape_string to secure input
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Using mysqli_real_escape_string to secure input


    // SQL to check whether the user with username and password exists
    $sql = "SELECT * FROM tb_admin WHERE uname_ad='$username' AND pass_ad='$password'";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed successfully
    if ($res) {
        // Count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            // User available and login successful
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username; // To check whether the user is logged in or not and logout will unset it
            // Redirect to home page/dashboard
            header('location: ' . SITEURL . 'admin/');
            exit();
        } else {
            // User not available or login failed
            $_SESSION['login'] = "<div class='error'>Username or password did not match.</div>";
            // Redirect back to login page
            header('location: ' . SITEURL . 'admin/login.php');
            exit();
        }
    } else {
        // Query execution failed
        $_SESSION['login'] = "<div class='error'>Login failed due to database error.</div>";
        header('location: ' . SITEURL . 'admin/login.php');
        exit();
    }
}
?>

<!-- Your HTML for login form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="login text-center">
        <h1>Login</h1>
        <br><br>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <br><br>

        <!-- Login Form Start-->
        <form action="" method="POST">
            Username:
            <input type="text" name="username" placeholder="Enter Username"><br><br>
            Password:
            <input type="password" name="password" placeholder="Enter Password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
        </form>
        <!-- Login Form End -->

        <p>Created By - <a href="#">Erlangga Anugrah</a></p>
    </div>
</body>

</html>