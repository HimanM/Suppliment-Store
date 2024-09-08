<?php
include 'check_role.php';

if (!$authorized) {
    echo "Unauthorized access";
    exit();
}

$contentType = isset($_POST['content_type']) ? $_POST['content_type'] : '';

if (!empty($contentType)) {
    $sql = "SELECT * FROM content WHERE type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $contentType);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM content";
    $result = $conn->query($sql);
}

$contentHTML = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contentHTML .= "
            <div class='content-item' id='content-{$row['id']}'>
                <h3>{$row['title']}</h3>
                <img src='../images/content/{$row['image_url']}' alt='{$row['title']}'>
                <p>{$row['body']}</p>
                <p><small>Type: {$row['type']}</small></p>
                <p><small>Author ID: {$row['author_id']}</small></p>
                <p><small>Created at: {$row['created_at']}</small></p>
                <button class='edit-btn' data-id='{$row['id']}'>Edit</button>
                <button class='delete-btn' data-id='{$row['id']}'>Delete</button>
            </div>
        ";
    }
} else {
    $contentHTML .= "<p>No content found for the selected type.</p>";
}

echo $contentHTML;
?>
