<?php
include 'PHP/check_role_admin.php';

if (!$authorized) {
    echo "Unauthorized access";
    exit();
}

// Fetch all products and their stock from the products and inventory tables
$query = "SELECT products.id, products.name, products.description, products.price, products.image_url, products.category, inventory.stock AS inventory_stock 
          FROM products 
          LEFT JOIN inventory ON products.id = inventory.product_id";
$result = $conn->query($query);
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link rel="stylesheet" href="CSS/manage_products.css">
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class="container mt-4">
        <h2>Manage Products</h2>
        <a href="edit_product.php" class="btn btn-success mb-3">Add New Product</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Inventory Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td><?= htmlspecialchars($product['inventory_stock']) ?></td>
                    <td><img src="../images/uploads/<?= htmlspecialchars($product['image_url']) ?>" alt="Product Image" width="50"></td>
                    <td>
                        <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
