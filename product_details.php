<?php
include 'PHP/db_config.php'; // Database connection

session_start();

// Retrieve product ID from query string
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$query = "SELECT products.*, inventory.stock AS stock 
              FROM products 
              LEFT JOIN inventory ON products.id = inventory.product_id 
              WHERE products.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Check if product exists
if (!$product) {
    echo "Product not found.";
    exit();
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null;

// Fetch reviews
$sql_reviews = "SELECT r.*, u.username 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.product_id = ?";
$stmt_reviews = $conn->prepare($sql_reviews);
$stmt_reviews->bind_param("i", $product_id);
$stmt_reviews->execute();
$reviews = $stmt_reviews->get_result()->fetch_all(MYSQLI_ASSOC);

// Check if user has purchased the product
$has_purchased = false;
if ($is_logged_in) {
    $sql_purchase = "SELECT 1 FROM orders o
                     JOIN order_items oi ON o.id = oi.order_id
                     WHERE o.user_id = ? AND oi.product_id = ? AND o.status IN ('shipped', 'delivered')";
    $stmt_purchase = $conn->prepare($sql_purchase);
    $stmt_purchase->bind_param("ii", $user_id, $product_id);
    $stmt_purchase->execute();
    $has_purchased = $stmt_purchase->get_result()->num_rows > 0;
}

// Check if user has already reviewed this product
$has_reviewed = false;
if ($is_logged_in) {
    $sql_review_check = "SELECT 1 FROM reviews WHERE user_id = ? AND product_id = ?";
    $stmt_review_check = $conn->prepare($sql_review_check);
    $stmt_review_check->bind_param("ii", $user_id, $product_id);
    $stmt_review_check->execute();
    $has_reviewed = $stmt_review_check->get_result()->num_rows > 0;
}
?>

<?php include 'PHP/handle_review.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="CSS/product_details_styles.css">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'top_nav.php'; ?>

<div class="container mt-5">
    <div class="row">
        <!-- Product Image and Name -->
        <div class="col-md-4">
            <img src="images/<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p>Rating: <?php echo str_repeat('★', intval($product['rating'])) . str_repeat('☆', 5 - intval($product['rating'])); ?></p>
        </div>

        <!-- Product Details -->
        <div class="col-md-8">
            <p>Price: $<?php echo number_format($product['price'], 2); ?></p>
            <?php if (!empty($product['description'])): ?>
                <p>Description: <?php echo htmlspecialchars($product['description']); ?></p>
            <?php endif; ?>
            <?php if (!empty($product['detailed_description'])): ?>
                <p>Details: <?php echo htmlspecialchars($product['detailed_description']); ?></p>
            <?php endif; ?>

            <!-- Add to Cart Form -->
            <?php if ($product['stock'] > 0): ?>
                <hr>
                <h3>Add to Cart</h3>
                <form id="add-to-cart-form" method="POST" action="PHP/add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" max="<?php echo htmlspecialchars($product['stock']); ?>" value="1" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
            <?php else: ?>
                <p class="text-danger">Out of stock</p>
            <?php endif; ?>
        </div>
    </div>

    <hr>

    <!-- Reviews Section -->
    <h3>Reviews:</h3>
    <?php if ($reviews): ?>
        <?php foreach ($reviews as $review): ?>
            <div class="review mb-4">
                <h5>
                <?php echo htmlspecialchars(substr($review['username'], 0, 4) . str_repeat('*', strlen($review['username']) - 4)); ?>
                    <?php if ($is_logged_in && $review['user_id'] == $user_id): ?>
                        <span class="badge bg-info text-dark">Your review</span>
                    <?php endif; ?>
                </h5>
                <p>Rating: <?php echo str_repeat('★', intval($review['rating'])) . str_repeat('☆', 5 - intval($review['rating'])); ?></p>
                <p><?php echo htmlspecialchars($review['comment']); ?></p>
                <small><?php echo date('F j, Y', strtotime($review['created_at'])); ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No reviews yet.</p>
    <?php endif; ?>

    <?php if ($is_logged_in && $has_purchased && !$has_reviewed): ?>
        <hr>
        <h3>Leave a Review:</h3>
        <form id="review-form" method="POST" action="PHP/submit_review.php">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
            <div class="mb-3">
                <label for="rating" class="form-label">Rating:</label>
                <select id="rating" name="rating" class="form-select" required>
                    <option value="">Select Rating</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Comment:</label>
                <textarea id="comment" name="comment" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="JS/product_details.js"></script>
<script src="JS/login_script.js"></script>
</body>
</html>

