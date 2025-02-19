<?php
// include file constants.file
include('../config/constants.php');

// check whether the id and image_name value is set or not
if (isset($_GET['id']) and isset($_GET['image_name'])) {
    // get the value and delete
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //remove the physical image file is availabe
    if ($$image_name != "") {
        // image is availabe. so remove ut
        $path = "../images/category" . $image_name;
        // remove the image
        $remove = unlink($path);
        // if failed to remove image then add an error message and stop the proses
        if ($remove == false) {
            //set the session message
            $_SESSION['remove'] = "<div class='erroe'>Failed to remove Category Image</div>";
            // redirect to manage catagories page
            header('location' . SITEURL . 'admin/manage-catagory,php');
            // stop proses
            die();
        }
    }


    // Delete the category from database
    $sql = "DELETE FROM category WHERE id_cy = $id";
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed successfully or not
    if ($res == true) {
        $_SESSION['dlt-img'] = "<div class='success'>Category Deleted Successfully.</div>";

        // Remove the image if available
        if (!empty($image_name)) {
            $path = "../images/category/" . $image_name;
            // Remove the image file
            unlink($path);
        }
    } else {
        $_SESSION['dlt-img'] = "<div class='error'>Failed to Delete Category.</div>";
    }

    // Redirect to manage category page
    header('location:' . SITEURL . 'admin/manage-category.php');
} else {
    // Redirect to manage category page
    header('location:' . SITEURL . 'admin/manage-category.php');
}
