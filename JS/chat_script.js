document.addEventListener('DOMContentLoaded', function () {
    const chatForm = document.querySelector('#chatForm');
    const messageInput = document.querySelector('#messageInput');
    const chatBox = document.querySelector('.messages-container');
    const chatIcon = document.getElementById("chatIcon");
    const chatContainer = document.getElementById("chatContainer");

    // Fetch and display chat messages
    function fetchMessages() {
        fetch('PHP/get_messages.php')
            .then(response => response.json())
            .then(messages => {
                chatBox.innerHTML = '';
                messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('chat-message-box');

                    if (message.sender_id == currentUser) {
                        
                        messageDiv.classList.add('right');
                        messageDiv.innerHTML = `<p>${message.message}</p>`;
                    } else {
                        messageDiv.classList.add('left');
                        messageDiv.innerHTML = `<p>${message.message}</p>`;
                    }

                    chatBox.appendChild(messageDiv);
                });
            })
            .catch(error => console.error('Error fetching messages:', error));
            updateScroll();
    }

    // Send a new message
    if(chatForm){
        
        // Fetch messages on page load
        fetchMessages();
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
                updateScroll();
        });
    }

    function updateScroll(){
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    

    // Toggle chat visibility
    if(chatIcon){
        chatIcon.addEventListener("click", function () {
            if (chatContainer.style.display === "none" || chatContainer.style.display === "") {
                chatContainer.style.display = "block";
            } else {
                chatContainer.style.display = "none";
            }
        });
    }
    

    // Hide chat when clicking outside of it
    document.addEventListener("click", function (event) {
        if(chatContainer){
            if (!chatContainer.contains(event.target) && !chatIcon.contains(event.target)) {
                chatContainer.style.display = "none";
            }
        }
    });
    
});
