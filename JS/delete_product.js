// Get all delete buttons
document.querySelectorAll('.delete-btn').forEach(button => {
    // Add click event listener to each button
    button.addEventListener('click', function() {
        // Get the product ID from the data-id attribute
        const productId = this.getAttribute('data-id');
        
        // Show confirmation dialog
        const confirmed = confirm("Are you sure you want to delete this product?");

        if (confirmed) {
            // If confirmed, send a DELETE request to the server using Fetch API
            fetch('PHP/delete_product.php', {
                method: 'POST',  // You can also use DELETE, but for simplicity, we're using POST
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Product deleted successfully.');
                    location.reload(); // Reload the page to reflect the changes
                } else {
                    alert('An error occurred. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while trying to delete the product.');
            });
        }
    });
});