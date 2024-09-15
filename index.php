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
    <link rel="stylesheet" href="CSS/login_styles.css">
    <title>Supplement Store</title>
</head>
<body>
<?php include 'top_nav.php'; ?>
<div class="container">
    <h1>Welcome to Supplement Store</h1>
    <p>Your one-stop shop for all your supplement needs!</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="JS/login_script.js"></script>
</body>
</html>
