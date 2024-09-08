<?php
    include 'db_config.php';

    if (isset($_GET['id'])) {
        $notification_id = $_GET['id'];
        $sql = "UPDATE notifications SET is_read = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $notification_id);
        $stmt->execute();
    }
?>
