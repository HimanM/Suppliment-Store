<?php
include 'db_config.php'; // Database configuration file

// Get the POST data from the AJAX request
$email = $_POST['email'];
$verification_code = $_POST['verification_code'];

// Check if the verification code is correct
$query = "SELECT id FROM users WHERE email = ? AND verification_code = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $email, $verification_code);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {

    echo "code_verified";
} else {
    // The verification code is invalid
    echo "Invalid verification code.";
}

$stmt->close();
$conn->close();
?>