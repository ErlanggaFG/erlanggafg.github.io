<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br /><br />

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

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Category Title"></td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
if (isset($_POST['submit'])) {
    // Get data from form
    $title = $_POST['title'];
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";

    // Check if an image is selected
    if (isset($_FILES['image']['name'])) {
        // Upload the image
        $image_name = $_FILES['image']['name'];

        if ($image_name != "") {
            // Auto Rename the image
            $ext = end(explode('.', $image_name));
            $image_name = "Category_" . rand(000, 999) . '.' . $ext;

            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/category/" . $image_name;

            $upload = move_uploaded_file($source_path, $destination_path);

            // Check whether the image is uploaded or not
            if ($upload == false) {
                $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                header('location:' . SITEURL . 'admin/add-category.php');
                die();
            }
        }
    } else {
        $image_name = "";
    }

    // SQL query to insert category into the database
    $sql = "INSERT INTO category SET
            title_cy='$title',
            image_name_cy='$image_name',
            featured_cy='$featured',
            active_cy='$active'";

    $res = mysqli_query($conn, $sql);

    // Check whether the query executed or not and data is added
    if ($res == TRUE) {
        $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
        header('location:' . SITEURL . 'admin/add-category.php');
    }
}
?>