<?php
include 'db_config.php'; // Include your database configuration

$email = $_POST['email'];
$password_r = $_POST['password'];
$conf_password_r = $_POST['conf_password'];
$return_url = isset($_POST['return_url']) ? $_POST['return_url'] : '../index.php';

if ($password_r !== $conf_password_r) {
    echo "Passwords do not match.";
    header("Location: $return_url?success=false&error=password_mismatch");
}
else {
    // Hash the password
    $password = password_hash($password_r, PASSWORD_BCRYPT);

    // Check if the email exists and is verified
    $query = "SELECT id FROM users WHERE email = ? AND is_verified = 'no'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update the password
        $query = "UPDATE users SET password = ?, is_verified = 'yes', verification_code = NULL WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $password, $email);
        
        if ($stmt->execute()) {
            echo "Registration complete! You can now log in.";
            header("Location: $return_url?success=true&message=register_success");
        } else {
            echo "Error: " . $stmt->error;
            header("Location: $return_url?success=false&error=register_error");
        }
    } else {
        echo "Email not found.";
        header("Location: $return_url?success=false&message=email_not_found");
    }
}


$conn->close();
?>
