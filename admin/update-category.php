<?php include('partials/menu.php') ?>
<?php include('../config/constants.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
        // Check whether the id is set or not
        if (isset($_GET['id_cy'])) {
            // Get the id and all details
            $id = $_GET['id_cy'];
            // Create SQL query to get all the other details
            $sql = "SELECT * FROM category WHERE id_cy=$id";
            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Count the rows to check whether the id is valid or not
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                // Get all data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title_cy'];
                $current_image = $row['image_name_cy'];
                $featured = $row['featured_cy'];
                $active = $row['active_cy'];
            } else {
                // Redirect to manage category page
                $_SESSION['no-category-found'] = "<div class='error'>Category Not Found</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
                exit; // Exit to prevent further execution
            }
        } else {
            // Redirect to manage category page
            header('location:' . SITEURL . 'admin/manage-category.php');
            exit; // Exit to prevent further execution
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_cy" value="<?php echo $id; ?>">
            <table class="tbl-30">
                <tr>
                    <td>Title :</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                    <td>Current Image :</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            echo "<img src='" . SITEURL . "images/category/" . $current_image . "' width='150px'>";
                        } else {
                            echo "<div class='error'>Image Not Found</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td><input type="file" name="new_image"></td>
                </tr>
                <tr>
                    <td>Featured :</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if ($featured == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if ($featured == "No") echo "checked"; ?>> No
                    </td>
                </tr>
                <tr>
                    <td>Active :</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if ($active == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if ($active == "No") echo "checked"; ?>> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php') ?>

<?php
// Handle form submission
if (isset($_POST['submit'])) {
    // Get all the values from our form
    $id = $_POST['id_cy'];
    $title = $_POST['title'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // Check whether image is selected or not
    if (isset($_FILES['new_image']['name'])) {
        // Get the image details
        $image_name = $_FILES['new_image']['name'];

        if ($image_name != "") {
            // Image is available
            // Extract the file extension
            $ext = end(explode('.', $image_name));

            // Rename the image
            $image_name = "Food_category_" . rand(000, 999) . '.' . $ext;

            $source_path = $_FILES['new_image']['tmp_name'];
            $destination_path = "../images/category/" . $image_name;

            // Finally, upload the image
            $upload = move_uploaded_file($source_path, $destination_path);

            // Check whether the image is uploaded or not
            if ($upload == false) {
                // Set message
                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                // Redirect to the manage-category page
                header('Location: ' . SITEURL . 'admin/manage-category.php');
                // Stop Process
                die();
            }

            // Remove the current image if available
            if ($current_image != "") {
                $remove_path = "../images/category/" . $current_image;
                $remove = unlink($remove_path);

                // Check whether the image is removed or not
                if ($remove == false) {
                    // Failed to remove
                    $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image</div>";
                    // Redirect to manage category page
                    header('location:' . SITEURL . 'admin/manage-category.php');
                    die();
                }
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }

    // SQL query to update data
    $sql2 = "UPDATE category 
             SET title_cy='$title',
                 image_name_cy='$image_name',
                 featured_cy='$featured',
                 active_cy='$active'
             WHERE id_cy=$id";

    // Execute the query
    $res2 = mysqli_query($conn, $sql2);

    // Check if query executed successfully
    if ($res2) {
        $_SESSION['update'] = "<div class='success'>Category updated successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to update category.</div>";
        header('location:' . SITEURL . 'admin/manage-category.php');
    }
}
?>