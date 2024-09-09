document.addEventListener('DOMContentLoaded', function () {
    const chatContainer = document.getElementById('chatContainer');
    const chatBox = document.getElementById('chatBox');
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const closeChatBtn = document.getElementById('closeChat');
    let currentUserId = null;

    // Fetch chat messages for the selected user
    function fetchMessages(userId) {
        fetch(`../PHP/get_user_messages.php?user_id=${userId}`)
            .then(response => response.json())
            .then(messages => {
                chatBox.innerHTML = '';
                messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('chat-message');

                    if (message.sender_id == userId) {
                        messageDiv.innerHTML = `<p><strong>User:</strong> ${message.message}</p>`;
                    } else {
                        messageDiv.innerHTML = `<p><strong>You:</strong> ${message.message}</p>`;
                    }

                    chatBox.appendChild(messageDiv);
                });
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // Display chat when a user is clicked
    document.querySelectorAll('.user-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            currentUserId = this.dataset.userId;
            chatContainer.classList.remove('d-none');
            fetchMessages(currentUserId);
        });
    });

    // Close chat container
    closeChatBtn.addEventListener('click', function() {
        chatContainer.classList.add('d-none');
        currentUserId = null;
        chatBox.innerHTML = '';
        messageInput.value = '';
    });


    // Send a new message
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = messageInput.value;

        fetch('../PHP/send_message_to_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `message=${encodeURIComponent(message)}&receiver_id=${selectedUserId}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageInput.value = '';  // Clear the input field
                    fetchMessages(selectedUserId);  // Refresh the chat box
                } else {
                    console.error('Error sending message:', data.error);
                }
            })
            .catch(error => console.error('Error sending message:', error));
    });
});
