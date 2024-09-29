<?php
include 'api_handler.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Email subject and body
    $subject = "Supplement Store General Inquiries";
    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message";

    // Email to send to
    $adminEmail = "hghimanmanduja@gmail.com"; // Replace with your actual email address
    $result = send_mail_api($adminEmail, $subject, $body);
    // Call the function to send email
    header("Location: ../about_us.php?message=sent");
    exit();
}
?>