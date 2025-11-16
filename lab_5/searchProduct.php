<!--connect file-->
<?php
include('./includes/connect.php');
include('./functions/commonFunctions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Store</title>
    <!--Bootstrap  css link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <!--My Awesome fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- style -->
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
   <!--Navbar-->
<!--site navbar-->
<div class="container-fluid p-0">

<!--First child-->
  <nav class="navbar navbar-expand-lg bg-body-tertiary bg-info">
  <div class="container-fluid">
    <img src="./logo.jpg" class="logo" >
    <a class="navbar-brand" href="#">SnapCart</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        <a class="nav-link" href="displayAll.php">Product</a>
        <a class="nav-link" href="#">Contact</a>
         <a class="nav-link" href="#">Register</a>
        <a class="nav-link" href="#"><i class="fa-solid fa-cart-plus"></i></a> 
      </div>
    </div>
  </div>
  <form class="d-flex" role="search" action="searchProduct.php" method="get">
      <input class="form-control me-2" type="text" placeholder="Search" aria-label="Search"/>
      
      <input type="submit" class='btn btn-outline-light' value="Search" name="search_data_product">
    </form>
</nav>

<!--second child-->
<nav class ="navbar navbar-expand-lg navbar-dark bg-secondary">
  <ul class ="navbar-nav me-auto">
    <li class ="nav-item">
      <a class="nav-link" href="#">Welcome Guest</a>
    </li>
    <li class ="nav-item">
      <a class="nav-link" href="#">Login</a>
    </li>
  </ul>
</nav>

<!-- Third child-->
 <div class="bg-light">
  <h3 class="text-center">Hidden store</h3>
  <h3 class="text-center">Get the comfortable shoes at your door steps!!!</h3>
 </div>

 <!-- Fourth child-->
  <div class="row">
    <div class="col-md-10">
      <!--Product list-->
      <div class="row">
        <!--fetching products-->
        
       <?php
          //calling function
          searchProduct();
          getProductByBrand();
          getProductByCategory();
          //    $select_query1 = "SELECT * FROM `products`";
          // $result_query1 = mysqli_query($conn, $select_query1);
          // // $row_data1 = mysqli_fetch_assoc($result_query1);
          // // echo $row_data ['product_title'];
          // while($row_data1 = mysqli_fetch_assoc($result_query1)){
          //   $prod_id = $row_data1['product_id'];
          //   $prod_title = $row_data1['product_title'];
          //   $prod_desc = $row_data1['product_description'];
          //   $prod_img1 = $row_data1['product_image1'];
          //   $prod_price = $row_data1['product_price'];
          //   $cat_id = $row_data1['category_id'];
          //   $brand_id = $row_data1['brand_id'];
          //   echo 
          //   "<div class='col-md-4'>
             
          //     <div class='card' style='width: 18rem;'>
          //       <img src='./admin/product_images/$prod_img1' class='card-img-top' alt='...'>
          //       <div class='card-body'>
          //         <h5 class='card-title'>$prod_title</h5>
          //           <p class='card-text'>$prod_desc</p>
          //             <a href='#' class='btn btn-info'>Add To Cart</a>
          //             <a href='#' class='btn btn-secondary'>View More</a>
          //       </div>
          //     </div>
          //   </div>";
          //   echo"</br>";
          // }

        ?>

      </div>

    </div>
    <div class="col-md-2 bg-secondary p-0">
    <!--side nav-->
     <!--Brand to be displayed-->
    <ul class="navbar-nav me-auto text-center">

     <li class="nav-item bg-info">
      <a class="nav-link text-light" href="#"><h4>Delivery Brands</h4></a>
     </li>

     <?php
     getBrands();
    //  $select_brands="SELECT * from `brands`";
    //  $result_select =mysqli_query($conn,$select_brands);
    //  while($row_data=mysqli_fetch_assoc($result_select))
    //  {
    //   $Brand_Title=$row_data['brand_title'];
    //   $Brand_Id=$row_data['brand_id'];
    //   echo"<li class='nav-item'>
    //   <a class='nav-link text-light' href='index.php?brand=$Brand_Id'><h4>$Brand_Title</h4></a>
    //  </li>";
     
    //  }
    ?>
     
    <!--   <li class="nav-item">
      <a class="nav-link text-light" href="#"><h4>Brand One</h4></a>
      </li>
     <li class="nav-item ">
      <a class="nav-link text-light" href="#"><h4>Brand Two</h4></a>
     </li>
      <li class="nav-item ">
      <a class="nav-link text-light" href="#"><h4>Brand Three</h4></a>
      </li>
      <li class="nav-item ">
      <a class="nav-link text-light" href="#"><h4>Brand Four</h4></a>
     </li> -->
    </ul>
     <!--category to be displayed-->
     <ul class="navbar-nav me-auto text-center">
     <li class="nav-item bg-info">
      <a class="nav-link text-light" href="#"><h4>Categories</h4></a>
     </li>


     <?php
     getCategories();
    //  $select_categories="SELECT * from `categories`";
    //  $result_select =mysqli_query($conn,$select_categories);
    //  while($row_data=mysqli_fetch_assoc($result_select))
    //  {
    //   $Category_Title=$row_data['category_title'];
    //   $Category_Id=$row_data['category_id'];
    //   echo"<li class='nav-item'>
    //   <a class='nav-link text-light' href='index.php?category=$Category_Id'><h4>$Category_Title</h4></a>
    //  </li>";
     
    //  }
    ?>
    <!--
     <li class="nav-item">
      <a class="nav-link text-light" href="#"><h4>Category One</h4></a>
     </li>
     <li class="nav-item ">
      <a class="nav-link text-light" href="#"><h4>Category Two</h4></a>
     </li>
     <li class="nav-item ">
      <a class="nav-link text-light" href="#"><h4>Category Three</h4></a>
     </li>
     <li class="nav-item ">
      <a class="nav-link text-light" href="#"><h4>Category Four</h4></a>
     </li>
    -->

    </ul>
     
      </div>
    </div>

  <div class="row">
    <div class="col-md-10"></div>
    <!--products-->
  </div>

  </div>
  <!-- <p> Welcome to My Store</p> -->
    <!--Last child-->
    <div class="bg-info p-3 text-center">
        <p> All right reserved to ShoesMart 2025</p>

    </div>
    
    
    <!--link for Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  

    
</body>
</html>