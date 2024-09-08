<?php
include 'check_role.php';

if (!$authorized) {
    echo "Unauthorized access";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['content_id'])) {
    $contentId = $_POST['content_id'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $type = $_POST['type'];

    $sql = "UPDATE content SET title = ?, body = ?, type = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $body, $type, $contentId);

    if ($stmt->execute()) {
        echo "Content updated successfully!";
    } else {
        echo "Failed to update content.";
    }

    $stmt->close();
    $conn->close();
}
?>
