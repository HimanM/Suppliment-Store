<?php
function send_mail_api($user_email, $email_subject, $email_body) {
   // Prepare data
    $data = array(
        'user_email' => $user_email,
        'subject' => $email_subject,
        'content' => $email_body
    );

    // Encode the data into JSON format
    $json_data = json_encode($data);

    // cURL setup for making the POST request
    $api_url = "http://127.0.0.1:5000/send_mail"; // Adjust to your actual Flask server URL

    // Initialize cURL session
    $ch = curl_init($api_url);

    // Set cURL options for making a POST request
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Handle any cURL errors
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return array('success' => false, 'message' => "cURL Error: " . $error);
    } else {
        curl_close($ch);
        return array('success' => true, 'message' => "Mail sent successfully!");
    }
}
?>
