<?php
include 'PHP/db_config.php'; // Database connection

// Retrieve content ID from query string
$content_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch content details
$sql = "SELECT c.*, u.username FROM content c JOIN users u ON c.author_id = u.id WHERE c.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $content_id);
$stmt->execute();
$content = $stmt->get_result()->fetch_assoc();

// Check if content exists
if (!$content) {
    echo "Content not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($content['title']); ?></title>
    <link rel="stylesheet" href="CSS/show_content.css">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'top_nav.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h1><?php echo htmlspecialchars($content['title']); ?></h1>
                <?php if (!empty($content['image'])): ?>
                    <img src="images/content/<?php echo htmlspecialchars($content['image']); ?>" alt="Image" class="img-fluid">
                <?php endif; ?>
                <p><?php echo htmlspecialchars($content['body']); ?></p>
                <p><strong>Author:</strong> <?php echo htmlspecialchars($content['username']); ?></p>
                <p><strong>Published on:</strong> <?php echo date('F j, Y', strtotime($content['created_at'])); ?></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
