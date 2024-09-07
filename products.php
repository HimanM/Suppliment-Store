<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="CSS/product_styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <script src="JS/products.js" defer></script>
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class="product-filter">
        <input type="text" id="search" placeholder="Search products...">
        
        <select id="category">
            <option value="">All Categories</option>
            <option value="Supplement">Supplement</option>
            <option value="Vitamins">Vitamins</option>
            <option value="Protein">Protein</option>
            <option value="Oils">Oils</option>
            <!-- Add more categories as needed -->
        </select>
        
        <select id="brand">
            <option value="">All Brands</option>
            <option value="brand1">Brand 1</option>
            <option value="brand2">Brand 2</option>
            <!-- Add more brands as needed -->
        </select>
        
        <input type="number" id="min-price" min="1" placeholder="Min Price">
        <input type="number" id="max-price" min="1" max = "100 "placeholder="Max Price">
    </div>

    <div id="product-cards" class="product-cards">
        <!-- Products will be dynamically inserted here -->
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="JS/login_script.js"></script>
</body>
</html>
