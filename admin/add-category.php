<?php
include('partials/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <!-- add categories start -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title :</td>
                    <td><input type="text" name="title" placeholder="Category Title"></td>
                </tr>

                <tr>
                    <td>Select Image :</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured :</td>
                    <td><input type="radio" name="featured" value="Yes">Yes</td>
                    <td><input type="radio" name="featured" value="No">No</td>
                </tr>
                <tr>
                    <td>Active :</td>
                    <td><input type="radio" name="active" value="Yes">Yes</td>
                    <td><input type="radio" name="active" value="No">No</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- add categories end -->

        <?php
        // Check whether the submit button is clicked or not
        if (isset($_POST['submit'])) {
            // Get the value from Category Form
            $title = $_POST['title'];

            // For radio input type, we need to check whether the button is selected or not
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            // Check whether the image is selected or not, and set the value for the image name accordingly
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                // Upload the file
                $image_name = $_FILES['image']['name'];

                // Get the highest current image number from the database
                $sql = "SELECT image_name_cy FROM category ORDER BY id_cy DESC LIMIT 1";
                $res = mysqli_query($conn, $sql);

                $new_image_number = 1;
                if ($res == TRUE && mysqli_num_rows($res) > 0) {
                    $row = mysqli_fetch_assoc($res);
                    $last_image_name = $row['image_name_cy'];

                    // Extract the number from the last image name
                    $last_image_number = (int) str_replace(['Food_category_', '.jpg'], '', $last_image_name);
                    $new_image_number = $last_image_number + 1;
                }

                // Rename image
                $image_name = "Food_category_" . $new_image_number . '.jpg';

                $source_path = $_FILES['image']['tmp_name'];
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
            } else {
                // Don't upload image and set image_name value as blank
                $image_name = "";
            }

            // Create SQL to insert category
            $sql = "INSERT INTO category SET
            title_cy='$title',
            image_name_cy='$image_name',
            featured_cy='$featured',
            active_cy='$active'
            ";

            // Execute the query and save in database
            $res = mysqli_query($conn, $sql);

            // Check whether the query executed or not
            if ($res == TRUE) {
                // Query execution successful
                $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                // Redirect to manage category
                header('Location:' . SITEURL . 'admin/manage-category.php');
            } else {
                // Failed to add category
                $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                // Redirect to manage category
                header('Location:' . SITEURL . 'admin/manage-category.php');
            }
        }
        ?>

    </div>
</div>

<?php include('partials/footer.php') ?>