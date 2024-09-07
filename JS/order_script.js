document.addEventListener('DOMContentLoaded', function () {
    const cancelOrderButtons = document.querySelectorAll('.cancel-order-btn');

    cancelOrderButtons.forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.getAttribute('data-order-id');

            if (confirm('Are you sure you want to cancel this order?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'PHP/cancel_order.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            alert('Order cancelled successfully.');
                            location.reload();
                        } else {
                            alert('Failed to cancel order. Please try again.');
                        }
                    }
                };
                xhr.send(`order_id=${encodeURIComponent(orderId)}`);
            }
        });
    });
});
