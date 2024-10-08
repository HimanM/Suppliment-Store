<?php
include 'PHP/db_config.php'; // Database connection
session_start();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <link rel="stylesheet" href="CSS/show_content.css">
</head>
<body>
    <?php include 'top_nav.php'; ?>

    <div class="container my-5 glass-card">
        <div class="row">
            <!-- Product Content -->
            <div class="col-md-12">
                <!-- Title and Author on the right of the image -->
                <div class="content-title">
                    <h1 style="text-align:center"><?php echo htmlspecialchars($content['title']); ?></h1>
                    <p class = "wf"><strong>Author:</strong> <?php echo htmlspecialchars($content['username']); ?></p>
                </div>
                <div class="content-layout">
                    <!-- Image on the left -->
                    <div class ="square">
                        <?php if (!empty($content['image_url'])): ?>
                            <img src="images/content/<?php echo htmlspecialchars($content['image_url']); ?>" alt="Image" class="img-fluid content-image me-3">
                        <?php endif; ?>
                    </div>
                    <p class="body-p wf" ><?php echo nl2br(htmlspecialchars($content['body'])); ?></p>
                    <p class = "wf"><strong>Published on:</strong> <?php echo date('F j, Y', strtotime($content['created_at'])); ?></p>
                
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
    <script src="JS/chat_script.js"></script>
</body>
</html>
