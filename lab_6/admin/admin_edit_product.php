<?php
require_once __DIR__ . '/../includes/connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
function e(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
if ($product_id <= 0) {
    http_response_code(400);
    exit('Invalid product id.');
}

$brands = [];
$cats   = [];
if ($res = $conn->query("SELECT brand_id, brand_title FROM brands ORDER BY brand_title ASC")) {
    while ($r = $res->fetch_assoc()) { $brands[] = $r; }
    $res->close();
}
if ($res = $conn->query("SELECT category_id, category_title FROM cateogries ORDER BY category_title ASC")) {
    while ($r = $res->fetch_assoc()) { $cats[] = $r; }
    $res->close();
}

$stmt = $conn->prepare("
    SELECT product_id, product_title, product_description, product_keywords,
           category_id, brand_id, product_image1, product_image2, product_image3,
           product_price, status
    FROM products
    WHERE product_id = ?
    LIMIT 1
");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$current = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$current) {
    http_response_code(404);
    exit('Product not found.');
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['product_title'] ?? '');
    $desc    = trim($_POST['product_description'] ?? '');
    $keys    = trim($_POST['product_keywords'] ?? '');
    $brandId = (int)($_POST['brand_id'] ?? 0);
    $catId   = (int)($_POST['category_id'] ?? 0);
    $price   = trim($_POST['product_price'] ?? '');
    $status  = trim($_POST['status'] ?? '');

    if ($title === '')   { $errors[] = 'Title is required.'; }
    if ($desc === '')    { $errors[] = 'Description is required.'; }
    if ($keys === '')    { $errors[] = 'Keywords are required.'; }
    if ($brandId <= 0)   { $errors[] = 'Brand is required.'; }
    if ($catId <= 0)     { $errors[] = 'Category is required.'; }
    if ($price === '')   { $errors[] = 'Price is required.'; }
    if ($status === '')  { $errors[] = 'Status is required.'; }

    $images = [
        'product_image1' => $current['product_image1'],
        'product_image2' => $current['product_image2'],
        'product_image3' => $current['product_image3'],
    ];

    $uploadDir = __DIR__ . "/product_images/";
    if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }

    foreach (['product_image1','product_image2','product_image3'] as $imgField) {
        if (!empty($_FILES[$imgField]['name'])) {
            $file = $_FILES[$imgField];

            if ($file['error'] === UPLOAD_ERR_OK) {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime  = $finfo->file($file['tmp_name']);
                $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
                if (!in_array($mime, $allowed, true)) {
                    $errors[] = "$imgField must be jpg, png, webp, or gif.";
                    continue;
                }
                if ($file['size'] > 2 * 1024 * 1024) {
                    $errors[] = "$imgField must be <= 2MB.";
                    continue;
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $safeName = 'p'.$product_id.'_'.$imgField.'_'.time().'.'.$ext;

                if (!move_uploaded_file($file['tmp_name'], $uploadDir . $safeName)) {
                    $errors[] = "Failed to upload $imgField.";
                } else {
                    $images[$imgField] = $safeName; // replace only if upload ok
                }
            } elseif ($file['error'] !== UPLOAD_ERR_NO_FILE) {
                $errors[] = "Upload error on $imgField.";
            }
        }
    }

    if (!$errors) {
        $stmt = $conn->prepare("
            UPDATE products
               SET product_title = ?,
                   product_description = ?,
                   product_keywords = ?,
                   category_id = ?,
                   brand_id = ?,
                   product_image1 = ?,
                   product_image2 = ?,
                   product_image3 = ?,
                   product_price = ?,
                   status = ?
             WHERE product_id = ?
             LIMIT 1
        ");
        $stmt->bind_param(
            'sssiissssii',
            $title,
            $desc,
            $keys,
            $catId,
            $brandId,
            $images['product_image1'],
            $images['product_image2'],
            $images['product_image3'],
            $price,
            $status,
            $product_id
        );
        $stmt->close();

        $stmt2 = $conn->prepare("
            UPDATE products
               SET product_title = ?, product_description = ?, 
               product_keywords = ?, category_id = ?,
               brand_id = ?, product_image1 = ?, 
               product_image2 = ?, product_image3 = ?, 
               product_price = ?, status = ?
             WHERE product_id = ?
             LIMIT 1
        ");
        $typeString = 'sss' . 'ii' . 'sss' . 'ss' . 'i'; // => sss i i s s s s s i (compact: sss i i s s s s s i)
        // For clarity, write compact without spaces:
        $typeString = 'sss' . 'ii' . 'sss' . 'ss' . 'i'; // final: sssii ss sss si (we'll just write literal)
        $typeString = 'sssiisssssi';
        $stmt2->bind_param(
            $typeString, $title, $desc, $keys, $catId, $brandId,
            $images['product_image1'], $images['product_image2'],
            $images['product_image3'], $price, $status, $product_id
        );

        if ($stmt2->execute()) {
            $success = true;
            $stmt2->close();
            $ref = $conn->prepare("
                SELECT product_id, product_title, product_description, product_keywords,
                       category_id, brand_id, product_image1, product_image2, product_image3,
                       product_price, status
                FROM products
                WHERE product_id = ?
                LIMIT 1
            ");
            $ref->bind_param('i', $product_id);
            $ref->execute();
            $current = $ref->get_result()->fetch_assoc();
            $ref->close();
            echo "<script>alert('Product updated successfully.')</script>";
        } else {
            $errors[] = 'Update failed. Please try again.';
            $stmt2->close();
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Product</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h1 class="mb-4">Edit Product</h1>

  <?php if ($success): ?>
    <div class="alert alert-success">Product updated successfully.</div>
  <?php endif; ?>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $er): ?>
          <li><?= e($er) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" class="row g-3 bg-white p-3 rounded shadow-sm">
    <div class="col-md-6">
      <label class="form-label">Title</label>
      <input type="text" name="product_title" class="form-control" value="<?= e($current['product_title']) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Keywords</label>
      <input type="text" name="product_keywords" class="form-control" value="<?= e($current['product_keywords']) ?>" required>
    </div>
    <div class="col-12">
      <label class="form-label">Description</label>
      <textarea name="product_description" rows="4" class="form-control" required><?= e($current['product_description']) ?></textarea>
    </div>

    <div class="col-md-6">
      <label class="form-label">Brand</label>
      <select name="brand_id" class="form-select" required>
        <option value="">Select brand…</option>
        <?php foreach ($brands as $b): ?>
          <option value="<?= (int)$b['brand_id'] ?>" <?= $current['brand_id']==$b['brand_id']?'selected':'' ?>>
            <?= e($b['brand_title']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Category</label>
      <select name="category_id" class="form-select" required>
        <option value="">Select category…</option>
        <?php foreach ($cats as $c): ?>
          <option value="<?= (int)$c['category_id'] ?>" <?= $current['category_id']==$c['category_id']?'selected':'' ?>>
            <?= e($c['category_title']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Price</label>
      <input type="text" name="product_price" class="form-control" value="<?= e($current['product_price']) ?>" required>
    </div>

    <div class="col-md-4">
      <label class="form-label">Status</label>
      <select name="status" class="form-select" required>
        <option value="true"  <?= $current['status']==='true'?'selected':'' ?>>Active</option>
        <option value="false" <?= $current['status']!=='true'?'selected':'' ?>>Inactive</option>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label d-block">Current Images</label>
      <div class="d-flex gap-2 flex-wrap">
        <?php foreach (['product_image1','product_image2','product_image3'] as $imgField): ?>
          <?php if (!empty($current[$imgField])): ?>
            <img src="product_images/<?= e($current[$imgField]) ?>" class="img-thumbnail" style="width:90px;height:90px;object-fit:cover;" alt="">
          <?php else: ?>
            <div class="border d-flex align-items-center justify-content-center bg-light" style="width:90px;height:90px;">None</div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="col-md-4">
      <label class="form-label">Replace Image 1</label>
      <input type="file" name="product_image1" accept="image/*" class="form-control">
    </div>
    <div class="col-md-4">
      <label class="form-label">Replace Image 2</label>
      <input type="file" name="product_image2" accept="image/*" class="form-control">
    </div>
    <div class="col-md-4">
      <label class="form-label">Replace Image 3</label>
      <input type="file" name="product_image3" accept="image/*" class="form-control">
    </div>

    <div class="col-12 d-flex gap-2">
      <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Save</button>
      <a href="admin_products_list.php" class="btn btn-secondary">Back</a>
    </div>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
