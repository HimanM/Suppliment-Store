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

// Fetch ordered items for each order
$order_items = [];
if (!empty($orders)) {
    $order_ids = array_column($orders, 'id');
    $placeholders = implode(',', array_fill(0, count($order_ids), '?'));
    
    $sql_items = "SELECT oi.*, p.name AS product_name FROM order_items oi
                  JOIN products p ON oi.product_id = p.id
                  WHERE oi.order_id IN ($placeholders)";
    $stmt_items = $conn->prepare($sql_items);
    $stmt_items->bind_param(str_repeat('i', count($order_ids)), ...$order_ids);
    $stmt_items->execute();
    $result_items = $stmt_items->get_result();

    while ($row = $result_items->fetch_assoc()) {
        $order_items[$row['order_id']][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <link rel="stylesheet" href="CSS/order_styles.css">
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
                    <div class="card fixed-height-card">
                        <div class="card-body">
                            <h5 class="card-title">Order #<?php echo $order['id']; ?></h5>
                            <hr class="my-4">
                            <div class="container">
                                <p class = "order-info"><strong>Status:</strong> <?php echo $order['status']; ?></p>
                                <p class = "order-info"><strong>Payment Status:</strong> <?php echo $order['payment_status']; ?></p>
                                <p class = "order-info"><strong>Total:</strong> $<?php echo number_format($order['total'], 2); ?></p>
                                <p class = "order-info"><strong>Shipping Address:</strong> <?php echo $order['shipping_address']; ?></p>
                                <p class = "order-info"><strong>Billing Address:</strong> <?php echo $order['billing_address']; ?></p>
                            </div>
                            <hr class="my-4">
                            <h6>Items:</h6>
                            <div class="container order-items">
                                <ul>
                                    <?php foreach ($order_items[$order['id']] as $item): ?>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span>
                                                <?php echo htmlspecialchars($item['product_name']); ?> 
                                                (Quantity: <?php echo $item['quantity']; ?>)
                                            </span>
                                            <?php if ($order['status'] === 'shipped' || $order['status'] === 'delivered'): ?>
                                                <a href="product_details.php?id=<?php echo $item['product_id']; ?>" class="btn btn-primary btn-sm">Review</a>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
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
<?php include 'footer.php'; ?>
<script src="JS/order_script.js"></script>
<script src="JS/chat_script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="JS/login_script.js"></script>
</body>
</html>
