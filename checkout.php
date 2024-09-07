<?php
include 'PHP/db_config.php'; // Database connection

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve cart items for the logged-in user
$sql = "SELECT c.product_id, p.name, p.price, c.quantity 
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
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <h1>Checkout</h1>
    <div id="checkout-items">
        <?php foreach ($cart_items as $item): ?>
            <div class="checkout-item">
                <h3><?php echo $item['name']; ?></h3>
                <p>$<?php echo $item['price']; ?></p>
                <p>Quantity: <?php echo $item['quantity']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="checkout-total">
        <h2>Total: $<?php echo number_format($total, 2); ?></h2>
    </div>

    <!-- Form to capture address and credit card info -->
    <form action="PHP/process_checkout.php" method="POST">
        <h3>Shipping Address</h3>
        <label for="shipping_address">Shipping Address</label>
        <input type="text" id="shipping_address" name="shipping_address" required>

        <h3>Billing Address</h3>
        <label for="billing_address">Shipping Address</label>
        <input type="text" id="billing_address" name="billing_address" required>

        <h3>Payment Details</h3>
        <label for="card_number">Card Number</label>
        <input type="text" id="card_number" name="card_number" pattern="\d{16}" required>

        <label for="exp_date">Expiration Date</label>
        <input type="text" id="exp_date" name="exp_date" placeholder="MM/YY" required>

        <label for="cvv">CVV</label>
        <input type="text" id="cvv" name="cvv" pattern="\d{3}" required>

        <input type="hidden" name="total" value="<?php echo $total; ?>">

        <button type="submit">Complete Purchase</button>
    </form>
</body>
</html>
