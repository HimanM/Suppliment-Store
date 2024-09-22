<?php
include 'PHP/db_config.php'; // Database connection

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve cart items for the logged-in user
$sql = "SELECT c.product_id, p.name, p.price, p.image_url, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity']; // Calculate total
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link rel="stylesheet" href="CSS/cart_styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'top_nav.php'; ?>
<section class="h-100 gradient-custom">
  <div class="container py-5">
    <div class="row d-flex justify-content-center my-4">
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header py-3">
            <?php if (empty($cart_items)): ?>
              <h5 id="empty_msg" class="mb-0">Your cart is currently empty.</h5>
            <?php else: ?>
            <h5 class="mb-0"><?php echo count($cart_items); ?> Cart Items</h5>
          </div>
          <div class="card-body" id="cart-items">
          <?php foreach ($cart_items as $item): ?>
            <!-- Single item -->
            <div class="cart-item row" data-product-id="<?php echo $item['product_id']; ?>">
              <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                <!-- Image -->
                <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                <img  class = "w-100" src="images/uploads/<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>">
                </div>
                <!-- Image -->
              </div>

              <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                <!-- Data -->
                <h5><?php echo $item['name']; ?></h5>
                <button  type="button" class="remove-from-cart btn btn-danger" title="Remove item">
                    Remove product
                </button>
                <!-- Data -->
              </div>

              <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <!-- Quantity -->
                <div class="d-flex mb-4" style="max-width: 300px">
                  <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="form1">Quantity</label>
                    <input id="form1" min="1" name="quantity" value="<?php echo $item['quantity']; ?>" type="number" class="quantity form-control" max="10" />
                  </div>
                </div>
                <!-- Quantity -->

                <!-- Price -->
                <p class="text-end" id="item-price">
                  <strong>$<?php echo $item['price']; ?></strong>
                </p>
                <!-- Price -->
              </div>
            </div>
            <!-- Single item -->
            <hr class="my-4" />
            <?php endforeach; ?>
          </div>
        </div>


        <div class="card mb-4 mb-lg-0">
          <div class="card-body">
            <p><strong>We accept</strong></p>
            <img class="me-2" width="45px"
              src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
              alt="Visa" />
            <img class="me-2" width="45px"
              src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg"
              alt="American Express" />
            <img class="me-2" width="45px"
              src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
              alt="Mastercard" />
            <img class="me-2" width="45px"
              src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce/includes/gateways/paypal/assets/images/paypal.webp"
              alt="PayPal acceptance mark" />
          </div>
        </div>


      </div>
      <?php if (!empty($cart_items)): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h5 class="mb-0">Summary</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Shipping
                        <span>Free</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                        <div>
                        <strong>Total</strong>
                        <strong>
                            <p class="mb-0">(including VAT)</p>
                        </strong>
                        </div>
                        <div class="cart-total">
                            <span><strong>$<?php echo number_format($total, 2); ?></strong></span>
                        </div> 
                    </li>
                    </ul>

                    <button  id="checkout-btn" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block">
                    Go to checkout
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/cart.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>