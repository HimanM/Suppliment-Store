<?php
include 'PHP/db_config.php'; // Database connection
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch orders for the logged-in user
$sql = "SELECT * FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link rel="stylesheet" href="CSS/order_styles.css">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'top_nav.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Your Orders</h1>
    <div class="row">
        <?php if (empty($orders)): ?>
            <p class="text-center">You have no orders.</p>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order #<?php echo $order['id']; ?></h5>
                            <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
                            <p><strong>Payment Status:</strong> <?php echo $order['payment_status']; ?></p>
                            <p><strong>Total:</strong> $<?php echo number_format($order['total'], 2); ?></p>
                            <p><strong>Shipping Address:</strong> <?php echo $order['shipping_address']; ?></p>
                            <p><strong>Billing Address:</strong> <?php echo $order['billing_address']; ?></p>
                            
                            <?php if ($order['status'] !== 'shipped' && $order['status'] !== 'cancelled'): ?>
                                <button class="btn btn-danger cancel-order-btn" data-order-id="<?php echo $order['id']; ?>">Cancel Order</button>
                            <?php else: ?>
                                <p class="text-muted">This order cannot be cancelled.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script src="JS/order_script.js"></script>
<script src="JS/login_script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
