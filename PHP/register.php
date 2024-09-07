<?php
    include 'db_config.php';

    $username = $_POST['username'];
    $fullName = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO users (username, full_name, email, role, password) VALUES (?, ?, ?, 'registered', ?, 'no')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $username, $fullName, $email, $password);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $conn->close();
?>
