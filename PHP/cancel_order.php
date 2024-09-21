<?php
include 'db_config.php'; // Database connection
include 'api_handler.php'; 
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit();
}

if (!isset($_POST['order_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Order ID is required.']);
    exit();
}

$order_id = intval($_POST['order_id']);
$user_id = $_SESSION['user_id'];

// Fetch the order to confirm it belongs to the user and is not shipped or cancelled
$sql_order = "SELECT * FROM orders WHERE id = ? AND user_id = ? AND status != 'shipped' AND status != 'cancelled'";
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("ii", $order_id, $user_id);
$stmt_order->execute();
$order_result = $stmt_order->get_result();

if ($order_result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Order cannot be cancelled.']);
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch order items and return the stock to the inventory
$sql_items = "SELECT product_id, quantity FROM order_items WHERE order_id = ?";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items_result = $stmt_items->get_result();

while ($item = $items_result->fetch_assoc()) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];

    // Update stock in inventory
    $sql_update_stock = "UPDATE inventory SET stock = stock + ? WHERE product_id = ?";
    $stmt_update_stock = $conn->prepare($sql_update_stock);
    $stmt_update_stock->bind_param("ii", $quantity, $product_id);
    $stmt_update_stock->execute();
}

// Update order status to cancelled
$sql_cancel = "UPDATE orders SET status = 'cancelled' WHERE id = ?";
$stmt_cancel = $conn->prepare($sql_cancel);
$stmt_cancel->bind_param("i", $order_id);
$stmt_cancel->execute();

// Fetch user email
$sql_user = "SELECT email FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user = $user_result->fetch_assoc();
$user_email = $user['email'];

// Prepare email content
$email_subject = "Order#{$order['id']} Cancelled";
$order_id = $order['id'];
$order_total = number_format($order['total'], 2);

$email_body = "Dear Customer,\n\nYour order #{$order_id} has been cancelled.\n\n" .
              "Order Total: $$order_total\n\n" .
              "We apologize for any inconvenience.\n\n" .
              "Best regards,\nYour Supplement Store";

// Call the API to send the cancellation email
send_mail_api($user_email, $email_subject, $email_body );

echo json_encode(['status' => 'success', 'message' => 'Order cancelled and stock updated.']);
