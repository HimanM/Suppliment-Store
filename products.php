<?php
    include 'PHP/db_config.php';
    session_start();

    // Fetch unique categories
    $category_query = "SELECT DISTINCT category FROM products";
    $category_result = mysqli_query($conn, $category_query);

    // Fetch unique brands
    $brand_query = "SELECT DISTINCT brand FROM products";
    $brand_result = mysqli_query($conn, $brand_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <link rel="stylesheet" href="CSS/product_styles.css">
    <script src="JS/products.js" defer></script>
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class= "container mt-5">
        <div class="container my-2">
        <div class="row product-filter g-2">
            <div class="col-md-3">
                <input type="text" class="form-control" id="search" placeholder="Search products...">
            </div>

            <div class="col-md-3">
            <select id="category" class="form-select">
                <option value="">All Categories</option>
                <?php
                if (mysqli_num_rows($category_result) > 0) {
                    while ($row = mysqli_fetch_assoc($category_result)) {
                        echo '<option value="' . $row['category'] . '">' . $row['category'] . '</option>';
                    }
                }
                ?>
            </select>
            </div>

            <div class="col-md-3">
            <select id="brand" class="form-select">
                <option value="">All Brands</option>
                <?php
                if (mysqli_num_rows($brand_result) > 0) {
                    while ($row = mysqli_fetch_assoc($brand_result)) {
                        echo '<option value="' . $row['brand'] . '">' . $row['brand'] . '</option>';
                    }
                }
                ?>
            </select>
            </div>

            <div class="col-md-3">
                <div class="row g-2">
                    <div class="col">
                        <input type="number" id="min-price" class="form-control" min="1" placeholder="Min Price">
                    </div>
                    <div class="col">
                        <input type="number" id="max-price" class="form-control" min="1" placeholder="Max Price">
                    </div>
                </div>
            </div>
        </div>
    </div>


        <div id="product-cards" class="product-cards">
            <!-- Products will be dynamically inserted here -->
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
        <h2>Product Recommendations</h2>
        <div id="recommended-product-cards" class="product-cards">
            <!-- Products will be dynamically inserted here -->
        </div>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
    <script src="JS/chat_script.js"></script>
</body>
</html>
