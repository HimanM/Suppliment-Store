<?php
include 'PHP/check_role_admin.php';

if (!$authorized) {
    echo "Unauthorized access";
    exit();
}

$product_id = isset($_GET['id']) ? intval($_GET['id']) : null;
$is_editing = $product_id !== null;

$product = ['name' => '', 'description' => '', 'detailed_description' => '', 'price' => '', 'category' => '', 'brand' => '', 'image_url' => ''];
$inventory_stock = '';

// If editing, fetch the product and its stock
if ($is_editing) {
    $query = "SELECT products.*, inventory.stock AS inventory_stock 
              FROM products 
              LEFT JOIN inventory ON products.id = inventory.product_id 
              WHERE products.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (is_null($product['detailed_description'])) {
        $product['detailed_description'] = '';  // Fallback to empty string for the form
    }

    $inventory_stock = $product['inventory_stock'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $detailed_description = !empty($_POST['detailed_description']) ? $_POST['detailed_description'] : null;  // Allow null
    $price = $_POST['price'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $inventory_stock = $_POST['inventory_stock'];

    // Handle image upload
    $image_url = $product['image_url'];  // Default to existing image if not updated
    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "images/uploads/";
        $target_file = $target_dir . $image_name;

        // Move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = $image_name;  // Save the new image name
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    if ($is_editing) {
        // Update product
        $query = "UPDATE products SET name = ?, description = ?, detailed_description = ?, price = ?, category = ?, brand = ?, image_url = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssi", $name, $description, $detailed_description, $price, $category, $brand, $image_url, $product_id);
        $stmt->execute();

        // Update inventory
        $query = "UPDATE inventory SET stock = ?, last_updated = NOW() WHERE product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $inventory_stock, $product_id);
        $stmt->execute();
    } else {
        // Insert new product
        $query = "INSERT INTO products (name, description, detailed_description, price, category, brand, image_url, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssss", $name, $description, $detailed_description, $price, $category, $brand, $image_url);
        $stmt->execute();
        $new_product_id = $stmt->insert_id;

        // Insert inventory
        $query = "INSERT INTO inventory (product_id, stock, last_updated) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $new_product_id, $inventory_stock);
        $stmt->execute();
    }

    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $is_editing ? 'Edit' : 'Add' ?> Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link rel="stylesheet" href="CSS/edit_product.css">
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class="container mt-4">
        <h2><?= $is_editing ? 'Edit' : 'Add' ?> Product</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Short Description</label>
                <textarea class="form-control" id="description" name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="detailed_description" class="form-label">Detailed Description</label>
                <textarea class="form-control" id="detailed_description" name="detailed_description"><?= htmlspecialchars($product['detailed_description']) ?></textarea> <!-- Optional -->
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?= htmlspecialchars($product['category']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" value="<?= htmlspecialchars($product['brand']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="inventory_stock" class="form-label">Inventory Stock</label>
                <input type="number" class="form-control" id="inventory_stock" name="inventory_stock" value="<?= htmlspecialchars($inventory_stock) ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary"><?= $is_editing ? 'Update' : 'Add' ?> Product</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
