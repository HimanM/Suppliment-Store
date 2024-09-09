<?php
include '../PHP/db_config.php';
session_start();

// Ensure the user is admin or nutritional expert
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'nutritional_expert')) {
    http_response_code(403); // Forbidden
    echo "Unauthorized access";
    exit();
}

// Fetch all users who have sent or received messages
$sql = "SELECT DISTINCT users.username, users.id FROM users
        INNER JOIN messages ON users.id = messages.sender_id OR users.id = messages.receiver_id
        WHERE users.role = 'registered'";
$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Chat Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/admin_chat_styles.css"> <!-- Add your CSS file here -->
    <script src="../JS/admin_chat.js" defer></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Chat with Users</h2>
        <div class="row">
            <div class="col-md-4">
                <h3>Users</h3>
                <ul class="list-group">
                    <?php foreach ($users as $user): ?>
                        <li class="list-group-item">
                            <a href="#" class="user-link" data-user-id="<?= $user['id'] ?>" data-username="<?= $user['username'] ?>">
                                <?= $user['username'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-8 chat-section">
                <h3>Chat</h3>
                <div id="chatContainer" class="chat-container d-none">
                    <button id="closeChat" class="btn btn-danger">Close Chat</button>
                    <div id="chatBox" class="chat-box"></div>
                    <form id="chatForm">
                        <textarea id="messageInput" class="form-control" placeholder="Type your message..." required></textarea>
                        <button type="submit" class="btn btn-primary mt-2">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
