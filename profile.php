<?php
include 'PHP/db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Fetch user data
$sql = "SELECT * FROM users WHERE id = ?";
$fetch_stmt = $conn->prepare($sql);
$fetch_stmt->bind_param("i", $user_id);
$fetch_stmt->execute();
$user = $fetch_stmt->get_result()->fetch_assoc();

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $offer_notifications = isset($_POST['offer_notifications']) ? 'yes' : 'no';
    
    // Check if password is being changed
    if (!empty($_POST['new_password'])) {
        $current_password = $_POST['current_password'];
        $conf_password = $_POST['conf_password'];
        $new_password = $_POST['new_password'];

        // Hash the new password
        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);        
        // Verify the current password
        if (password_verify($current_password, $user['password']) && $conf_password === $new_password) {
            // Update password and other fields
            $update_sql = "UPDATE users SET full_name = ?, email = ?, password = ?, offer_notifications = ? WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("ssssi", $name, $email, $hashed_new_password, $offer_notifications, $user_id);
        } else {
            if($conf_password !== $new_password){
                $message = "New password and confirmation do not match!";
            }
            else{
                $message = "Incorrect current password!";
            } 
        }

    } else {
        // Update without changing the password
        $update_sql = "UPDATE users SET full_name = ?, email = ?, offer_notifications = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssi", $name, $email, $offer_notifications, $user_id);
    }

    if (isset($stmt) && $stmt->execute()) {
        $message = "Profile updated successfully!";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
    } else {
        if(empty($message)){
            $message = "Failed to update profile!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <link rel="stylesheet" href="CSS/profile_styles.css">
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class="container mt-5">
        <div class="container mb-4 p-4 glass-card">
            <h1>Edit Profile</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <form action="profile.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['full_name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="Pemail" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password (to change password):</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" pattern=".{8,}">
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" pattern=".{8,}">
                </div>
                <div class="mb-3">
                    <label for="conf_password" class="form-label">Confirm New Password:</label>
                    <input type="password" class="form-control" id="conf_password" name="conf_password" pattern=".{8,}">
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="offer_notifications" name="offer_notifications" <?php echo ($user['offer_notifications'] == 'yes') ? 'checked' : ''; ?>>
                    <label class="form-check-label wf" for="offer_notifications">Receive news and offers</label>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
    <script src="JS/chat_script.js"></script>
</body>
</html>
