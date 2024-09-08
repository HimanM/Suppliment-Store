<?php
include 'db_config.php';

function setNotification($user_id, $message) {
    global $conn;

    // Prepare the SQL statement to insert a new notification
    $sql = "INSERT INTO notifications (user_id, message, is_read, created_at) VALUES (?, ?, 0, NOW())";
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bind_param("is", $user_id, $message);

    // Execute the query
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>
