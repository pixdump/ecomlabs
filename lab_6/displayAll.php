<!--connect file-->
<?php
include('./includes/connect.php');
include('functions/commonFunctions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
  <div class="container-fluid p-0">

    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
      <div class="container">
        <div class="logo-icon">🛍️</div>
        <a class="navbar-brand" href="index.php">ShopLite</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav ms-auto">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            <a class="nav-link" href="displayAll.php">Product</a>
            <a class="nav-link" href="#">Contact</a>
            <a class="nav-link" href="#">Register</a>
            <a class="nav-link" href="#"><i class="fas fa-cart-plus"></i></a>
          </div>
        </div>
      </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
      <div class="container">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Welcome Guest</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Login</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="bg-light py-3">
      <h3 class="text-center mb-0">Get the comfortable items at your door steps!!!</h3>
    </div>

    <div class="container my-4">
      <div class="row">

        <div class="col-md-10">
          <div class="row g-4">
            <?php
              getAllProducts();
              getProductByBrand();
              getProductByCategory();
            ?>
          </div>
        </div>

        <div class="col-md-2 bg-secondary text-white p-3 rounded">
          <!-- <h5 class="text-center bg-info p-2 rounded">Brands</h5>
          <ul class="nav flex-column mb-4">
            <?php getBrands(); ?>
          </ul> -->

          <h5 class="text-center bg-info p-2 rounded">Categories</h5>
          <ul class="nav flex-column">
            <?php getCategories(); ?>
          </ul>
        </div>

      </div>
    </div>

    <footer class="bg-info text-center text-white py-3">
      <p class="mb-0">All rights reserved to ShoesMart 2025</p>
    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>