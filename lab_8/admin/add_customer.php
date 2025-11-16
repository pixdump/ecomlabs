<?php
include('../includes/connect.php');

if (isset($_POST['add_customer'])) {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $postal_code = trim($_POST['postal_code'] ?? '');
    $country = trim($_POST['country'] ?? '');

    $errors = [];

    if (!$first_name)
        $errors[] = "First name is required.";
    if (!$last_name)
        $errors[] = "Last name is required.";
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "A valid email is required.";
    if (!$country)
        $errors[] = "Country is required.";

    if (!empty($errors)) {
        $error_message = implode("\\n", $errors);
        echo "<script>alert('$error_message');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO customers
            (first_name, last_name, email, phone, address, city, state, postal_code, country, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        if ($stmt) {
            $stmt->bind_param(
                "sssssssss",
                $first_name,
                $last_name,
                $email,
                $phone,
                $address,
                $city,
                $state,
                $postal_code,
                $country
            );

            if ($stmt->execute()) {
                $stmt->close();
                header("Location: add_customer.php?success=1");
                exit();
            } else {
                $db_error = $stmt->error;
                $stmt->close();
                echo "<script>alert('Database error: " . addslashes($db_error) . "');</script>";
            }
        } else {
            echo "<script>alert('Database prepare error.');</script>";
        }
    }
}

if (isset($_GET['success'])) {
    echo "<script>alert('Customer added successfully!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Customer - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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

        .btn-submit {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(41, 128, 232, 0.5);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #43a5ec, #00b2e3);
            box-shadow: 0 0 25px rgba(41, 128, 232, 0.7);
            transform: translateY(-2px);
        }
        .required {
            color: red;
            margin-left: 2px;
        }
    </style>
</head>

<body>
    <div class="form-container shadow-sm">
        <h2 class="form-title">Add New Customer</h2>
        <form method="POST" novalidate id="customerForm">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name <span class="required">*</span></label>
                <input type="text" class="form-control" id="first_name" name="first_name" required />
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name <span class="required">*</span></label>
                <input type="text" class="form-control" id="last_name" name="last_name" required />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="required">*</span></label>
                <input type="email" class="form-control" id="email" name="email" required />
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" />
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="2"></textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" />
                </div>
                <div class="col-md-6">
                    <label for="state" class="form-label">State</label>
                    <input type="text" class="form-control" id="state" name="state" />
                </div>
            </div>
            <div class="mb-3">
                <label for="postal_code" class="form-label">Postal Code</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" />
            </div>
            <div class="mb-4">
                <label for="country" class="form-label">Country <span class="required">*</span></label>
                <input type="text" class="form-control" id="country" name="country" required />
            </div>
            <div class="d-grid">
                <button type="submit" name="add_customer" class="btn btn-submit btn-lg">Add Customer</button>
            </div>
        </form>
    </div>

    <script>
        $(function () {
            $("#customerForm").on("submit", function (e) {
                let errors = [];

                if (!$.trim($("#first_name").val())) errors.push("First name is required.");
                if (!$.trim($("#last_name").val())) errors.push("Last name is required.");

                let email = $.trim($("#email").val());
                if (!email) {
                    errors.push("Email is required.");
                } else {
                    let emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailReg.test(email)) errors.push("Please enter a valid email address.");
                }

                if (errors.length > 0) {
                    e.preventDefault();
                    alert(errors.join("\n"));
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>