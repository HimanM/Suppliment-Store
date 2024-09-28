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
    <title>Terms Of Service</title>
</head>
<body>
<?php include 'top_nav.php'; ?>

<div class="container mt-5 glass-card p-4">
    <h1 class="mb-4">Terms of Service</h1>
    <p class="lead wf">Last updated: 09/28/2024</p>
    
    <h2>1. Acceptance of Terms</h2>
    <p class = "wf-large">By accessing or using our service, you agree to be bound by these terms.</p>
    
    <h2>2. Changes to Terms</h2>
    <p class = "wf-large">We reserve the right to change these Terms at any time. We will provide notice of changes by updating the date at the top of this page.</p>

    <h2>3. User Responsibilities</h2>
    <p class = "wf-large">You are responsible for your use of the service, including compliance with applicable laws.</p>

    <h2>4. Termination</h2>
    <p class = "wf-large">We may terminate or suspend access to our service immediately, without prior notice or liability, for any reason whatsoever.</p>

    <h2>5. Limitation of Liability</h2>
    <p class = "wf-large">In no event shall the Company, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential or punitive damages.</p>

    <h2>6. Contact Us</h2>
    <p class = "wf-large">If you have any questions about these Terms, please contact us:</p>
    <ul>
        <li class ="wf">Email: hghimanmanduja@gmail.com</li>
        <li class ="wf">Phone: +94775193923</li>
    </ul>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="JS/chat_script.js"></script>
<script src="JS/login_script.js"></script>
</body>
</html>
