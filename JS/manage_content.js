document.addEventListener("DOMContentLoaded", function () {
    const contentTypeSelect = document.getElementById("content_type");
    const contentList = document.getElementById("content-list");

    // Function to fetch content based on the selected type
    function fetchContent(contentType) {
        const formData = new FormData();
        formData.append('content_type', contentType);

        fetch('PHP/fetch_content.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            contentList.innerHTML = data; // Update content list with fetched content

            // Attach event listeners for edit and delete buttons
            attachEventListeners();
        })
        .catch(error => {
            console.error('Error fetching content:', error);
        });
    }

    // Fetch all content on page load
    fetchContent('');

    // Listen for changes in the content type dropdown
    contentTypeSelect.addEventListener("change", function () {
        const selectedType = contentTypeSelect.value;
        fetchContent(selectedType); // Fetch content based on the selected type
    });

    // Attach event listeners for Edit and Delete buttons
    function attachEventListeners() {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const contentId = this.dataset.id;
                window.location.href = `add_content.php?id=${contentId}`;
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const contentId = this.dataset.id;
                if (confirm('Are you sure you want to delete this content?')) {
                    deleteContent(contentId);
                }
            });
        });

    
    }

    // Function to delete content
    function deleteContent(contentId) {
        const formData = new FormData();
        formData.append('content_id', contentId);

        fetch('PHP/delete_content.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById(`content-${contentId}`).remove();
                showMessage(data.message, 'success');
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error deleting content:', error);
        });
    }

    // Function to show success/error message
    function showMessage(message, type) {
        const messageContainer = document.getElementById('message-container');
        messageContainer.innerHTML = `<div class="${type}">${message}</div>`;
        messageContainer.style.display = 'block';

        setTimeout(() => {
            messageContainer.style.display = 'none';
        }, 3000);
    }
});
