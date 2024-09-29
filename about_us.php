<?php
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }
?>
<?php include 'PHP/handle_review.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <link rel="stylesheet" href="CSS/about_us.css">
    <script>
        function showMessage(message) {
            const messageContainer = document.getElementById('messageContainer');
            messageContainer.innerHTML = message;
            messageContainer.style.display = 'block';
        }
    </script>
    <title>About Us</title>
</head>
<body>
<?php include 'top_nav.php'; ?>
<!-- About Us Section -->
<section class="about-us py-5">
    <div class="container">
        <h2 class="text-center mb-4">About Us</h2>
        <div id="messageContainer" class="alert" style="display: none;"></div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="glass-card p-4">
                    <h3>Our Mission</h3>
                    <p class = "wf">
                        At Supplement Store, our mission is to provide high-quality nutritional supplements 
                        to help you achieve your health and wellness goals. We believe that everyone 
                        deserves access to the best products to support their journey towards a healthier life.
                    </p>
                    <img src="images/placeholder1.jpg" alt="Our Team" class="img-fluid mb-3">
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="glass-card p-4">
                    <h3>Our Values</h3>
                    <p class = "wf">
                        We value quality, transparency, and customer satisfaction. Our team works diligently 
                        to ensure that every product meets our rigorous standards, and we are committed to 
                        providing exceptional service to our customers.
                    </p>
                    <img src="images/placeholder2.jpg" alt="Our Values" class="img-fluid mb-3">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Us Section -->
<section class="contact-us py-5 glass-card-no-blbr">
    <div class="container">
        <h2 class="text-center mb-4">Contact Us</h2>
        <div id="message-container" style="display: none; color: green;">
            Message sent successfully!
        </div>
        <div class="glass-card p-4">
            <h3>Get in Touch</h3>
            <p  class = "wf-large" >If you have any questions or need further information, feel free to reach out to us:</p>
            <ul class="list-unstyled">
                <li><strong>Email:</strong> hghimanmanduja@gmail.com</li>
                <li><strong>Phone:</strong> +94775193923</li>
                <li><strong>Address:</strong> Himan Manduja
                , 16/46, Lady Lavinia, 1st Templers MW, Templers Road, Mount Lavinia</li>
            </ul>
            <form id="contactForm" method="POST" action="PHP/contact.php">
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea class="form-control" id="message" rows="4" name="message" placeholder="Write your message here..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="JS/chat_script.js"></script>
<script src="JS/login_script.js"></script>
<script>
    // Function to get query parameters from the URL
    function getQueryParam(param) {
        let params = new URLSearchParams(window.location.search);
        return params.get(param);
    }

    // Check if the 'message' parameter is 'sent'
    document.addEventListener("DOMContentLoaded", function() {
        if (getQueryParam('message') === 'sent') {
            // Show the message container
            var messageContainer = document.getElementById('message-container');
            if (messageContainer) {
                messageContainer.style.display = 'block';
            }
        }
    });
</script>
</body>
</html>
