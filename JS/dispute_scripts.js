document.addEventListener("DOMContentLoaded", function() {
    const orderDropdown = document.getElementById('order-dropdown');
    const productDropdown = document.getElementById('product-dropdown');
    const disputeTypeInputs = document.querySelectorAll('input[name="dispute_type"]');
    const messageBox = document.getElementById('message-box');

    disputeTypeInputs.forEach(input => {
        input.addEventListener('change', function () {
            if (this.value === 'order') {
                orderDropdown.style.display = 'block';
                productDropdown.style.display = 'none';
            } else if (this.value === 'product') {
                productDropdown.style.display = 'block';
                orderDropdown.style.display = 'none';
            } else {
                orderDropdown.style.display = 'none';
                productDropdown.style.display = 'none';
            }
        });
    });


    function getQueryParams() {
        let params = {};
        const queryString = window.location.search;
        if (queryString) {
            const pairs = queryString.substring(1).split("&");
            pairs.forEach(pair => {
                const [key, value] = pair.split("=");
                params[decodeURIComponent(key)] = decodeURIComponent(value);
            });
        }
        return params;
    }

    const params = getQueryParams();
    if (params.success === 'true'){
        console.log('Triggered');
        messageBox.style.display = 'block';
        setTimeout(() => {
            messageBox.style.display = 'none';
        }, 3000);
    }

});