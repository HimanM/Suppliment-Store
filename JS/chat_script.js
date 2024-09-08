document.addEventListener('DOMContentLoaded', function () {
    const chatForm = document.querySelector('#chatForm');
    const messageInput = document.querySelector('#messageInput');
    const chatBox = document.querySelector('.chat-box');

    // Fetch and display chat messages
    function fetchMessages() {
        fetch('PHP/get_messages.php')
            .then(response => response.json())
            .then(messages => {
                chatBox.innerHTML = '';
                messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('chat-message');

                    if (message.sender_id == currentUser) {
                        messageDiv.innerHTML = `<p><strong>You:</strong> ${message.message}</p>`;
                    } else {
                        messageDiv.innerHTML = `<p><strong>Expert:</strong> ${message.message}</p>`;
                    }

                    chatBox.appendChild(messageDiv);
                });
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // Send a new message
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = messageInput.value;

        fetch('PHP/send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `message=${encodeURIComponent(message)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageInput.value = '';  // Clear the input field
                    fetchMessages();  // Refresh the chat box
                } else {
                    console.error('Error sending message:', data.error);
                }
            })
            .catch(error => console.error('Error sending message:', error));
    });

    // Fetch messages on page load
    fetchMessages();
});
