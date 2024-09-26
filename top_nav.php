<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-xl">
    <a class="navbar-brand main-title" href="index.php">Supplement Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <?php if (isset($_SESSION['user_id'])): ?>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>

        <!-- User nav -->
        <?php if (!($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'nutritional_expert')):?>
          <li class="nav-item">
            <a class="nav-link" href="display_content.php">Information</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="health_schedule.php">Schedule</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php">Cart</a>
          </li>
          <?php include 'chatbox.php'; ?>

        <!-- Admin nav -->
        <?php elseif($_SESSION['role'] == 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link" href="manage_users.php">Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="manage_products.php">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="disputes_overview.php">Disputes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="manage_orders.php">Orders</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="send_promotion.php" target="_blank">Promo Emails</a>
          </li>

          <!-- nutritional_expert nav -->
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="display_content.php">Information</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="chat.php">Get help</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php">Cart</a>
          </li>
        <?php endif; ?>
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
            <button class="btn btn-outline-secondary position-relative" id="notificationIcon">
                <i class="far fa-envelope fa-lg mb-1"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    0
                </span>
            </button>
            <ul class="dropdown-menu" id="notificationDropdown">
            </ul>
        </div>

        <div class="dropdown">
          <button id="profileBtn" class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person"></i> Profile
          </button>
          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
          <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <?php if (!($_SESSION['role']=='admin' || $_SESSION['role'] == 'nutritional_expert')):?>
              <li><a class="dropdown-item" href="disputes.php">Dispute Report</a></li>
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li><a class="dropdown-item" href="view_order.php">Orders</a></li>

            <?php elseif ($_SESSION['role']=='admin' || $_SESSION['role'] == 'nutritional_expert'):?>
              <li><a class="dropdown-item" href="view_content.php">Edit Content</a></li>
              <li><a class="dropdown-item" href="admin_chat.php">Recommend/Chat</a></li>
            <?php endif; ?>
            
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
    <div class="login-container glass-card">
        <div id="message-box" class="message-box" style="display: none;"></div>
        <span id="closeBtn" class="close">&times;</span>

        <!-- Login Section -->
        <div id="login-section" class="form-section">
            <h2>Login</h2>
            <form action="PHP/login.php" method="POST">
                <input type="text" name="emailOrUsername" class="form-control" placeholder="Username or Email" required>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <input type="hidden" name="return_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <button type="submit" class="btn-primary">Login</button>
            </form>
            <hr class="my-4">
            <p class="login-text">Forgot your password? <button id="show-forgot-password" class="btn btn-link login-sub-btn">Forgot Password</button></p>
            <p class="login-text">New here? <button id="show-register" class="btn btn-link login-sub-btn">Register</button></p>
        </div>

        <!-- Register Section -->
        <div id="register-section" class="form-section" style="display: none;">
            <h2>Register</h2>
            <form action="PHP/register.php" method="POST">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
                <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <input type="hidden" name="return_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <button type="submit" class="btn-primary">Register</button>
            </form>
            <hr class="my-4">
            <p class="login-text">Already have an account? <button class="btn btn-link login-sub-btn" id="show-login-from-register">Login</button></p>
        </div>

        <!-- Forgot Password Section -->
        <div id="forgot-password-section" class="form-section" style="display: none;">
            <h2>Forgot Password</h2>
            <form action="PHP/forgot_password.php" method="POST">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="hidden" name="return_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <button type="submit" class="btn-primary">Send Reset Link</button>
            </form>
            <hr class="my-4">
            <p class="login-text">Remember your password? <button class="btn btn-link login-sub-btn" id="show-login-from-forgot">Login</button></p>
            <p class="login-text">New here? <button  class="btn btn-link login-sub-btn" id="show-register-from-forgot">Register</button></p>
        </div>
    </div>
</div>
