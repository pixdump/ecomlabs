<?php
include('../includes/connect.php');
if (isset($_POST['Insert_cat'])) {
    $category_title = $_POST['cat_title'];
    //select from database

    $select_query = "SELECT * FROM `cateogries` WHERE category_title='$category_title';";

    $result_select = mysqli_query($conn, $select_query);
    $number = mysqli_num_rows($result_select);
    if ($number > 0) {
        echo "<script>alert('categories already exist in database')</script>";
    } else {



        $insert_query = "INSERT INTO `cateogries`(`category_title`) VALUES ('$category_title')";
        $result = mysqli_query($conn, $insert_query);
        if ($result) {
            echo "<script> alert('categories has been inserted successfully')</script>";
        }
    }
}

?>







<h2 class="text-center">Insert Categories</h2>
<form action="" method="post" class="mb-2">
    <div class="inut-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="cat_title" placeholder="Insert Categories" aria-label="Username"
            aria-describedby="basic-addon1">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-info border-0 p-2 my-3" name="Insert_cat" value="Insert Categories">
        <!-- <button class="bg-info p-2 my-3 border-0">Insert Categories</button> -->
    </div>
</form>