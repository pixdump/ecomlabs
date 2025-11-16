<?php
//including connect file 
include('./includes/connect.php');
//getting products
function getProducts(){
    global $conn;
    if(!isset($_GET['brand']) && !isset($_GET['category']) )
    {
       $select_query1 = "SELECT * FROM `products` order by rand() limit 0,3";
          $result_query1 = mysqli_query($conn, $select_query1);
          // $row_data1 = mysqli_fetch_assoc($result_query1);
          // echo $row_data ['product_title'];
          while($row_data1 = mysqli_fetch_assoc($result_query1))
          {
            $prod_id = $row_data1['product_id'];
            $prod_title = $row_data1['product_title'];
            $prod_desc = $row_data1['product_description'];
            $prod_img1 = $row_data1['product_image1'];
            $prod_price = $row_data1['product_price'];  
            $cat_id = $row_data1['category_id'];
            $brand_id = $row_data1['brand_id'];
            echo 
            "<div class='col-md-4'>
             
              <div class='card' style='width: 18rem;'>
                <img src='./admin/product_images/$prod_img1' class='card-img-top' alt='...'>
                <div class='card-body'>
                  <h5 class='card-title'>$prod_title</h5>
                    <p class='card-text'>$prod_desc</p>
                      <a href='#' class='btn btn-info'>Add To Cart</a>
                      <a href='#' class='btn btn-secondary'>View More</a>
                </div>
              </div>
            </div>";
            echo"</br>";
          }
      }
}
function getCategories(){
  global $conn;
    $select_categories="SELECT * FROM `cateogries` ";
     $result_select =mysqli_query($conn,$select_categories);
     while($row_data=mysqli_fetch_assoc($result_select))
     {
      $Category_Title=$row_data['category_title'];
      $Category_Id=$row_data['category_id'];
      echo"<li class='nav-item'>
      <a class='nav-link text-light' href='index.php?category=$Category_Id'><h4>$Category_Title</h4></a>
     </li>";
     
     }
}
function getBrands(){
  global $conn;
  
   $select_brands="SELECT * from `brands`";
     $result_select =mysqli_query($conn,$select_brands);
     while($row_data=mysqli_fetch_assoc($result_select))
     {
      $Brand_Title=$row_data['brand_title'];
      $Brand_Id=$row_data['brand_id'];
      echo"<li class='nav-item'>
      <a class='nav-link text-light' href='index.php?brand=$Brand_Id'><h4>$Brand_Title</h4></a>
     </li>";
     
     }
}
//Getting unique brand
function getProductByBrand(){
    global $conn;
    if(isset($_GET['brand']))
    {
      $brand_id = $_GET['brand'];
       $select_query1 = "SELECT * FROM `products` where brand_id =$brand_id ";
          $result_query1 = mysqli_query($conn, $select_query1);
           $num_of_rows = mysqli_num_rows($result_query1);
          if($num_of_rows == 0){
            echo"<h2 class='text-center text-danger'>No data is found under this brand.</h2>";

          }
          // $row_data1 = mysqli_fetch_assoc($result_query1);
          // echo $row_data ['product_title'];
          while($row_data1 = mysqli_fetch_assoc($result_query1))
          {
            $prod_id = $row_data1['product_id'];
            $prod_title = $row_data1['product_title'];
            $prod_desc = $row_data1['product_description'];
            $prod_img1 = $row_data1['product_image1'];
            $prod_price = $row_data1['product_price'];  
            $cat_id = $row_data1['category_id'];
            $brand_id = $row_data1['brand_id'];
            echo 
            "<div class='col-md-4'>
             
              <div class='card' style='width: 18rem;'>
                <img src='./admin/product_images/$prod_img1' class='card-img-top' alt='...'>
                <div class='card-body'>
                  <h5 class='card-title'>$prod_title</h5>
                    <p class='card-text'>$prod_desc</p>
                      <a href='#' class='btn btn-info'>Add To Cart</a>
                      <a href='#' class='btn btn-secondary'>View More</a>
                </div>
              </div>
            </div>";
            echo"</br>";
          }
      }

}

//getting function by unique category
function getProductByCategory(){
    global $conn;
    if(isset($_GET['category']))
    {
      $category_id = $_GET['category'];
       $select_query1 = "SELECT * FROM `products` where category_id = $category_id ";
          $result_query1 = mysqli_query($conn, $select_query1);
          $num_of_rows = mysqli_num_rows($result_query1);
          if($num_of_rows == 0){
            echo"<h2 class='text-center text-danger'>No data is found under this category.</h2>";

          }
          // $row_data1 = mysqli_fetch_assoc($result_query1);
          // echo $row_data ['product_title'];
          while($row_data1 = mysqli_fetch_assoc($result_query1))
          {
            $prod_id = $row_data1['product_id'];
            $prod_title = $row_data1['product_title'];
            $prod_desc = $row_data1['product_description'];
            $prod_img1 = $row_data1['product_image1'];
            $prod_price = $row_data1['product_price'];  
            $cat_id = $row_data1['category_id'];
            $brand_id = $row_data1['brand_id'];
            echo 
            "<div class='col-md-4'>
             
              <div class='card' style='width: 18rem;'>
                <img src='./admin/product_images/$prod_img1' class='card-img-top' alt='...'>
                <div class='card-body'>
                  <h5 class='card-title'>$prod_title</h5>
                    <p class='card-text'>$prod_desc</p>
                      <a href='#' class='btn btn-info'>Add To Cart</a>
                      <a href='#' class='btn btn-secondary'>View More</a>
                </div>
              </div>
            </div>";
            echo"</br>";
          }
      }

}

  function getAllProducts(){
    global $conn;
    if(!isset($_GET['brand']) && !isset($_GET['category']) )
    {
       $select_query1 = "SELECT * FROM `products` order by rand()";
          $result_query1 = mysqli_query($conn, $select_query1);
          // $row_data1 = mysqli_fetch_assoc($result_query1);
          // echo $row_data ['product_title'];
          while($row_data1 = mysqli_fetch_assoc($result_query1))
          {
            $prod_id = $row_data1['product_id'];
            $prod_title = $row_data1['product_title'];
            $prod_desc = $row_data1['product_description'];
            $prod_img1 = $row_data1['product_image1'];
            $prod_price = $row_data1['product_price'];  
            $cat_id = $row_data1['category_id'];
            $brand_id = $row_data1['brand_id'];
            echo 
            "<div class='col-md-4'>
             
              <div class='card' style='width: 18rem;'>
                <img src='./admin/product_images/$prod_img1' class='card-img-top' alt='...'>
                <div class='card-body'>
                  <h5 class='card-title'>$prod_title</h5>
                    <p class='card-text'>$prod_desc</p>
                      <a href='#' class='btn btn-info'>Add To Cart</a>
                      <a href='#' class='btn btn-secondary'>View More</a>
                </div>
              </div>
            </div>";
            echo"</br>";
          }
      }

    }

function searchProduct(){
    global $conn;
    if(isset($_GET['search_data_product']))

    {
      $search_data_value = $_GET['search_data'];
       $select_query1 = "SELECT * FROM products WHERE product_keywords LIKE '%$search_data_value%' order by rand() ";
          $result_query1 = mysqli_query($conn, $select_query1);
          // $row_data1 = mysqli_fetch_assoc($result_query1);
          // echo $row_data ['product_title'];
          while($row_data1 = mysqli_fetch_assoc($result_query1))
          {
            $prod_id = $row_data1['product_id'];
            $prod_title = $row_data1['product_title'];
            $prod_desc = $row_data1['product_description'];
            $prod_img1 = $row_data1['product_image1'];
            $prod_price = $row_data1['product_price'];  
            $cat_id = $row_data1['category_id'];
            $brand_id = $row_data1['brand_id'];
            echo 
            "<div class='col-md-4'>
             
              <div class='card' style='width: 18rem;'>
                <img src='./admin/product_images/$prod_img1' class='card-img-top' alt='...'>
                <div class='card-body'>
                  <h5 class='card-title'>$prod_title</h5>
                    <p class='card-text'>$prod_desc</p>
                      <a href='#' class='btn btn-info'>Add To Cart</a>
                      <a href='#' class='btn btn-secondary'>View More</a>
                </div>
              </div>
            </div>";
            echo"</br>";
          }
      }

}

function uuidv4()
{
  $data = random_bytes(16);

  $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
  $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
?>
