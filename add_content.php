<?php
include 'PHP/check_role.php';

if (!$authorized) {
    echo "Unauthorized access";
    exit();
}

// Variables to store content information
$title = '';
$body = '';
$type = '';
$image_url = '';
$isEdit = false;

// Check if there's an ID in the URL (if so, it's an edit)
if (isset($_GET['id'])) {
    $isEdit = true;
    $contentId = $_GET['id'];

    // Retrieve the content based on the ID
    $sql = "SELECT * FROM content WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $contentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $content = $result->fetch_assoc();
        $title = $content['title'];
        $body = $content['body'];
        $type = $content['type'];
        $image_url = $content['image_url'];
    } else {
        echo "Content not found.";
        exit();
    }

    $stmt->close();
}

// Handle form submission (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $type = $_POST['type'];
    $author_id = $_SESSION['user_id'];

    // Handle image upload
    $imageUpdated = false;
    if ($_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $target_dir = "images/content/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file type
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            echo "Only JPG, JPEG, PNG files are allowed.";
            exit();
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $_FILES["image"]["name"];
            $imageUpdated = true;
        } else {
            echo "Error uploading file.";
            exit();
        }
    }

    // If editing, update the existing content
    if ($isEdit) {
        $sql = "UPDATE content SET title = ?, body = ?, type = ?, updated_at = NOW()";
        
        // Only update the image if a new one was uploaded
        if ($imageUpdated) {
            $sql .= ", image_url = ?";
        }
        
        $sql .= " WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        
        if ($imageUpdated) {
            $stmt->bind_param("ssssi", $title, $body, $type, $image_url, $contentId);
        } else {
            $stmt->bind_param("sssi", $title, $body, $type, $contentId);
        }

        if ($stmt->execute()) {
            echo "Content updated successfully!";
        } else {
            echo "Failed to update content.";
        }

        $stmt->close();
    } else {
        // If no ID, insert new content
        $sql = "INSERT INTO content (title, body, image_url, author_id, type, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssis", $title, $body, $image_url, $author_id, $type);

        if ($stmt->execute()) {
            echo "Content added successfully!";
        } else {
            echo "Failed to add content.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $isEdit ? 'Edit Content' : 'Add Content' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/add_content_styles.css">
</head>
<body>
<?php include 'top_nav.php'; ?>
    <h1 class= "mt-4"><?= $isEdit ? 'Edit Content' : 'Add Content' ?></h1>
    <div class="content-form-container glass-card-no-blur">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . ($isEdit ? '?id=' . $contentId : '') ?>" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" value="<?= htmlspecialchars($title) ?>" required><br><br>
            <textarea name="body" placeholder="Content Body" required><?= htmlspecialchars($body) ?></textarea><br><br>
            <select name="type" required>
                <option value="article" <?= $type == 'article' ? 'selected' : '' ?>>Article</option>
                <option value="guide" <?= $type == 'guide' ? 'selected' : '' ?>>Guide</option>
                <option value="blog_post" <?= $type == 'blog_post' ? 'selected' : '' ?>>Blog Post</option>
            </select><br><br>
            
            <!-- Show current image if editing -->
            <?php if ($isEdit && $image_url): ?>
                <p>Current Image:</p>
                <img src="images/content/<?= htmlspecialchars($image_url) ?>" alt="<?= htmlspecialchars($title) ?>" width="150"><br><br>
            <?php endif; ?>
            
            <input type="file" name="image" accept="image/jpeg, image/png"><br><br>
            <button type="submit"><?= $isEdit ? 'Update Content' : 'Add Content' ?></button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
