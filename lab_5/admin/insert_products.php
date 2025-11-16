<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../includes/connect.php');

if (isset($_POST['insert_product'])) {
    $product_Title = htmlspecialchars(trim($_POST['product_title']), ENT_QUOTES, 'UTF-8');
    $product_Desc  = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
    $product_Key   = htmlspecialchars(trim($_POST['product_keywords']), ENT_QUOTES, 'UTF-8');

    $product_Cat   = filter_var($_POST['product_category'], FILTER_VALIDATE_INT);
    $product_Brand = filter_var($_POST['product_brand'], FILTER_VALIDATE_INT);
    $product_Price = filter_var($_POST['product_price'], FILTER_VALIDATE_FLOAT);

    $product_Status = 'true';

    if (!$product_Title || !$product_Desc || !$product_Key || !$product_Cat || !$product_Brand || !$product_Price) {
        echo "<script>alert('Please fill all mandatory fields correctly');</script>";
        exit();
    }

    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $images = ['product_image1', 'product_image2', 'product_image3'];
    $uploadDir = './product_images/';
    $uploadedImages = [];

    foreach ($images as $imageField) {
        if (isset($_FILES[$imageField]) && $_FILES[$imageField]['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$imageField]['tmp_name'];
            $fileMimeType = mime_content_type($fileTmpPath);

            if (!in_array($fileMimeType, $allowedMimeTypes)) {
                echo "<script>alert('Invalid file type for {$imageField}. Only JPG, PNG, WEBP allowed.');</script>";
                exit();
            }

            $fileName = uniqid() . '_' . basename($_FILES[$imageField]['name']);
            if (!move_uploaded_file($fileTmpPath, $uploadDir . $fileName)) {
                echo "<script>alert('Failed to upload {$imageField}');</script>";
                exit();
            }
            $uploadedImages[] = $fileName;
        } else {
            echo "<script>alert('Please upload all three product images');</script>";
            exit();
        }
    }

    $stmt = $conn->prepare("INSERT INTO `products` (product_title, product_description, product_keywords, category_id, brand_id,
        product_image1, product_image2, product_image3, product_price, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");

    if (!$stmt) {
        error_log('Prepare failed: ' . $conn->error);
        echo "<script>alert('Database error. Please try again later.');</script>";
        exit();
    }

    $stmt->bind_param(
        "sssissssds",
        $product_Title,
        $product_Desc,
        $product_Key,
        $product_Cat,
        $product_Brand,
        $uploadedImages[0],
        $uploadedImages[1],
        $uploadedImages[2],
        $product_Price,
        $product_Status
    );

    if ($stmt->execute()) {
        echo "<script>alert('Product inserted successfully');</script>";
    } else {
        error_log('Execute failed: ' . $stmt->error);
        echo "<script>alert('Database error. Please try again later.');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Insert Products - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-title {
            color: #4a44f0;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
        }

        .required {
            color: red;
        }

        .btn-submit {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(41, 128, 232, 0.4);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #43a5ec, #00b2e3);
            box-shadow: 0 6px 20px rgba(41, 128, 232, 0.6);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="form-container shadow-sm">
        <h2 class="form-title">Add New Product</h2>
        <form method="POST" action="" enctype="multipart/form-data" novalidate>
            <div class="mb-3">
                <label for="product_title" class="form-label">Product Title <span class="required">*</span></label>
                <input type="text" class="form-control" id="product_title" name="product_title"
                    placeholder="Enter product title" required />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Product Description <span class="required">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="3"
                    placeholder="Enter product description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="product_keywords" class="form-label">Keywords <span class="required">*</span></label>
                <input type="text" class="form-control" id="product_keywords" name="product_keywords"
                    placeholder="Enter keywords separated by comma" required />
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="product_category" class="form-label">Category <span class="required">*</span></label>
                    <select class="form-select" id="product_category" name="product_category" required>
                        <option value="" disabled selected>Select category</option>
                        <?php
                        $categories = mysqli_query($conn, "SELECT * FROM cateogries");
                        while ($cat = mysqli_fetch_assoc($categories)) {
                            echo "<option value='{$cat['category_id']}'>{$cat['category_title']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="product_brand" class="form-label">Brand <span class="required">*</span></label>
                    <select class="form-select" id="product_brand" name="product_brand" required>
                        <option value="" disabled selected>Select brand</option>
                        <?php
                        $brands = mysqli_query($conn, "SELECT * FROM brands");
                        while ($brand = mysqli_fetch_assoc($brands)) {
                            echo "<option value='{$brand['brand_id']}'>{$brand['brand_title']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Price (NPR) <span class="required">*</span></label>
                <input type="number" min="0" class="form-control" id="product_price" name="product_price"
                    placeholder="Enter price" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Images<span class="required">*</span></label>
                <input type="file" class="form-control mb-2" name="product_image1" accept="image/*"  id="product_image1" required />
                <input type="file" class="form-control mb-2" name="product_image2" accept="image/*" id="product_image2" required />
                <input type="file" class="form-control" name="product_image3" accept="image/*" id="product_image3" required />
            </div>
            <div class="d-grid">
                <button type="submit" name="insert_product" class="btn btn-submit btn-lg">Insert Product</button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function () {
            $('#product_category').select2({
                placeholder: "Select Category",
                width: '100%',
                allowClear: true
            });
            $('#product_brand').select2({
                placeholder: "Select Brand",
                width: '100%',
                allowClear: true
            });
$("form").on("submit", function (e) {
    let valid = true;
    let messages = [];

    // Text fields
    $.each(["#product_title", "#description", "#product_keywords"], function (_, selector) {
        if (!$.trim($(selector).val())) {
            valid = false;
            messages.push($(selector).closest(".mb-3").find("label").text() + " is required.");
        }
    });

    // Select fields
    if (!$("#product_category").val()) {
        valid = false;
        messages.push("Category is required.");
    }
    if (!$("#product_brand").val()) {
        valid = false;
        messages.push("Brand is required.");
    }

    // Price
    const price = parseFloat($("#product_price").val());
    if (isNaN(price) || price <= 0) {
        valid = false;
        messages.push("Enter a valid price greater than 0.");
    }

    // Images
    $.each(["#product_image1", "#product_image2", "#product_image3"], function (_, selector) {
        const input = $(selector)[0];
        if (!input.files || input.files.length === 0) {
            valid = false;
            messages.push("Please select an image for " + $(selector).closest(".mb-3").find("label").text());
        } else {
            const file = input.files[0];
            const allowedTypes = ["image/jpeg", "image/png", "image/webp"];
            if ($.inArray(file.type, allowedTypes) === -1) {
                valid = false;
                messages.push("Image must be JPEG, PNG, or WEBP.");
            }
            if (file.size > 2 * 1024 * 1024) {
                valid = false;
                messages.push("Image must be less than 2MB.");
            }
        }
    });

    if (!valid) {
        e.preventDefault(); // STOP form submission
        alert(messages.join("\n"));
    }
});

        });
    </script>

    \
</body>

</html>