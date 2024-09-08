<?php
    include 'db_config.php';

    $email = $_POST['email'];
    $return_url = isset($_POST['return_url']) ? $_POST['return_url'] : '../index.php';

    // Check if the email exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Send password reset link (This is just a simulation for now)
        echo "Password reset link sent to your email!";
        header("Location: $return_url?success=true&message=email_sent");
    } else {
        echo "No user found with this email.";
        header("Location: $return_url?success=false&error=email_not_found");
    }

    $conn->close();
?>
