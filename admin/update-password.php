<?php
include('partials/menu.php');
require_once('../config/constants.php'); // Include database connection
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Old Password</td>
                    <td><input type="password" name="old_password" placeholder="Current Password"></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td><input type="password" name="new_password" placeholder="New Password"></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type="password" name="confirm_password" placeholder="Confirm Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $current_password = md5($_POST['old_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    $sql = "SELECT * FROM tb_admin WHERE id_ad = $id AND pass_ad = '$current_password'";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            if ($new_password == $confirm_password) {
                $sql2 = "UPDATE tb_admin SET pass_ad='$new_password' WHERE id_ad=$id";
                $res2 = mysqli_query($conn, $sql2);

                if ($res2 === true) {
                    $_SESSION['change-pws'] = "<div class='success'>Password Changed Successfully.</div>";
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                } else {
                    $_SESSION['change-pws'] = "<div class='error'>Failed to Change Password.</div>";
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            } else {
                $_SESSION['change-pws'] = "<div class='error'>Passwords Do Not Match.</div>";
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    } else {
        echo "Query execution failed.";
    }
}
?>

<?php include('partials/footer.php'); ?>