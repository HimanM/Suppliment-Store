<?php
include 'db_config.php'; // Database connection
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$shipping_address = $_POST['shipping_address'];
$billing_address = $shipping_address;
$payment_status = 'paid'; // Assuming payment is processed
$order_status = 'pending'; // Order status upon checkout

// Fetch cart items
$sql = "SELECT c.product_id, p.price, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result();

// Calculate total order cost
$total = 0;
$order_items = [];

while ($item = $cart_items->fetch_assoc()) {
    $total += $item['price'] * $item['quantity'];
    $order_items[] = $item; // Store cart item info to insert into order_items
}

// Begin transaction
$conn->begin_transaction();

try {
    // Insert new order into the orders table
    $sql_order = "INSERT INTO orders (user_id, total, status, shipping_address, billing_address, payment_status) 
                  VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("idssss", $user_id, $total, $order_status, $shipping_address, $billing_address, $payment_status);
    $stmt_order->execute();

    // Get the newly created order ID
    $order_id = $stmt_order->insert_id;

    // Insert each item from the cart into the order_items table
    $sql_order_item = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                       VALUES (?, ?, ?, ?)";
    $stmt_order_item = $conn->prepare($sql_order_item);

    foreach ($order_items as $item) {
        $stmt_order_item->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $stmt_order_item->execute();

        // Update product stock in the inventory table
        $sql_update_stock = "UPDATE inventory SET stock = stock - ? WHERE product_id = ?";
        $stmt_update_stock = $conn->prepare($sql_update_stock);
        $stmt_update_stock->bind_param("ii", $item['quantity'], $item['product_id']);
        $stmt_update_stock->execute();
    }

    // Commit the transaction
    $conn->commit();

    // Clear the cart for the user
    $sql_clear_cart = "DELETE FROM cart WHERE user_id = ?";
    $stmt_clear_cart = $conn->prepare($sql_clear_cart);
    $stmt_clear_cart->bind_param("i", $user_id);
    $stmt_clear_cart->execute();

    // Redirect to order confirmation page or show success message
    header("Location: ../order_confirmation.php?order_id=" . $order_id);
    exit();

} catch (Exception $e) {
    // Rollback transaction if something goes wrong
    $conn->rollback();
    echo "Error processing your order: " . $e->getMessage();
}
?>
