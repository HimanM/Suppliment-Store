<?php

include 'PHP/check_role.php';
include 'PHP/set_notification.php';
if (!$authorized) {
    echo "Unauthorized access";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get title and body from the form
    $email_title = $_POST['title'];
    $email_body = $_POST['body'];

    // Prepare the API URL and data
    $api_url = "http://127.0.0.1:5000/send_promotion_email"; // Replace with actual API URL
    $postData = [
        'title' => $email_title,
        'body' => $email_body
    ];

    // Initialize curl
    $ch = curl_init();

    // Set curl options
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);  // Don't wait for the response
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 500);  // Short timeout to disconnect after sending the request

    // Execute curl
    curl_exec($ch);

    // Close curl
    curl_close($ch);
    $user_id = $_SESSION['user_id'];
    $message = "Promotion Emails Sent!";

    setNotification($user_id, $message);
    // Redirect to the same page with a success message
    header("Location: send_promotion.php?sent=true");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Promotion Email</title>
    <link rel="stylesheet" href="CSS/display_content.css">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class="container mt-4">
        <h2>Send Promotional Emails</h2>
        <?php if (isset($_GET['sent']) && $_GET['sent'] === 'true'): ?>
            <div class="alert alert-success" id="emailSentAlert">
                Emails are being sent! You'll be notified when it's done.
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Email Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="body" class="form-label">Email Body</label>
                <textarea class="form-control" id="body" name="body" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Emails</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        // Optionally, hide the success message after a few seconds
        setTimeout(function() {
            var alert = document.getElementById('emailSentAlert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 5000); // Hide after 5 seconds
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
