<?php
include('../includes/connect.php');
include('../functions/commonFunctions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Shoplite - Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-info shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../images/download.png" alt="Logo" class="me-2" style="height:40px;">
        <span>Admin Dashboard</span>
      </a>
      <div class="ms-auto text-white fw-semibold">Welcome, Admin</div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row flex-nowrap">
      <div class="col-auto col-md-3 col-lg-2 bg-secondary text-white min-vh-100 p-3">
        <div class="text-center mb-4">
          <!-- <img src="../images/78213026007-starbucks-valentines-day-beverage-duo.webp" alt="Admin" class="rounded-circle mb-2" style="width:80px; height:80px; object-fit:cover;"> -->
          <p class="fw-bold">Admin</p>
        </div>
        <div class="d-grid gap-2">
            <a href="insert_products.php" class="btn btn-info text-white"><i class="fa-solid fa-box"></i> Insert Products</a>
            <a href="add_customer.php" class="btn btn-info text-white"><i class="fa-solid fa-box"></i> Add Customers</a>

            <a href="index.php?list_products" class="btn btn-info text-white"><i class="fa-solid fa-eye"></i> View Products</a>
            <a href="index.php?insert_categories" class="btn btn-info text-white"><i class="fa-solid fa-tags"></i> Insert Categories</a>
            <a href="#" class="btn btn-info text-white"><i class="fa-solid fa-list"></i> View Categories</a>
            <a href="index.php?insert_brands" class="btn btn-info text-white"><i class="fa-solid fa-industry"></i> Insert Brands</a>
            <a href="#" class="btn btn-info text-white"><i class="fa-solid fa-eye"></i> View Brands</a>
            <a href="admin_manage_order.php" class="btn btn-info text-white"><i class="fa-solid fa-shopping-cart"></i> All Orders</a>
            <a href="#" class="btn btn-info text-white"><i class="fa-solid fa-credit-card"></i> All Payments</a>
            <a href="#" class="btn btn-info text-white"><i class="fa-solid fa-users"></i> List Users</a>
            <a href="#" class="btn btn-danger text-white"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
      </div>

      <div class="col py-4">
        <h3 class="text-center mb-4">Manage Details</h3>
        <div class="container">
          <?php
            if (isset($_GET['insert_categories'])) {
              include 'insert_categories.php';
            }
            if (isset($_GET['insert_brands'])) {
              include 'insert_brands.php';
            }
            if (isset($_GET['soft_deleted'])) {
              echo "<div class='alert alert-success'>Product disabled successfully.</div>";
            }
            if (isset($_GET['list_products'])) {
              getAllProductsListAdmin();
            }
          ?>
        </div>
      </div>
    </div>
  </div>

  <footer class="bg-info text-center text-white py-3 mt-auto">
    <p class="mb-0">&copy; 2025 ShopLite. All Rights Reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
