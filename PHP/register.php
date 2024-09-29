<?php
include 'db_config.php';
include 'api_handler.php'; // File responsible for sending the email

$username = $_POST['username'];
$fullName = $_POST['fullname'];
$email = $_POST['email'];
$return_url = isset($_POST['return_url']) ? $_POST['return_url'] : '../index.php';

// Generate a random verification code
$verification_code = bin2hex(random_bytes(4)); // Generates an 8-character code

// Check if email or username already exists
$query = "SELECT id, is_verified, verification_code FROM users WHERE email = ? OR username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $email, $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Fetch the user data
    $stmt->bind_result($id, $is_verified, $existing_verification_code);
    $stmt->fetch();

    // Check if user is not verified and has a verification code
    if ($is_verified === 'no' && !is_null($existing_verification_code)) {
        // Delete the user record
        $deleteQuery = "DELETE FROM users WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);
        if ($deleteStmt->execute()) {
            // Successfully deleted the user record, can proceed to insert a new record
            $deleteStmt->close();
        } else {
            echo "Error deleting user record.";
            exit();
        }
    } else {
        echo "duplicate_entry";
        exit();
    }
}

// Insert the new user with the verification code and mark as unverified
$query = "INSERT INTO users (username, full_name, email, verification_code, is_verified) 
          VALUES (?, ?, ?, ?, 'no')";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $username, $fullName, $email, $verification_code);

if ($stmt->execute()) {
    // Send verification email using send_mail_api() function from api_handler.php
    $subject = "Your Verification Code";
    $message = "Your verification code is: $verification_code";
    
    // Call the function to send the email
    if (send_mail_api($email, $subject, $message)) {
        echo 'email_sent';
        exit();
    } else {
        echo 'email_error';
        exit();
    }
} else {
    // If there's a database error
    echo "Error: " . $stmt->error;
    exit();
}

$conn->close();
?>
