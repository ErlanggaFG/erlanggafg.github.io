<?php
// Include the constants.php file
include('../config/constants.php');


// 1. Get the ID of the admin to be deleted
$id = $_GET['id'];

// 2. Create SQL query to delete the admin
$sql = "DELETE FROM tb_admin WHERE id_ad=$id";

// Execute the query
$res = mysqli_query($conn, $sql);

// Check whether the query executed successfully or not
if ($res === TRUE) {
    // Query executed successfully and admin deleted
    $_SESSION['delete'] = '<div class="success">Admin Deleted Successfully</div>';
} else {
    // Failed to delete admin
    $_SESSION['delete'] = '<div class="error">Failed to Delete Admin</div>';
}
// Redirect to manage admin page with a message (success/error)
header('location: ' . SITEURL . 'admin/manage-admin.php');
exit();
?>

.