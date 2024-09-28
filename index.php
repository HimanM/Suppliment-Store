<?php
    session_start();

    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        //echo "Welcome, User ID: " . htmlspecialchars($user_id);
    }
?>
<?php include 'PHP/handle_review.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <link rel="stylesheet" href="CSS/index.css">
    <title>Supplement Store</title>
</head>
<body>
<?php include 'top_nav.php'; ?>

<!-- Hero Section -->
    <section class="hero">
        <div class="container">
        <?php if (!isset($_SESSION['role']) || !($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'nutritional_expert')):?>
            <h1>Welcome to Your Ultimate Supplement Store</h1>
            <p>Premium products to support your health and wellness journey</p>
            <!-- Background image in index.css -->
            <a href="products.php" class="btn btn-primary btn-lg aw">Shop Now</a>
        <?php elseif($_SESSION['role'] == 'admin'): ?>
            <h1>Welcome to Admin Panel</h1>
            <a href="manage_orders.php" class="btn btn-primary btn-lg aw">Manage Orders</a>
        <?php else: ?>
            <h1>Welcome Expert</h1>
            <a href="view_content.php" class="btn btn-primary btn-lg aw">Manage Content</a>
        <?php endif; ?>
        </div>
    </section>

    <section class="container my-5">
        <br>
    </section>
    <!-- Featured Products -->
    <?php if (!isset($_SESSION['role']) || !($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'nutritional_expert')):?>
        <h2 class="text-center mb-1 wf">Featured Products</h2>
        <section class="container glass-card-no-border mb-5 mt-2 pt-4">
            <div class="row">
                <div class="col-md-4 product-card">
                    <div class="card">
                        <img src="images/vitamin.png" alt="Product 1" class="card-img-top product-image">
                        <div class="card-body">
                            <h5 class="card-title">Vitamins</h5>
                            <p class="card-text">Boost your immune system with our essential vitamins.</p>
                            <a href="http://localhost/Suppliment%20Store/products.php?category=Vitamins" class="btn btn-primary">Buy Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 product-card">
                    <div class="card">
                        <img src="images/protein.png" alt="Product 2" class="card-img-top product-image">
                        <div class="card-body">
                            <h5 class="card-title">Protein Powders</h5>
                            <p class="card-text">High-quality protein powders for muscle growth and recovery.</p>
                            <a href="http://localhost/Suppliment%20Store/products.php?category=Protein" class="btn btn-primary">Buy Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 product-card">
                    <div class="card">
                        <img src="images/oil.png" alt="Product 3" class="card-img-top product-image">
                        <div class="card-body">
                            <h5 class="card-title">Fish Oils</h5>
                            <p class="card-text">Omega-3 fish oils for cardiovascular health and joint support.</p>
                            <a href="http://localhost/Suppliment%20Store/products.php?category=Oils" class="btn btn-primary">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="bg-light py-5">
            <div class="container">
                <h2 class="text-center mb-4 bf">What Our Customers Say</h2>
                <div class="row">
                    <div class="col-md-4">
                        <blockquote class="blockquote text-center">
                            <p class="mb-0">"Amazing supplements! I feel more energetic and healthy."</p>
                            <footer class="blockquote-footer">John Doe, <cite title="Source Title">Customer</cite></footer>
                        </blockquote>
                    </div>
                    <div class="col-md-4">
                        <blockquote class="blockquote text-center">
                            <p class="mb-0">"Their protein powder is the best I've ever tried."</p>
                            <footer class="blockquote-footer">Jane Smith, <cite title="Source Title">Customer</cite></footer>
                        </blockquote>
                    </div>
                    <div class="col-md-4">
                        <blockquote class="blockquote text-center">
                            <p class="mb-0">"Fast shipping and great customer service."</p>
                            <footer class="blockquote-footer">Michael Lee, <cite title="Source Title">Customer</cite></footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="JS/chat_script.js"></script>
<script src="JS/login_script.js"></script>
</body>
</html>
