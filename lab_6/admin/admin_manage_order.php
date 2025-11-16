<?php
session_start();
require_once __DIR__ . '/../includes/connect.php';

// Optional: admin-only gate
// if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
//     http_response_code(403);
//     exit('Forbidden');
// }

// Allowed statuses
$ALLOWED = ['pending','paid','processing','shipped','delivered','cancelled'];

// Helper escape
function e(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

// Handle POST update (inline per-row)
$flash = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
    $status   = $_POST['status'] ?? '';
    if ($order_id <= 0) {
        $flash = 'Bad order id.';
    } elseif (!in_array($status, $ALLOWED, true)) {
        $flash = 'Invalid status.';
    } else {
        $u = $conn->prepare("UPDATE orders SET status = ? WHERE id = ? LIMIT 1");
        $u->bind_param('si', $status, $order_id);
        if ($u->execute()) {
            $flash = 'Order status updated.';
        } else {
            $flash = 'Update failed.';
        }
        $u->close();
    }
}

// Filters
$statusFilter = isset($_GET['status']) && in_array($_GET['status'], $ALLOWED, true) ? $_GET['status'] : '';
$limit = 100;

// Fetch orders
$sql = "SELECT id, order_number, total_amount, payment_mode, status, created_at
        FROM orders";
if ($statusFilter !== '') { $sql .= " WHERE status = ?"; }
$sql .= " ORDER BY id DESC LIMIT ?";
$stmt = $conn->prepare($sql);
if ($statusFilter !== '') {
    $stmt->bind_param('si', $statusFilter, $limit);
} else {
    $stmt->bind_param('i', $limit);
}
$stmt->execute();
$orders = $stmt->get_result();

// Preload item counts and products per order (optional summary)
$itemCounts = [];
$it = $conn->query("SELECT order_id, COUNT(*) AS cnt FROM order_items GROUP BY order_id");
while ($r = $it->fetch_assoc()) { $itemCounts[(int)$r['order_id']] = (int)$r['cnt']; }
$it->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Order Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex align-items-center mb-3">
    <h1 class="me-auto mb-0">Order Management</h1>
    <form class="d-flex gap-2" method="get">
      <select name="status" class="form-select form-select-sm" style="width: 200px;">
        <option value="">All statuses</option>
        <?php foreach ($ALLOWED as $s): ?>
          <option value="<?= e($s) ?>" <?= $statusFilter===$s?'selected':'' ?>><?= e(ucfirst($s)) ?></option>
        <?php endforeach; ?>
      </select>
      <button class="btn btn-sm btn-primary">Filter</button>
    </form>
  </div>

  <?php if ($flash): ?>
    <div class="alert alert-info"><?= e($flash) ?></div>
  <?php endif; ?>

  <div class="table-responsive bg-white rounded shadow-sm">
    <table class="table table-sm align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th style="width:70px">ID</th>
          <th>Order #</th>
          <th style="width:130px">Total</th>
          <th style="width:120px">Payment</th>
          <th style="width:150px">Items</th>
          <th style="width:220px">Status</th>
          <th style="width:170px">Placed</th>
          <th style="width:160px">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($o = $orders->fetch_assoc()): 
        $oid    = (int)$o['id'];
        $cnt    = $itemCounts[$oid] ?? 0;
        $status = (string)$o['status'];
      ?>
        <tr>
          <td><?= $oid ?></td>
          <td><?= e($o['order_number'] ?? ('#'.$oid)) ?></td>
          <td><?= e((string)$o['total_amount']) ?></td>
          <td><?= e($o['payment_mode'] ?? '') ?></td>
          <td><?= $cnt ?></td>
          <td>
            <span class="badge <?= $status==='delivered'?'bg-success':($status==='cancelled'?'bg-danger':'bg-secondary') ?>">
              <?= e($status) ?>
            </span>
          </td>
          <td><?= e($o['created_at'] ?? '') ?></td>
          <td>
            <form method="post" class="d-flex gap-2 align-items-center">
              <input type="hidden" name="action" value="update_status">
              <input type="hidden" name="order_id" value="<?= $oid ?>">
              <select name="status" class="form-select form-select-sm" required>
                <?php foreach ($ALLOWED as $s): ?>
                  <option value="<?= e($s) ?>" <?= $status===$s?'selected':'' ?>><?= e(ucfirst($s)) ?></option>
                <?php endforeach; ?>
              </select>
              <button class="btn btn-sm btn-primary" type="submit">Save</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <p class="text-muted mt-3 mb-0">Showing latest <?= (int)$limit ?> orders<?= $statusFilter ? ' with status '.e($statusFilter) : '' ?>.</p>
</div>
</body>
</html>
