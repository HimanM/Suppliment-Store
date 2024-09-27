<?php
include 'PHP/check_role_admin.php';
include 'PHP/api_handler.php'; // Include the API handler script
include 'PHP/set_notification.php';


if (!$authorized) {
    echo "Unauthorized access";
    exit();
}


// Fetch the dispute details
$dispute_id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$dispute_id) {
    header("Location: disputes_overview.php");
    exit();
}

$query = "SELECT * FROM disputes WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $dispute_id);
$stmt->execute();
$result = $stmt->get_result();
$dispute = $result->fetch_assoc();

function sendDisputeStatusEmail($user_id, $reply_message, $closed) {
    
    global $conn;
    // Fetch user email
    $query = "SELECT email FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user) {
        $user_email = $user['email'];
        $subject = "Your Dispute Update";
        if($closed){
            $message = "Dear Customer,\n\nThank You For Your Dispute Report.\n\nWe successfully solved your dispute and closed the dispute";
            $update = "We closed your dispute";
        }
        else{
            $message = "Dear Customer,\n\nThank You For Your Concern.\n\n$reply_message.\n\nThank you..\nIf you have more inquiries please reply to this email";
            $update = "We have sent you an email regarding the dispute.";
        }
        // Send email using api_handler.php
        send_mail_api($user_email, $subject, $message);
        setNotification($user_id, $update);
    }
}
$mail_sent = false;
// Handle form submission for reply and status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reply_message'])) {
        $reply_message = $_POST['reply_message'];
        $user_id = $dispute['user_id'];
        $closed = false;
        sendDisputeStatusEmail($user_id, $reply_message, $closed);
        $mail_sent = true;
    }

    if (isset($_POST['update_status'])) {
        $status = $_POST['status'];
        $query = "UPDATE disputes SET status = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $dispute_id);
        $reply_message = '';
        $stmt->execute();
        $closed = true;
        sendDisputeStatusEmail($user_id, $reply_message, $closed);
        header("Location: disputes_overview.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dispute Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/dispute_detail.css">

    <script>
        function confirmAction(message, formId) {
            if (confirm(message)) {
                document.getElementById(formId).submit();
            }
        }
        // Auto-hide the alert after 3 seconds
        function hideAlert() {
            setTimeout(function() {
                let alertBox = document.getElementById('alertBox');
                if (alertBox) {
                    alertBox.style.display = 'none';
                }
            }, 3000); // 3000ms = 3 seconds
        }

        window.onload = hideAlert;
    </script>
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class="container my-4 glass-card p-2">
        <h2>Dispute Details</h2>
        <!-- Display success message if email was sent -->
        <?php if ($mail_sent): ?>
            <div class="alert alert-success" role="alert" id="alertBox">
                Email has been sent successfully!
            </div>
        <?php endif; ?>
        <div class="m-3">
            <p><strong>Type:</strong> <?= htmlspecialchars($dispute['dispute_type']) ?></p>
            <p><strong>Message:</strong> <?= htmlspecialchars($dispute['message']) ?></p>
            <?php if ($dispute['attachment']): ?>
                <p><strong>Attachment:</strong> <a href="images\disputeDocs\<?= htmlspecialchars($dispute['attachment']) ?>" target="_blank">View Attachment</a></p>
            <?php endif; ?>
            <p><strong>Status:</strong> <?= htmlspecialchars($dispute['status']) ?></p>
        </div>

        <!-- Reply Form -->
        <form action="" method="POST">
            <div class="mb-3">
                <label for="reply_message" class="form-label">Reply</label>
                <textarea class="form-control" id="reply_message" name="reply_message" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" onclick="confirmAction('Are you sure you want to send this reply?', 'replyForm')">Send Reply</button>
        </form>
        <form id="replyForm" action="" method="POST"></form>

        <!-- Status Update Form -->
        <form action="" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="resolved">Resolved</option>
                    <!-- Add more status options if needed -->
                </select>
            </div>
            <button type="submit" name="update_status" class="btn btn-primary" onclick="confirmAction('Are you sure you want to update the status?', 'statusUpdateForm')">Update Status</button>
        </form>
        <form id="statusUpdateForm" action="" method="POST"></form>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
