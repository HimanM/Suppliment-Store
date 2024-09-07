<?php
include 'db_config.php'; // Database connection

header('Content-Type: application/json');

// Retrieve category, search, brand, min price, and max price from AJAX request
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';
$brand = $_GET['brand'] ?? '';
$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? PHP_INT_MAX; // No upper limit if not set

// Prepare the base SQL query
$sql = "SELECT * FROM products WHERE 1";

// Append search filter if set
if (!empty($search)) {
    $sql .= " AND name LIKE ?";
}

// Append category filter if set
if (!empty($category)) {
    $sql .= " AND category = ?";
}

// Append brand filter if set
if (!empty($brand)) {
    $sql .= " AND brand = ?";
}

// Append price range filter
$sql .= " AND price BETWEEN ? AND ?";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind parameters and execute
$searchTerm = "%{$search}%";
if (!empty($search) && !empty($category) && !empty($brand)) {
    $stmt->bind_param("sssss", $searchTerm, $category, $brand, $min_price, $max_price);
} elseif (!empty($search) && !empty($category)) {
    $stmt->bind_param("ssss", $searchTerm, $category, $min_price, $max_price);
} elseif (!empty($category) && !empty($brand)) {
    $stmt->bind_param("sss", $category, $brand, $min_price, $max_price);
} elseif (!empty($search)) {
    $stmt->bind_param("sss", $searchTerm, $min_price, $max_price);
} elseif (!empty($category)) {
    $stmt->bind_param("sss", $category, $min_price, $max_price);
} elseif (!empty($brand)) {
    $stmt->bind_param("sss", $brand, $min_price, $max_price);
} else {
    $stmt->bind_param("ss", $min_price, $max_price);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch all products and encode as JSON
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
?>
