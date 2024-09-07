<?php
include 'PHP/db_config.php'; // Database connection

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve cart items for the logged-in user
$sql = "SELECT c.product_id, p.name, p.price, p.image_url, c.quantity 
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
    $total += $row['price'] * $row['quantity']; // Calculate total
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link rel="stylesheet" href="CSS/cart_styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'top_nav.php'; ?>
    <h1>Your Cart</h1>
    <div id="cart-items">
    <?php if (empty($cart_items)): ?>
            <p id="empty_msg">Your cart is currently empty.</p>
    <?php else: ?>
        <?php foreach ($cart_items as $item): ?>
            <div class="cart-item" data-product-id="<?php echo $item['product_id']; ?>">
                <img src="images/<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>">
                <h3><?php echo $item['name']; ?></h3>
                <p>$<?php echo $item['price']; ?></p>
                <input type="number" class="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                <button class="remove-from-cart">Remove</button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
    <?php if (!empty($cart_items)): ?>
        <div id="cart-total">
            <h2>Total: $<?php echo number_format($total, 2); ?></h2>
            <button id="checkout-btn">Checkout</button>
        </div>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/cart.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
