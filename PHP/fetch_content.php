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
            <div class='card content-item glass-card' id='content-{$row['id']}' style='width: 18rem;'>
                <img class='card-img-top' src='images/content/{$row['image_url']}' alt='{$row['title']}' style='height: 150px; object-fit: cover;'>
                <div class='card-body'>
                    <h5 class='card-title'>{$row['title']}</h5>
                    <p class='card-text'><small>Type: {$row['type']}</small></p>
                    <p class='card-text'><small>Author ID: {$row['author_id']}</small></p>
                    <p class='card-text'><small>Created at: {$row['created_at']}</small></p>
                    <div class='scrollable-body' style='height: 100px; overflow-y: auto;'>
                        <p>{$row['body']}</p>
                    </div>
                    <div class='d-flex justify-content-between mt-2'>
                        <button class='btn btn-primary edit-btn' data-id='{$row['id']}'>Edit</button>
                        <button class='btn btn-danger delete-btn' data-id='{$row['id']}'>Delete</button>
                    </div>
                </div>
            </div>";
    }
} else {
    $contentHTML .= "<p>No content found for the selected type.</p>";
}

echo $contentHTML;
?>
