<?php
include '../PHP/check_role.php';

if (!$authorized) {
    echo "Unauthorized access";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../CSS/content_styles.css">
    <script src="../JS/manage_content.js" defer></script>
</head>
<body>
    <h2>Manage Content</h2>
    <button onclick="window.location.href='add_content.php'">Add New Content</button>
    <br>
    <!-- Content Type Filter -->
    <label for="content_type">Filter by content type:</label>
    <select name="content_type" id="content_type">
        <option value="">All</option>
        <option value="article">Article</option>
        <option value="guide">Guide</option>
        <option value="blog_post">Blog Post</option>
    </select>

    <div id="content-list" class="content-list">
        <!-- Filtered content will be displayed here -->
    </div>

    <!-- Success/Error Message Container -->
    <div id="message-container" class="message-container"></div>

    <script src="JS/manage_content.js" defer></script>
</body>
</html>
