<?php
    include 'db_config.php';

    $username = $_POST['username'];
    $fullName = $_POST['fullname'];
    $return_url = isset($_POST['return_url']) ? $_POST['return_url'] : '../index.php';
    $email = $_POST['email'];
    $password_r = $_POST['password'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // // Check if username already exists
    $query = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username exists, redirect with error
        header("Location: $return_url?success=false&error=username_taken");
        echo "username taken";
        exit();
    } 

    $query = "INSERT INTO users (username, full_name, email, role, password, offer_notifications) VALUES (?, ?, ?, 'registered', ?, 'no')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $username, $fullName, $email, $password);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: $return_url?success=true&message=register_success");
    } else {
        echo "Error: " . $stmt->error;
        header("Location: $return_url?success=false&error=register_error");
    }

    $conn->close();
?>
