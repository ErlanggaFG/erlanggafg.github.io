<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Categories</h1>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['dlt-img'])) {
            echo $_SESSION['dlt-img'];
            unset($_SESSION['dlt-img']);
        }
        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if (isset($_SESSION['remove-failed'])) {
            echo $_SESSION['remove-failed'];
            unset($_SESSION['remove-failed']);
        }
        ?>
        <br /><br />
        <!-- Button to add categories -->
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Categories</a>

        <br /><br /><br />
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>

            <?php
            // Query database
            $sql = "SELECT * FROM category";
            // Execute query
            $res = mysqli_query($conn, $sql);

            // Check if the query was successful
            if ($res) {
                // Count rows
                $count = mysqli_num_rows($res);

                // Serial number variable and assign value as 1
                $sn = 1;

                // Check whether we have data in the database or not
                if ($count > 0) {
                    // We have data
                    // Get data and display
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id_cy'];
                        $title = $row['title_cy'];
                        $image_name = $row['image_name_cy'];
                        $featured = $row['featured_cy'];
                        $active = $row['active_cy'];
            ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $title; ?></td>

                            <td>
                                <?php
                                // Check whether image name is available or not
                                if (!empty($image_name)) {
                                    echo "<img src='" . SITEURL . "images/category/" . $image_name . "' width='85rem'>";
                                } else {
                                    echo "<div class='error'>Image not Added</div>";
                                }
                                ?>
                            </td>

                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-category.php?id_cy=<?php echo $id; ?>" class="btn-secondary">Update Category</a>

                                <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                            </td>
                        </tr>

            <?php
                    }
                } else {
                    // We do not have data
                    echo "<tr><td colspan='6'><div class='error'>No Category Added</div></td></tr>";
                }
            } else {
                // Error executing query
                echo "<tr><td colspan='6'><div class='error'>Failed to retrieve data.</div></td></tr>";
            }
            ?>

        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>