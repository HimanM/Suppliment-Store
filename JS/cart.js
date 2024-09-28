document.addEventListener('DOMContentLoaded', function () {
    const cartItems = document.getElementById('cart-items');
    const cartTotalDiv = document.querySelector('.cart-total');
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
                    updateCartTotal(); // Update total after updating quantity
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
                    location.reload(); 
                    checkCartEmpty(); // Check if cart is empty after removal
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
        let total = 0.00;
        const cartItemsList = document.querySelectorAll('.cart-item');

        cartItemsList.forEach(item => {
            const priceElement = item.querySelector('#item-price');
            const price = parseFloat(priceElement.innerText.replace('Rs: ', '').trim());

            const quantityElement = item.querySelector('.quantity');
            const quantity = parseInt(quantityElement.value, 10);
            console.log(quantity, price);
            total += price * quantity;
        });

        // Update the cart total in the DOM
        if (cartItemsList.length > 0) {
            cartTotalDiv.querySelector('strong').innerText = `Rs: ${total.toFixed(2)}`;
        } else {
            // Hide the cart total and checkout button if no items are left
            cartTotalDiv.style.display = 'none';
            checkoutBtn.style.display = 'none';
        }
    }

    function checkCartEmpty() {
        const cartItemsList = document.querySelectorAll('.cart-item');
        if (cartItemsList.length === 0) {
            document.querySelector('.card-body').innerHTML = "<p>Your cart is empty.</p>";
        }
    }

    // Event listener for changing quantity
    cartItems.addEventListener('input', function (event) {
        if (event.target.classList.contains('quantity')) {
            const quantityInput = event.target;
            const productId = quantityInput.closest('.cart-item').getAttribute('data-product-id');
            const quantity = quantityInput.value;

            if (quantity > 0) {
                updateCart(productId, quantity);
            } else {
                removeFromCart(productId); // Remove if quantity is zero or less
            }
        }
    });

    // Event listener for removing items from the cart
    cartItems.addEventListener('click', function (event) {
        if (event.target.closest('.remove-from-cart')) {
            const productId = event.target.closest('.cart-item').getAttribute('data-product-id');
            removeFromCart(productId);
        }
    });

    // Checkout button functionality
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function () {
            window.location.href = 'checkout.php'; // Redirect to checkout page
        });
    }
});
