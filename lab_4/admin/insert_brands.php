<?php
include('../includes/connect.php');

if (isset($_POST['Insert_brands'])) {
    $brand_title = $_POST['brand_title'];

    // Select from database
    $select_query = "SELECT * FROM `brands` WHERE brand_title='$brand_title'";
    $result_select = mysqli_query($conn, $select_query);

    if (!$result_select) {
        die("Query failed: " . mysqli_error($conn));
    }

    $number = mysqli_num_rows($result_select);
    if ($number > 0) {
        echo "<script>alert('Brand already exists in database')</script>";
    } else {
        $insert_query = "INSERT INTO `brands`(`brand_title`) VALUES ('$brand_title')";
        $result = mysqli_query($conn, $insert_query);

        if ($result) {
            echo "<script>alert('Brand has been inserted successfully')</script>";
        } else {
            die("Insert failed: " . mysqli_error($conn));
        }
    }
}
?>
<h2 class="text-center">Insert Brands</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="brand_title" placeholder="Insert Brands" aria-label="Username" aria-describedby="basic-addon1">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-info border-0 p-2 my-3" name="Insert_brands" value="Insert Brands">
    </div>
</form>