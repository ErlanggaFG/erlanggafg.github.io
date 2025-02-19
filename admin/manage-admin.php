<?php include('partials/menu.php'); ?>

<!-- Main Content Section start -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; // Display session message
            unset($_SESSION['add']); // Remove session message
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }
        if (isset($_SESSION['pws_not_found'])) {
            echo $_SESSION['pws_not_found'];
            unset($_SESSION['pws_not_found']);
        }
        if (isset($_SESSION['change-pws'])) {
            echo $_SESSION['change-pws'];
            unset($_SESSION['change-pws']);
        }
        ?>
        <br /><br />
        <!-- Button to add admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Action</th>
            </tr>

            <?php
            // Query to get all admins
            $sql = "SELECT * FROM tb_admin";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Check whether the query is executed or not
            if ($res == TRUE) {
                // Count rows to check whether we have data in the database or not

                $count = mysqli_num_rows($res); // Function to get all rows in the database
                $sn = 1; //create variable and assign the value

                // Check the number of rows
                if ($count > 0) {
                    // We have data in the database
                    while ($rows = mysqli_fetch_assoc($res)) {
                        // Using while loop to get all the data from the database
                        // And while loop will run as long as we have data in the database
                        $id = $rows['id_ad'];
                        $full_name = $rows['nama_ad'];
                        $username = $rows['uname_ad'];
            ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id;  ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>

                    <?php
                    }
                } else {
                    // We do not have data in the database
                    ?>

                    <tr>
                        <td colspan="4">
                            <div class="error">No Admins Added.</div>
                        </td>
                    </tr>

            <?php
                }
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content Section End -->

<?php include('partials/footer.php'); ?>