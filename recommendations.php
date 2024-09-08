<?php
include 'PHP/db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link rel="stylesheet" href="CSS/recommendations.css">
</head>
<body>
<?php include 'top_nav.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 chat-section">
                <h2>Chat with Nutritional Expert</h2>
                <div class="chat-box" id="chatBox"></div>
                <form id="chatForm">
                    <textarea id="messageInput" placeholder="Type your message..." required></textarea>
                    <button type="submit" class="btn btn-primary mt-2">Send</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
    const currentUser = <?= json_encode($_SESSION['user_id']); ?>;
    </script>
    <script src="JS/chat_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
