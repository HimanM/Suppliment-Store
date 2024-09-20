<?php
    include 'db_config.php'; // Include the database connection

    // Query to get the product IDs and calculate the average rating from the reviews table
    $sql = "SELECT product_id, AVG(rating) as avg_rating FROM reviews GROUP BY product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $avg_rating = $row['avg_rating'];

            // Update the product table with the calculated average rating
            $update_sql = "UPDATE products SET rating = ? WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("di", $avg_rating, $product_id);
            $stmt->execute();
        }
        echo "<script>console.log('Ratings updated successfully!');</script>";
    } else {
        echo "No ratings found.";
    }
?>
