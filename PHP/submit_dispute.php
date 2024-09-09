<?php
include 'db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    
}

$user_id = $_SESSION['user_id'];
$disputeType = $_POST['dispute_type'];
$message = $_POST['message'];
$orderId = $_POST['order_id'] ?? null;
$productId = $_POST['product_id'] ?? null;
$attachment = null;

// Handle file upload
if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['attachment']['tmp_name'];
    $fileName = $_FILES['attachment']['name'];
    $destination = "../images/disputeDocs/" . $fileName;
    move_uploaded_file($fileTmpPath, $destination);
    $attachment = $fileName;
}

// Insert the dispute into the disputes table
$sql = "INSERT INTO disputes (user_id, dispute_type, order_id, product_id, message, attachment) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ississ", $user_id, $disputeType, $orderId, $productId, $message, $attachment);
$stmt->execute();

header('Location: ../disputes.php?success=true');
?>
