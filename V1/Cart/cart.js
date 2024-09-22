document.addEventListener('DOMContentLoaded', function () {
    const cartItems = document.getElementById('cart-items');
    const cartTotalDiv = document.getElementById('cart-total');
    const checkoutBtn = document.getElementById('checkout-btn');


    function updateCart(productId, quantity) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'PHP/update_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    console.log('Cart updated successfully');
                } else {
                    console.error('Failed to update cart');
                }
            } else {
                console.error('An error occurred. Please try again.');
            }
        };
        xhr.send(`product_id=${encodeURIComponent(productId)}&quantity=${encodeURIComponent(quantity)}`);
    }

    function removeFromCart(productId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'PHP/remove_from_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    document.querySelector(`.cart-item[data-product-id="${productId}"]`).remove();
                    updateCartTotal(); // Update total after removing item
                } else {
                    console.error('Failed to remove item from cart');
                }
            } else {
                console.error('An error occurred. Please try again.');
            }
        };
        xhr.send(`product_id=${encodeURIComponent(productId)}`);
    }

    function updateCartTotal() {
        // Recalculate total and update display
        let total = 0;
        const cartItemsList = document.querySelectorAll('.cart-item');

        cartItemsList.forEach(item => {
            const price = parseFloat(item.querySelector('p').innerText.replace('$', ''));
            const quantity = parseInt(item.querySelector('.quantity').value, 10);
            total += price * quantity;
        });

        // Update the cart total in the DOM
        if (cartItemsList.length > 0) {
            document.querySelector('#cart-total h2').innerText = `Total: $${total.toFixed(2)}`;
        } else {
            // If no items are left, hide the cart total and checkout button
            cartTotalDiv.style.display = 'none';
        }
    }

    cartItems.addEventListener('input', function (event) {
        if (event.target.classList.contains('quantity')) {
            const quantityInput = event.target;
            const productId = quantityInput.closest('.cart-item').getAttribute('data-product-id');
            const quantity = quantityInput.value;

            if (quantity > 0) {
                updateCart(productId, quantity);
                updateCartTotal(); // Update total on quantity change
            }
        }
    });

    cartItems.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-from-cart')) {
            const productId = event.target.closest('.cart-item').getAttribute('data-product-id');
            removeFromCart(productId);
        }
    });

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function () {
            window.location.href = 'checkout.php'; // Redirect to checkout page
        });
    }
});
