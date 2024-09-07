<?php
include 'db_config.php'; // Database connection

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

if ($rating < 1 || $rating > 5 || empty($comment)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit();
}

// Check if user has already reviewed this product
$sql_check = "SELECT id FROM reviews WHERE user_id = ? AND product_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $user_id, $product_id);
$stmt_check->execute();
$existing_review = $stmt_check->get_result()->fetch_assoc();

if ($existing_review) {
    echo json_encode(['status' => 'error', 'message' => 'You have already reviewed this product']);
    exit();
}

// Insert review
$sql_insert = "INSERT INTO reviews (user_id, product_id, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("iiis", $user_id, $product_id, $rating, $comment);
if ($stmt_insert->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Review submitted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit review']);
}
?>
