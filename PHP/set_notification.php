<?php
include 'db_config.php';

function setNotification($user_id, $message) {
    global $conn;


    // Check if the notification already exists
    $checkSql = "SELECT COUNT(*) FROM notifications WHERE user_id = ? AND message = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("is", $user_id, $message);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    // If a matching notification exists, do not insert a new one
    if ($count > 0) {
        return false;
    }
    
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
