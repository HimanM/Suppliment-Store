<?php
    include 'PHP/db_config.php'; // Database connection
    include 'PHP/api_handler.php';
    include 'PHP/set_notification.php';
    
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

    if ($order_id <= 0) {
        echo "Invalid order ID.";
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Fetch order details
    $sql_order = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("ii", $order_id, $user_id);
    $stmt_order->execute();
    $order_result = $stmt_order->get_result();

    if ($order_result->num_rows === 0) {
        echo "Order not found.";
        exit();
    }

    $order = $order_result->fetch_assoc();

    // Fetch order items
    $sql_items = "SELECT oi.quantity, oi.price, p.name 
                FROM order_items oi 
                JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = ?";
    $stmt_items = $conn->prepare($sql_items);
    $stmt_items->bind_param("i", $order_id);
    $stmt_items->execute();
    $items_result = $stmt_items->get_result();

    // Fetch user email
    $sql_user = "SELECT email FROM users WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $user_result = $stmt_user->get_result();
    $user = $user_result->fetch_assoc();
    $user_email = $user['email'];



    // Prepare email content
    $order_items_text = "";
    while ($item = $items_result->fetch_assoc()) {
        $order_items_text .= htmlspecialchars($item['name']) . " (Quantity: " . $item['quantity'] . ") - $" . number_format($item['price'], 2) . "\n";
    }

    $email_subject = "Order Confirmation - Order #" . $order['id'];
    $email_body = "Dear Customer,\n\n" .
                "Thank you for your purchase! Your order details are below:\n\n" .
                "Order ID: " . $order['id'] . "\n" .
                "Order Date: " . $order['created_at'] . "\n" .
                "Total: $" . number_format($order['total'], 2) . "\n" .
                "Shipping Address: " . htmlspecialchars($order['shipping_address']) . "\n" .
                "Billing Address: " . htmlspecialchars($order['billing_address']) . "\n" .
                "Payment Status: " . ucfirst($order['payment_status']) . "\n\n" .
                "Order Items:\n" .
                $order_items_text . "\n\n" .
                "We will notify you once your order is processed and shipped.\n\n" .
                "Best regards,\nSuppliment Store";

    $message = "Order Placed - Order #" . $order['id'];
    // Call the function to send the mail
    send_mail_api($user_email, $email_subject, $email_body );
    setNotification($user_id, $message)
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your purchase! Your order details are below:</p>

    <h2>Order #<?php echo $order['id']; ?></h2>
    <p><strong>Order Date:</strong> <?php echo $order['created_at']; ?></p>
    <p><strong>Total:</strong> $<?php echo number_format($order['total'], 2); ?></p>
    <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
    <p><strong>Billing Address:</strong> <?php echo htmlspecialchars($order['billing_address']); ?></p>
    <p><strong>Payment Status:</strong> <?php echo ucfirst($order['payment_status']); ?></p>

    <h3>Order Items:</h3>
    <ul>
        <?php
        // Reset items result pointer to the beginning for HTML display
        $items_result->data_seek(0);
        while ($item = $items_result->fetch_assoc()): ?>
            <li>
                <?php echo htmlspecialchars($item['name']); ?> 
                (Quantity: <?php echo $item['quantity']; ?>) 
                - $<?php echo number_format($item['price'], 2); ?>
            </li>
        <?php endwhile; ?>
    </ul>
    <?php
        include 'PHP/product_recommend.php';
    ?>
    <p>We will notify you once your order is processed and shipped.</p>
    <a href="index.php">Continue Shopping</a>
</body>
</html>

