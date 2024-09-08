<?php
include '../PHP/check_role.php';

if (!$authorized) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

if (isset($_POST['content_id'])) {
    $contentId = $_POST['content_id'];

    // Delete the content from the database
    $sql = "DELETE FROM content WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $contentId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Content deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete content']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Content ID not provided']);
}
?>
