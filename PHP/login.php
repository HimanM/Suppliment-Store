<?php
    include 'db_config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $emailOrUsername = $_POST['emailOrUsername'];
        $password = $_POST['password'];
        $return_url = isset($_POST['return_url']) ? $_POST['return_url'] : '../index.php';

        // Query to find the user by email or username
        $stmt = $conn->prepare("SELECT id, username, email, password, role, is_verified FROM users WHERE username=? OR email=?");
        $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the user data
            $user = $result->fetch_assoc();

            // Check if the user is verified
            if ($user['is_verified'] !== 'yes') {
                header("Location: $return_url?success=false&error=user_not_verified");
                exit();
            }
            
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Start session and redirect to dashboard or home page
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $user['username'];
                header("Location: $return_url?success=true&message=login_success");
            } else {
                header("Location: $return_url?success=false&error=invalid_password");
            }
        } else {
            header("Location: $return_url?success=false&error=email_not_found");
        }
        $stmt->close();
    }
?>
