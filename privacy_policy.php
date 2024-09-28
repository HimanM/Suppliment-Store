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
    <title>Privacy Policy</title>
</head>
<body>
<?php include 'top_nav.php'; ?>

<div class="container mt-5 glass-card p-4">
    <h1 class="mb-4">Privacy Policy</h1>
    <p class="lead wf">Last updated: 09/28/2024</p>
    
    <h2>1. Information We Collect</h2>
    <p class = "wf-large">We collect several types of information for various purposes to provide and improve our service to you.</p>
    
    <h2>2. Use of Data</h2>
    <p class = "wf-large">The Company uses the collected data for various purposes:</p>
    <ul>
        <li class ="wf">To provide and maintain our service</li>
        <li class ="wf">To notify you about changes to our service</li>
        <li class ="wf">To allow you to participate in interactive features when you choose to do so</li>
    </ul>

    <h2>3. Disclosure of Data</h2>
    <p class = "wf-large">We may disclose personal data in the good faith belief that such action is necessary to:</p>
    <ul>
        <li class ="wf">To comply with a legal obligation</li>
        <li class ="wf">To protect and defend the rights or property of the Company</li>
    </ul>

    <h2>4. Security of Data</h2>
    <p class = "wf-large">The security of your data is important to us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure.</p>

    <h2>5. Changes to This Privacy Policy</h2>
    <p class = "wf-large">We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page.</p>

    <h2>Contact Us</h2>
    <p class = "wf-large">If you have any questions about this Privacy Policy, please contact us:</p>
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
