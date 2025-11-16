<?php
session_start();
require_once __DIR__ . '/../includes/connect.php';

// Optional admin gate
// if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
//     http_response_code(403);
//     exit('Forbidden');
// }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$product_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($product_id <= 0) {
    header('Location: ./index.php?soft_deleted=0&reason=bad_id');
    exit;
}

// Only flip to 'false' when currently active, return success if already inactive
$stmt = $conn->prepare("UPDATE products SET status = 'false' WHERE product_id = ? AND status <> 'false' LIMIT 1");
$stmt->bind_param('i', $product_id);
$stmt->execute();

$affected = $stmt->affected_rows; // 1 if changed from active to false, 0 if already false or not found
$stmt->close();

// Redirect with outcome
if ($affected >= 0) {
    $flag = $affected === 1 ? '1' : 'already';
    header("Location: ./index.php?soft_deleted={$flag}");
    exit;
}

header('Location: ./index.php?soft_deleted=0&reason=db_error');
exit;
