<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Supplement Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <?php if (isset($_SESSION['user_id'])): ?>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="display_content.php">Information</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">Cart</a>
        </li>
      </ul>
      <?php else: ?>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="display_content.php">Information</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
      <?php endif; ?>
      <!-- Conditional rendering based on login status -->
      <?php if (isset($_SESSION['user_id'])): ?>
        <!-- User is logged in -->
        <div class="dropdown">
          <button id="profileBtn" class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person"></i> Profile
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="view_order.php">Orders</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="PHP/logout.php">Logout</a></li>
          </ul>
        </div>
      <?php else: ?>
        <!-- User is not logged in -->
        <button id="loginBtn" class="btn btn-outline-primary">Login</button>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Login Modal -->

<div id="loginModal" class="login-modal">
    <div class="login-container">
        <span id="closeBtn" class="close">&times;</span>

        <!-- Login Section -->
        <div id="login-section" class="form-section">
            <h2>Login</h2>
            <form action="PHP/login.php" method="POST">
                <input type="text" name="emailOrUsername" class="form-control" placeholder="Username or Email" required>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button type="submit" class="btn-primary">Login</button>
            </form>
            <p>Forgot your password? <button id="show-forgot-password">Forgot Password</button></p>
            <p>New here? <button id="show-register">Register</button></p>
        </div>

        <!-- Register Section -->
        <div id="register-section" class="form-section" style="display: none;">
            <h2>Register</h2>
            <form action="PHP/register.php" method="POST">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
                <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button type="submit" class="btn-primary">Register</button>
            </form>
            <p>Already have an account? <button id="show-login-from-register">Login</button></p>
        </div>

        <!-- Forgot Password Section -->
        <div id="forgot-password-section" class="form-section" style="display: none;">
            <h2>Forgot Password</h2>
            <form action="PHP/forgot_password.php" method="POST">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <button type="submit" class="btn-primary">Send Reset Link</button>
            </form>
            <p>Remember your password? <button id="show-login-from-forgot">Login</button></p>
            <p>New here? <button id="show-register-from-forgot">Register</button></p>
        </div>
    </div>
</div>
