<?php
include 'PHP/db_config.php'; // Database connection
session_start();
// Fetch content by type
$sql = "SELECT c.*, u.username FROM content c JOIN users u ON c.author_id = u.id ORDER BY c.created_at DESC";
$result = $conn->query($sql);

// Organize content by type
$articles = [];
$guides = [];
$blog_posts = [];

while ($row = $result->fetch_assoc()) {
    switch ($row['type']) {
        case 'article':
            $articles[] = $row;
            break;
        case 'guide':
            $guides[] = $row;
            break;
        case 'blog_post':
            $blog_posts[] = $row;
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/display_content.css">
    <link rel="stylesheet" href="CSS/login_styles.css">
</head>
<body>
    <?php include 'top_nav.php'; ?>

    <div class="container mt-5">
        <h2>Articles</h2>
        <div class="row">
            <?php foreach ($articles as $article): ?>
                <div class="col-md-4">
                    <div class="card">
                        <?php if (!empty($article['image_url'])): ?>
                            <img src="images/content/<?php echo htmlspecialchars($article['image_url']); ?>" class="card-img-top" alt="Image">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                            <p class="card-text">By: <?php echo htmlspecialchars($article['username']); ?></p>
                            <a href="show_content.php?id=<?php echo $article['id']; ?>" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Guides</h2>
        <div class="row">
            <?php foreach ($guides as $guide): ?>
                <div class="col-md-4">
                    <div class="card">
                        <?php if (!empty($guide['image_url'])): ?>
                            <img src="images/content/<?php echo htmlspecialchars($guide['image_url']); ?>" class="card-img-top" alt="Image">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($guide['title']); ?></h5>
                            <p class="card-text">By: <?php echo htmlspecialchars($guide['username']); ?></p>
                            <a href="show_content.php?id=<?php echo $guide['id']; ?>" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Blog Posts</h2>
        <div class="row">
            <?php foreach ($blog_posts as $post): ?>
                <div class="col-md-4">
                    <div class="card">
                        <?php if (!empty($post['image_url'])): ?>
                            <img src="images/content/<?php echo htmlspecialchars($post['image_url']); ?>" class="card-img-top" alt="Image">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                            <p class="card-text">By: <?php echo htmlspecialchars($post['username']); ?></p>
                            <a href="show_content.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
