<?php
include 'PHP/check_role.php';

if (!$authorized) {
    http_response_code(401);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <link rel="stylesheet" href="CSS/content_styles.css">
    <script src="JS/manage_content.js" defer></script>
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class="container">
        <div>
            <h1 class ='my-4'>Manage Content</h1>
            <div>
                <button onclick="window.location.href='add_content.php'">Add New Content</button>
            </div>
            

            <!-- Content Type Filter -->
            <label for="content_type">Filter by content type:</label>
            <select name="content_type" id="content_type">
                <option value="">All</option>
                <option value="article">Article</option>
                <option value="guide">Guide</option>
                <option value="blog_post">Blog Post</option>
            </select>

            <div id="content-list" class="content-list justify-content-evenly glass-card-no-blur py-3">
                <!-- Filtered content will be displayed here -->
            </div>
        </div>
    </div>
    <!-- Success/Error Message Container -->
    <div id="message-container" class="message-container"></div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
    <script src="JS/chat_script.js"></script>
    <script src="JS/manage_content.js" defer></script>
</body>
</html>
