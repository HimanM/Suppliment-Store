<?php
// Include set_notification function
include 'set_notification.php';
include 'check_role_admin.php';

if (!$authorized) {
    echo "Unauthorized access";
    exit();
}
    // Check the inventory table for products with stock <= 10
    $query = "SELECT i.product_id, i.stock, p.name 
              FROM inventory i
              JOIN products p ON i.product_id = p.id 
              WHERE i.stock <= 10";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $product_id = $row['product_id'];
            $stock = $row['stock'];
            $product_name = $row['name'];

            // Construct the message
            $message = "The product '$product_name' (ID: $product_id) is low on inventory. Currently, only $stock left.";

            // Call the set_notification function with the message
            setNotification($_SESSION['user_id'], $message);
        }
    }
?>
