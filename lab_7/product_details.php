<?php
include('includes/connect.php');

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    die("Invalid Product ID.");
}

$stmt = $conn->prepare("SELECT p.product_title, p.product_description, p.product_price, 
    p.product_image1, p.product_image2, p.product_image3, b.brand_title, c.category_title 
    FROM products p
    JOIN brands b ON p.brand_id = b.brand_id
    JOIN cateogries c ON p.category_id = c.category_id
    WHERE p.product_id = ? AND p.status = 'true'");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?php echo htmlspecialchars($product['product_title']); ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h1><?php echo htmlspecialchars($product['product_title']); ?></h1>
    <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand_title']); ?></p>
    <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category_title']); ?></p>
    <div class="row mb-4">
        <div class="col-md-6">
            <img src="/admin/product_images/<?php echo htmlspecialchars($product['product_image1']); ?>" class="img-fluid mb-3" alt="Image 1">
            <?php if (!empty($product['product_image2'])): ?>
                <img src="/admin/product_images/<?php echo htmlspecialchars($product['product_image2']); ?>" class="img-fluid mb-3" alt="Image 2">
            <?php endif; ?>
            <?php if (!empty($product['product_image3'])): ?>
                <img src="/admin/product_images/<?php echo htmlspecialchars($product['product_image3']); ?>" class="img-fluid mb-3" alt="Image 3">
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h3>Price: NPR <?php echo number_format($product['product_price'], 2); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($product['product_description'])); ?></p>
            <a href="displayAll.php" class="btn btn-secondary mt-3">Back to Catalog</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
