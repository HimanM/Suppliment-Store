<?php
include 'PHP/db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user orders
$sql_orders = "SELECT id, created_at FROM orders WHERE user_id = ?";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
$orders = [];
while ($row = $result_orders->fetch_assoc()) {
    $orders[] = $row;
}

// Fetch user purchased products
$sql_products = "SELECT DISTINCT products.id, products.name FROM order_items 
                 JOIN products ON order_items.product_id = products.id 
                 JOIN orders ON orders.id = order_items.order_id 
                 WHERE orders.user_id = ?";
$stmt_products = $conn->prepare($sql_products);
$stmt_products->bind_param("i", $user_id);
$stmt_products->execute();
$result_products = $stmt_products->get_result();
$products = [];
while ($row = $result_products->fetch_assoc()) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disputes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <link rel="stylesheet" href="CSS/disputes_styles.css">
    
</head>
<body>
<?php include 'top_nav.php'; ?>
<div class="container mt-5">
    <div class="container mb-4 p-4 glass-card">
        <h2>Submit a Dispute</h2>

        <!-- Success message box -->
        <div id="message-box" class="success">Dispute successfully submitted!</div>
        <div id="dispute-form">
            <form action="PHP/submit_dispute.php" method="POST" enctype="multipart/form-data">
                <!-- Dispute Type -->
                <div class="form-group">
                    <label>Dispute Type</label><br>
                    <input type="radio" name="dispute_type" value="general" checked> General <br>
                    <input type="radio" name="dispute_type" value="order"> Order <br>
                    <input type="radio" name="dispute_type" value="product"> Product
                </div>

                <!-- Order Dropdown (hidden by default) -->
                <div class="form-group" id="order-dropdown" style="display:none;">
                    <label>Select Order</label>
                    <select name="order_id" class="form-control">
                        <option value="">Select Order</option>
                        <?php foreach ($orders as $order): ?>
                            <option value="<?= $order['id']; ?>">Order #<?= $order['id']; ?> - <?= $order['created_at']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Product Dropdown (hidden by default) -->
                <div class="form-group" id="product-dropdown" style="display:none;">
                    <label>Select Product</label>
                    <select name="product_id" class="form-control">
                        <option value="">Select Product</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product['id']; ?>"><?= $product['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Message -->
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" class="form-control" required></textarea>
                </div>

                <!-- Attachments -->
                <div class="form-group">
                    <label>Attachments (optional)</label>
                    <input type="file" name="attachment" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary mt-3">Submit Dispute</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="JS/dispute_scripts.js"></script>
<script src="JS/chat_script.js"></script>
<script src="JS/login_script.js"></script>
</body>
</html>
