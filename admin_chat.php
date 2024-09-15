
    <script src="JS/admin_chat.js" defer></script>
</head>
<body>
<?php include 'top_nav.php'; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
