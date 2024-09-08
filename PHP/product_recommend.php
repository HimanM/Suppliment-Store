<?php
include 'db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current recommendations
$sql = "SELECT product_id FROM recommendations WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$current_recommendations = [];
while ($row = $result->fetch_assoc()) {
    $current_recommendations[] = $row['product_id'];
}

// Fetch user products and their categories
$sql = "SELECT DISTINCT p.category FROM order_items oi 
        JOIN products p ON oi.product_id = p.id 
        WHERE oi.order_id IN (SELECT id FROM orders WHERE user_id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}

// Fetch higher-rated products from the same categories
$recommended_products = [];
if (!empty($categories)) {
    // Prepare the IN clause with placeholders
    $categories_in_clause = str_repeat('?,', count($categories) - 1) . '?';
    $sql = "SELECT id, name, description, price, rating, category 
            FROM products 
            WHERE category IN ($categories_in_clause) 
            AND id NOT IN (SELECT product_id FROM recommendations WHERE user_id = ?) 
            ORDER BY rating DESC, price ASC";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind the parameters
    $types = str_repeat('s', count($categories)) . 'i'; // Types string for bind_param
    $params = array_merge($categories, [$user_id]); // Merge categories and user_id into a single array
    
    // Use call_user_func_array to bind parameters dynamically
    $stmt->bind_param($types, ...$params);
    
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $recommended_products[] = $row;
    }
}

// Check if recommendations exceed 10 and delete older ones if needed
if (count($recommended_products) > 10) {
    $sql = "DELETE FROM recommendations WHERE user_id = ? AND product_id NOT IN (
            SELECT product_id FROM (
                SELECT product_id FROM recommendations WHERE user_id = ? ORDER BY recommended_at DESC LIMIT 10
            ) AS temp)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    // Fetch the latest 10 recommendations
    $sql = "SELECT product_id FROM recommendations WHERE user_id = ? ORDER BY recommended_at DESC LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_recommendations = [];
    while ($row = $result->fetch_assoc()) {
        $current_recommendations[] = $row['product_id'];
    }
}

// Insert new recommendations if there are any
if (!empty($recommended_products)) {
    foreach ($recommended_products as $product) {
        if (count($current_recommendations) < 10) {
            $sql = "INSERT INTO recommendations (user_id, product_id, recommended_at) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $user_id, $product['id']);
            $stmt->execute();
        }
    }
}

// For debugging purposes
echo "<pre>";
echo "Current Recommendations:\n";
print_r($current_recommendations);

echo "\nUser Categories:\n";
print_r($categories);

echo "\nRecommended Products:\n";
print_r($recommended_products);
echo "</pre>";

// Remove the debug code later and return a JSON response
// echo json_encode(["status" => "success"]);
?>
