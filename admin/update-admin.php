<?php
include('partials/menu.php');
require_once('../config/constants.php'); // Include database connection
?>

<!-- Rest of your code -->

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br /><br />

        <?php
        // 1. Get the Id of Selected Admin
        $id = $_GET['id'];

        // 2. Create SQL query to get the detail of the selected admin
        $sql = "SELECT * FROM tb_admin WHERE id_ad=$id"; // Add WHERE clause

        // Execute the Query
        $res = mysqli_query($conn, $sql);

        // Check whether the query is executed or not
        if ($res == TRUE) {
            // Check whether the data is available or not
            $count = mysqli_num_rows($res);

            // Check whether we have admin data or not
            if ($count == 1) {
                // Get the detail
                $row = mysqli_fetch_assoc($res);
                $full_name = $row['nama_ad'];
                $username = $row['uname_ad'];
            } else {
                // Redirect to manage admin page
                header('location: ' . SITEURL . 'admin/manage-admin.php');
                exit();
            }
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name; ?>" placeholder="Enter your new Name"></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" value="<?php echo $username; ?>" placeholder="Enter your new Username"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        // Check whether the submit button is clicked or not
        if (isset($_POST['submit'])) {
            // Get all the values from form to update
            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $username = $_POST['username'];

            // Create an SQL Query to Update Admin
            $sql = "UPDATE tb_admin SET 
                nama_ad = '$full_name',
                uname_ad = '$username'
                WHERE id_ad = $id";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Check whether the query executed successfully or not
            if ($res == TRUE) {
                // Query executed and admin updated
                $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div>";
                // Redirect to Manage Admin Page
                header('location: ' . SITEURL . 'admin/manage-admin.php');
            } else {
                // Failed to update admin
                $_SESSION['update'] = "<div class='error'>Failed to Update Admin.</div>";
                // Redirect to Manage Admin Page
                header('location: ' . SITEURL . 'admin/manage-admin.php');
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>