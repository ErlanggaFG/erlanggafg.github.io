<?php
include('partials/menu.php');

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>


        <form action="" method="POST" enctype="multipart/from">
            <table class="tbl-30">
                <tr>
                    <td>Title :</td>
                    <td>
                        <input type="text" name="title" placeholder="nama makanan">
                    </td>
                </tr>
                <tr>
                    <td>Deskripsi :</td>
                    <td>
                        <textarea name="des" cols="30" rows="5" placeholder="Deskripsi makanan"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="num" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            //create php code to display category from database
                            //1. Create sql to get all active category from database
                            $sql = "SELECT * FROM category WHERE active='Yes'";

                            //executing the query 
                            $res = mysqli_query($conn, $sql);

                            //count row  to check  we hv  catagory or not
                            $count = mysqli_num_rows($res);

                            //if count is greater than zero  , we hv category else we do not hv categories
                            if ($count > 0) {
                                // we hv catagory
                                while ($row = mysqli_fetch_assoc($res)) {
                                    // get the detail  of categories
                                    $id = $row['id_fg'];
                                    $title = $row['title_fd'];
                            ?>

                                    <option value="<?php echo $id  ?>"><?php echo $title  ?></option>

                                <?php
                                }
                            } else {
                                //we do not hv categories
                                ?>
                                <option value="0"> No category Found</option>
                            <?php
                            }


                            //2. Display on drop down



                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="NO">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="NO">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>

                </tr>

            </table>


        </form>


    </div>
</div>






<?php include('partials/footer.php') ?>