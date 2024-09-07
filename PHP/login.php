<?php
    include 'db_config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $emailOrUsername = $_POST['emailOrUsername'];
        $password = $_POST['password'];

        // Query to find the user by email or username
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username=? OR email=?");
        $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the user data
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Start session and redirect to dashboard or home page
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: ../index.php");
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "User not found.";
        }
        $stmt->close();
    }
?>
