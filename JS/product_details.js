document.addEventListener('DOMContentLoaded', function () {
    const reviewForm = document.getElementById('review-form');
    const addToCartForm = document.getElementById('add-to-cart-form');

    if (reviewForm) {
        reviewForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting the traditional way

            const formData = new FormData(reviewForm);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'PHP/submit_review.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        alert(response.message); // Show success message
                        location.reload(); // Reload the page to show the updated review
                    } else {
                        alert(response.message); // Show error message
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            };
            xhr.send(formData);
        });
    }

    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting the traditional way

            const formData = new FormData(addToCartForm);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'PHP/add_to_cart.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        alert(response.message); // Show success message
                    } else {
                        alert(response.message); // Show error message
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            };
            xhr.send(formData);
        });
    }
});
