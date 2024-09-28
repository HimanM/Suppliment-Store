<?php
include 'PHP/check_role_admin.php';
include 'PHP/api_handler.php'; // Include the API handler script
include 'PHP/set_notification.php';

if (!$authorized) {
    http_response_code(401);
    exit();
}



// Function to send email
function sendOrderStatusEmail($user_id, $status) {
    
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
        $subject = "Your Order Status Update";
        $message = "Dear Customer,\n\nYour order status has been updated to $status.\n\nThank you for shopping with us.";
        // Send email using api_handler.php
        send_mail_api($user_email, $subject, $message);
        setNotification($user_id, $message);
    }
}

// Handle form submission to update or delete orders
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_order'])) {
        $order_id = intval($_POST['order_id']);
        $status = $_POST['status'];

        // Update order status
        $query = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $order_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Order updated successfully.";

            // Send email if status is shipped or delivered
            if ($status === 'shipped' || $status === 'delivered') {
                // Fetch user_id for the order
                $query = "SELECT user_id FROM orders WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $order_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $order = $result->fetch_assoc();
                
                if ($order) {
                    sendOrderStatusEmail($order['user_id'], $status);
                }
            }
        } else {
            $_SESSION['message'] = "Error updating order: " . $stmt->error;
        }
        
    } elseif (isset($_POST['delete_order'])) {
        $order_id = intval($_POST['order_id']);

        // Delete order
        $query = "DELETE FROM orders WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $order_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Order deleted successfully.";
        } else {
            $_SESSION['message'] = "Error deleting order: " . $stmt->error;
        }
    }

    // Redirect to the same page to show messages
    header("Location: manage_orders.php");
    exit();
}

// Fetch orders
$query = "SELECT id, user_id, total, status, created_at, updated_at, shipping_address, billing_address, payment_status FROM orders";
$result = $conn->query($query);
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/manage_orders.css">
    <script>
        function confirmAction(message, form) {
            if (confirm(message)) {
                form.submit();
            }
        }
    </script>
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class="container mt-4">
        <h2>Manage Orders</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
                <?= $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <div class="scrollable-table">
            <table class="table table-bordered glass-card-no-blur my-4">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Total (LKR)</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Shipping Address</th>
                        <th>Billing Address</th>
                        <th>Payment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <form method="POST" action="">
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">
                                <td><?= htmlspecialchars($order['id']) ?></td>
                                <td><?= htmlspecialchars($order['user_id']) ?></td>
                                <td><?= htmlspecialchars($order['total']) ?></td>
                                <td>
                                    <?php if ($order['payment_status'] === 'paid'): ?>
                                        <select name="status" class="form-select">
                                            <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                            <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                            <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        </select>
                                    <?php else: ?>
                                        <span>Payment Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($order['created_at']) ?></td>
                                <td><?= htmlspecialchars($order['updated_at']) ?></td>
                                <td><?= htmlspecialchars($order['shipping_address']) ?></td>
                                <td><?= htmlspecialchars($order['billing_address']) ?></td>
                                <td><?= htmlspecialchars($order['payment_status']) ?></td>
                                <td>
                                    <div>
                                    <?php if ($order['payment_status'] === 'paid'): ?>
                                        <button type="submit" name="update_order" class="btn btn-primary deletebtn mb-2" onclick="confirmAction('Are you sure you want to save these changes?', this.form)">Save Changes</button>
                                    <?php endif; ?>
                                    <button type="submit" name="delete_order" class="btn btn-danger updatebtn" onclick="confirmAction('Are you sure you want to delete this order?', this.form)">Delete</button>
                                    </div>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
