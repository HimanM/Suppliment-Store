<?php
include 'PHP/check_role.php';

if (!$authorized) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="CSS/login_styles.css"><!-- Add your CSS file here -->
    <link rel="stylesheet" href="CSS/admin_chat_styles.css">
    <script src="JS/admin_chat.js" defer></script>
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            <?php foreach ($users as $user): ?>
                                <li class="clearfix user-link" data-user-id="<?= $user['id'] ?>" data-username="<?= $user['username'] ?>">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                    <div class="about">
                                        <div class="name"><?= $user['username'] ?></div>                                   
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="chat">
                        <div class="chat-header clearfix">
                            <div class="row d-none" id="chatContainer">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0" id="userName"></h6>
                                        <button id="closeChat" class="btn btn-danger">Close Chat</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history">
                            <ul class="m-b-0" id = "chatBox">
                                <!-- Display Messages here -->
                            </ul>
                        </div>
                        <div class="chat-message clearfix d-none" id= "chatInputField">
                        <form id="chatForm">
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <button type="submit" class="input-group-text">
                                            <i class="fa fa-send"></i>
                                        </button>
                                    </div>
                                    <input id="messageInput" type="text" class="form-control" placeholder="Enter text here...">                            
                                </div>
                            </form>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
