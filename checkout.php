<?php
include 'PHP/db_config.php'; // Database connection

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve cart items for the logged-in user
$sql = "SELECT c.product_id, p.name, p.price, c.quantity, p.image_url 
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
    $total += $row['price'] * $row['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <link rel="stylesheet" href="CSS/checkout_styles.css">
  </head>
  
  <body>
  <?php include 'top_nav.php'; ?>
    <div class= "container">
      <div class="py-5 text-center">
        <h1>Checkout Form</h1>
      </div>
    </div>
    <div class="container">
      <div class="row">

        <div class="col-md-4 order-2">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted wf">Your Cart</span>
            <span class="badge rounded-pill bg-secondary"><?php echo count($cart_items); ?></span>
          </h4>
          
          <div class="container mb-4 p-4 glass-card">
            <div class="card" style="">
              <?php foreach ($cart_items as $item): ?>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                  <div>
                    <h6 class="my-1 mx-1"><?php echo $item['name']; ?></h6>
                    <small class="text-muted mx-1">Quantity: <?php echo $item['quantity']; ?></small>
                  </div>
                  <span class="text-muted my-1 mx-1">Price: Rs:<?php echo number_format($item['price'], 2); ?></span>
                </li>
              <?php endforeach; ?>
            </div>

            <div class="card-footer mt-4 d-flex justify-content-between wf">
              <span>Total (LKR)</span>
              <strong><?php echo number_format($total, 2); ?></strong>
            </div>
          </div>
        </div>
         
        <form class="col-md-8 order-1 needs-validation" action="PHP/process_checkout.php" method="POST" novalidate>
          <h4 class="mb-3">Billing Address</h4>
          <div class="container mb-4 p-4 glass-card">
            <div class="row">
              <div class="col mb-4">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" placeholder="First name" aria-label="First name" required>
                <div class="invalid-feedback">
                  Please enter your first name.
                </div>
              </div>
              <div class="col mb-4">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" placeholder="Last name" aria-label="Last name" required>
                <div class="invalid-feedback">
                  Please enter your last name.
                </div>
              </div>
              <div class="mb-4">
                <label for="email">Email (optional)</label>
                <input type="email" class="form-control" id="email" placeholder="you@example.com" aria-label="email">
                <div class="invalid-feedback">
                  Please enter a valid email.
                </div>
              </div>
              <div class="mb-4">
                <label for="shipping_address">Address</label>
                <input type="text" class="form-control" id="shipping_address" placeholder="1234 Main St" aria-label="Address" name="shipping_address" required>
                <div class="invalid-feedback">
                  Please enter your shipping address.
                </div>
              </div>
              <div class="mb-4">
                <label for="address2">Address 2 (optional)</label>
                <input type="text" class="form-control" id="address2" placeholder="Apartment or suite" aria-label="Address2">
              </div>
            </div>
          </div>

          <div class="container mb-4 p-4 glass-card">
            <div class="row">
              <div class="col">
                <label for="country">Country</label>
                <select class="form-select" id="country" required>
                  <option selected disabled value="">Choose...</option>
                  <option value="1">Sri Lanka</option>
                  <option value="2">Japan</option>
                  <option value="3">Australia</option>
                </select>
                <div class="invalid-feedback">
                  Please select a country.
                </div>
              </div>
              <div class="col">
                <label for="state">State</label>
                <select class="form-select" id="state" required>
                  <option selected disabled value="">Choose...</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
                <div class="invalid-feedback">
                  Please select a state.
                </div>
              </div>
              <div class="col mb-4">
                <label for="zip">Zip Code</label>
                <input type="text" class="form-control" id="zip" aria-label="zip" required>
                <div class="invalid-feedback">
                  Please provide a valid zip code.
                </div>
              </div>
            </div>

            <hr class="mb-4">

            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="sameAddress">
              <label class="form-check-label" for="sameAddress">
                Shipping address is the same as my billing address
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="saveInfo">
              <label class="form-check-label" for="saveInfo">
                Save this information for next time
              </label>
            </div>

            <hr class="mb-4">

            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" checked>
              <label class="form-check-label" for="creditCard">
                Credit card (Default)
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentMethod" id="debitCard">
              <label class="form-check-label" for="debitCard">
                Debit card
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentMethod" id="paypal">
              <label class="form-check-label" for="paypal">
                Paypal
              </label>
            </div>

            <div class="row">
              <div class="col mb-4">
                <label for="cardName">Name on card</label>
                <input type="text" class="form-control" id="cardName" required>
                <div class="invalid-feedback">
                  Please enter the name on the card.
                </div>
              </div>
              <div class="col mb-4">
                <label for="cardNumber">Credit card number</label>
                <input type="text" class="form-control" id="cardNumber" placeholder="1234-5678-9012" required>
                <div class="invalid-feedback">
                  Please enter a valid card number.
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col mb-3">
                <label for="cardExpiry">Expiry Date</label>
                <input type="text" class="form-control" id="cardExpiry" required>
                <div class="invalid-feedback">
                  Please enter the card expiry date.
                </div>
              </div>
              <div class="col mb-3">
                <label for="cardCVV">CVV</label>
                <input type="text" class="form-control" id="cardCVV" required>
                <div class="invalid-feedback">
                  Please enter the CVV code.
                </div>
              </div>
            </div>
          </div>

          <div class="d-grid gap-2 mb-5">
            <button class="btn btn-primary" type="submit">Continue to Checkout</button>
          </div>
        </form>
    </div>
  </div>
    
    
  <?php include 'footer.php'; ?>
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="JS/login_script.js"></script>
  <script src="JS/chat_script.js"></script>
  <script>
  (function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission if form is invalid
    Array.prototype.slice.call(forms).forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
  })()
</script>

    
  </body>
</html>