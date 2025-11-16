<?php
include('./includes/connect.php');
include('./functions/commonFunctions.php');
$projectRoot = findProjectRoot(__DIR__);

if (!$projectRoot) {
    throw new RuntimeException('Could not locate project root (no style.css found).');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid p-0">

        <nav class="navbar navbar-expand-lg navbar-dark bg-info">
            <div class="container-fluid">
                <div class="logo-icon fs-2 me-3">🛍️</div>
                <a class="navbar-brand" href="#">ShopLite</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        <a class="nav-link" href="displayAll.php">Products</a>
                        <a class="nav-link" href="#">Contact</a>
                        <a class="nav-link" href="#">Register</a>
                        <a class="nav-link" href="#"><i class="fa-solid fa-cart-plus"></i></a>
                    </div>
                    <form class="d-flex ms-3" role="search" action="searchProduct.php" method="get">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data"/>
                        <input type="submit" class="btn btn-outline-light" value="Search" name="search_data_product"/>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Second child: Secondary Navbar -->
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

        <!-- Third child: Header info -->
        <div class="bg-light py-3">
            <h3 class="text-center mb-0">Get the comfortable items at your door steps!!!</h3>
        </div>

        <!-- Fourth child: Main content and sidebar -->
        <div class="container my-4">
            <div class="row">
                <!-- Main product area -->
                <div class="col-md-10">
                    <div class="row g-4">
                        <?php
                            searchProduct();
                            getProducts();
                            getProductByBrand();
                            getProductByCategory();
                        ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-2 bg-secondary text-white p-3 rounded">
                    <h4 class="bg-info text-center py-2 rounded mb-3">Brands</h4>
                    <ul class="nav flex-column mb-4">
                        <?php getBrands(); ?>
                    </ul>

                    <h4 class="bg-info text-center py-2 rounded mb-3">Categories</h4>
                    <ul class="nav flex-column">
                        <?php getCategories(); ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-info text-center text-white py-3">
            <p class="mb-0">All rights reserved to ShopLite 2025</p>
        </footer>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
