<?php
    session_start();

    // Clear all session variables
    $_SESSION = array();

    // If you want to destroy the session cookie, you can use the following code:
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();

    // Redirect to the home page or login page
    header("Location: ../index.php"); // Change this to your desired redirect page
    exit();
?>