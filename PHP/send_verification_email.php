<?php
include 'api_handler.php';
$email = $_POST['email'];
$code = $_POST['code'];

// Prepare email
$subject = "Your Verification Code";
$message = "Your verification code is: $code";


send_mail_api($email, $subject, $message);
echo 'email_sent';
?>