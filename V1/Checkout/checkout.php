<?php
include 'PHP/db_config.php'; // Database connection

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve cart items for the logged-in user
$sql = "SELECT c.product_id, p.name, p.price, c.quantity, p.image_url 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link rel="stylesheet" href="CSS/checkout_styles.css">
</head>
<body>
<?php include 'top_nav.php'; ?>
<div class="container my-4">
    <h1 class="mb-4">Checkout</h1>

    <!-- Checkout Items Section -->
    <div id="checkout-items" class="mb-4">
        <h2 class="h5">Your Items</h2>
        <ul class="list-group">
            <?php foreach ($cart_items as $item): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="images/uploads/<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>" class="checkout-image me-3" style="width: 50px; height: 50px; object-fit: cover;">
                        <div>
                            <h6 class="mb-1"><?php echo $item['name']; ?></h6>
                            <p class="mb-0">Price: $<?php echo number_format($item['price'], 2); ?></p>
                            <p class="mb-0">Quantity: <?php echo $item['quantity']; ?></p>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Total Section -->
    <div id="checkout-total" class="mb-4">
        <h2 class="h5">Total: $<?php echo number_format($total, 2); ?></h2>
    </div>

    <!-- Shipping Address Section -->
    <form action="PHP/process_checkout.php" method="POST" class="mb-4">
        <h3>Shipping Address</h3>
        <div class="mb-3">
            <label for="shipping_address" class="form-label">Address</label>
            <input type="text" id="shipping_address" name="shipping_address" class="form-control" required>
        </div>

        <h3>Billing Address</h3>
        <div class="mb-3">
            <label for="billing_address" class="form-label">Address</label>
            <input type="text" id="billing_address" name="billing_address" class="form-control" required>
        </div>

        <h3>Payment Details</h3>
        <div class="border rounded p-3 mb-3">
            <h4 class="h6">Credit Card Information</h4>
            <div class="mb-3">
                <label for="card_number" class="form-label">Card Number</label>
                <input type="text" id="card_number" name="card_number" class="form-control" pattern="\d{16}" required>
            </div>
            <div class="mb-3">
                <label for="exp_date" class="form-label">Expiration Date (MM/YY)</label>
                <input type="text" id="exp_date" name="exp_date" class="form-control" placeholder="MM/YY" required>
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" id="cvv" name="cvv" class="form-control" pattern="\d{3}" required>
            </div>
        </div>

        <input type="hidden" name="total" value="<?php echo $total; ?>">
        <button type="submit" class="btn btn-primary">Complete Purchase</button>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
