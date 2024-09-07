<?php
    include 'db_config.php';

    $email = $_POST['emailForgotPassword'];

    // Check if the email exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Send password reset link (This is just a simulation for now)
        echo "Password reset link sent to your email!";
    } else {
        echo "No user found with this email.";
    }

    $conn->close();
?>
