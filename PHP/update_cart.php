<?php
    include 'db_config.php'; // Database connection

    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    if (!is_numeric($quantity) || $quantity <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid quantity']);
        exit();
    }

    // Update cart item quantity
    $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $quantity, $user_id, $product_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Cart updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update cart']);
    }
?>
