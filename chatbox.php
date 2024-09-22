<div id="chatIcon" class="chat-icon">
    <i class="fas fa-comments"></i>
</div>

<div class="chat" id="chatContainer" style="display: none;">
    <div class="card-container">
        <div class="card-header">
            <img src="images/uploads/pfp.png" alt="Himan" class="img-avatar">
            <div class="text-chat">Chat with Expert</div>
        </div>
        <div class="chat-box">
            <div class="messages-container">
                <!-- Messages will be displayed here -->
            </div>
            <div class="message-input">
                <form id="chatForm">
                    <textarea id="messageInput" placeholder="Type your message here" class="message-send"></textarea>
                    <button type="submit" class="button-send">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
const currentUser = <?= json_encode($_SESSION['user_id']); ?>;
</script>