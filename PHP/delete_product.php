<?php
// delete_product.php
include 'db_config.php';

if (isset($_POST['id'])) {
    $product_id = $_POST['id'];

    // Delete the product from the 'products' table
    $delete_product_query = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_product_query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    $product_deleted = mysqli_stmt_execute($stmt);

    // Delete the product from the 'inventory' table
    $delete_inventory_query = "DELETE FROM inventory WHERE product_id = ?";
    $stmt2 = mysqli_prepare($conn, $delete_inventory_query);
    mysqli_stmt_bind_param($stmt2, 'i', $product_id);
    $inventory_deleted = mysqli_stmt_execute($stmt2);

    // Check if both deletions were successful
    if ($product_deleted && $inventory_deleted) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt2);
    mysqli_close($conn);
} else {
    echo json_encode(['success' => false]);
}
