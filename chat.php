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
    <link rel="stylesheet" href="CSS/chat.css">
</head>
<body>
    <?php include 'top_nav.php'; ?>

    <div class="chat">
        <div class="card-container">
        <div class="card-header">
            <img src="images\uploads\pfp.png" alt="Himan" class="img-avatar"></img>
            <div class="text-chat">Chat with Expert</div>
        </div>
        <div class="chat-box">
            <div class="messages-container">
                <!-- <div class="message-box left">
                    <p>Hello, How are you?</p>
                </div>
                <div class="message-box right">
                    <p>I'm good, thanks for asking! How about you?</p>
                </div> -->
            </div>
            <div class="message-input">
            <form id ="chatForm">
                <textarea id = "messageInput" placeholder="Type your message here" class="message-send"></textarea>
                <button type="submit" class="button-send">Send</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    
    <script>
    const currentUser = <?= json_encode($_SESSION['user_id']); ?>;
    </script>
    <script src="JS/chat_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
