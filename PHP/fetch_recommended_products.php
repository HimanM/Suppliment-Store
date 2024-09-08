<?php
include 'db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch product recommendations from the recommendations table
$sql = "SELECT product_id FROM recommendations WHERE user_id = ? ORDER BY recommended_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$recommended_products = [];

while ($row = $result->fetch_assoc()) {
    $recommended_products[] = $row['product_id'];
}

// Fetch product details for recommended products
$product_details = [];
if (count($recommended_products) > 0) {
    $in_clause = str_repeat('?,', count($recommended_products) - 1) . '?';
    $sql = "SELECT * FROM products WHERE id IN ($in_clause)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('i', count($recommended_products)), ...$recommended_products);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $product_details[] = $row;
    }
}

// Return the product details as JSON
echo json_encode($product_details);
?>
