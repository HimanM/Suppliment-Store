<?php
include 'PHP/check_role.php';

if (!$authorized) {
    echo "Unauthorized access";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link rel="stylesheet" href="CSS/content_styles.css">
    <script src="JS/manage_content.js" defer></script>
</head>
<body>
<?php include 'top_nav.php'; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
    <script src="JS/manage_content.js" defer></script>
</body>
</html>
