<?php
    session_start();

    $response = array(
        'loggedIn' => false,
        'userName' => ''
    );

    if (isset($_SESSION['user_id'])) {
        // If user is logged in, send user details
        $response['loggedIn'] = true;
        $response['userName'] = $_SESSION['username']; // Assuming username is stored in the session
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>