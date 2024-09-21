document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const categorySelect = document.getElementById('category');
    const brandSelect = document.getElementById('brand');
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    const productCards = document.getElementById('product-cards');
    const recommendedProductCards = document.getElementById('recommended-product-cards');


    minPriceInput.addEventListener('input', function () {
        const minPriceValue = parseFloat(minPriceInput.value);
        if (!isNaN(minPriceValue)) {
            maxPriceInput.min = minPriceValue;
        }
    });
    
    // Fetch products based on the current filter inputs
    function fetchProducts() {
        const search = searchInput.value;
        const category = categorySelect.value;
        const brand = brandSelect.value;
        const minPrice = minPriceInput.value || 0;
        const maxPrice = maxPriceInput.value || Number.MAX_SAFE_INTEGER;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', `PHP/fetch_products.php?search=${encodeURIComponent(search)}&category=${encodeURIComponent(category)}&brand=${encodeURIComponent(brand)}&min_price=${encodeURIComponent(minPrice)}&max_price=${encodeURIComponent(maxPrice)}`, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const products = JSON.parse(xhr.responseText);
                displayProducts(products, productCards);
            } else {
                console.error('Failed to fetch products');
            }
        };
        xhr.send();
    }


    // Display fetched products on the page
    function displayProducts(products, Cards) {
        // Clear the Cards container
        Cards.innerHTML = '';
    
        // Check if there are products
        if (products.length === 0) {
            // Create and display a message if no products are found
            const noItemsMessage = document.createElement('p');
            noItemsMessage.textContent = 'Items not found';
            noItemsMessage.className = 'no-items-message';
            Cards.appendChild(noItemsMessage);
        } else {
            // Otherwise, create and display the product cards
            products.forEach(product => {
                const card = document.createElement('div');
                card.className = 'product-card';
                
                // Create a star rating based on the product rating
                const ratingStars = getStars(product.rating);
        
                card.innerHTML = `
                    <img src="images/uploads/${product.image_url}" alt="${product.name}">
                    <h3>${product.name}</h3>
                    <p>${product.description}</p>
                    <p>$${product.price}</p>
                    <div class="rating">${ratingStars}</div>
                    <form class="add-to-cart-form" data-product-id="${product.id}">
                        <input type="number" name="quantity" min="1" value="1" class= "form-control">
                        <button type="submit">Add to Cart</button>
                    </form>
                    <a href="product_details.php?id=${product.id}">More Info</a>
                `;
                Cards.appendChild(card);
            });
        }
    }
    
    // Function to generate star rating
    function getStars(rating) {
        const totalStars = 5;
        const filledStars = Math.floor(rating);  // Filled stars count
        const halfStars = (rating % 1 >= 0.5) ? 1 : 0;  // Add half star if needed
        const emptyStars = totalStars - filledStars - halfStars;  // Remaining stars to be empty
    
        let stars = '';
    
        // Add filled stars
        for (let i = 0; i < filledStars; i++) {
            stars += '★';  // Unicode for filled star
        }
    
        // Add half star if applicable
        if (halfStars) {
            stars += '☆';  // Unicode for half star (use if available)
        }
    
        // Add empty stars
        for (let i = 0; i < emptyStars; i++) {
            stars += '☆';  // Unicode for empty star
        }
    
        return stars;
    }

    // Show popup message when item is added to the cart
    function showPopupMessage(message) {
        const popup = document.createElement('div');
        popup.className = 'popup-message';
        popup.textContent = message;
        document.body.appendChild(popup);

        setTimeout(() => {
            document.body.removeChild(popup);
        }, 2000); // Remove popup after 2 seconds
    }

    // Handle form submit for adding a product to the cart
    function handleFormSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const productId = form.getAttribute('data-product-id');
        const quantity = form.querySelector('input[name="quantity"]').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'PHP/add_to_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                showPopupMessage(response.message);
            } else {
                showPopupMessage('An error occurred. Please try again.');
            }
        };
        xhr.send(`product_id=${encodeURIComponent(productId)}&quantity=${encodeURIComponent(quantity)}`);
    }

    // Listen for form submissions to add items to the cart
    document.addEventListener('submit', function (event) {
        if (event.target.classList.contains('add-to-cart-form')) {
            handleFormSubmit(event);
        }
    });

    // Add event listeners for filters
    searchInput.addEventListener('input', fetchProducts);
    categorySelect.addEventListener('change', fetchProducts);
    brandSelect.addEventListener('change', fetchProducts);
    minPriceInput.addEventListener('input', fetchProducts);
    maxPriceInput.addEventListener('input', fetchProducts);


    function fetchRecommendedProducts() {
        fetch('PHP/fetch_recommended_products.php')
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data) && data.length > 0) {
                    displayProducts(data, recommendedProductCards);
                } else {
                    console.log("No recommended products available or User not logged in");
                }
            })
            .catch(error => console.error('Error fetching recommended products:', error));
    }
    // Fetch products on initial page load
    fetchProducts();
    fetchRecommendedProducts();
    
});
