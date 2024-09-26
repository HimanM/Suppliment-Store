<?php
include 'PHP/check_role_admin.php';

if (!$authorized) {
    echo "Unauthorized access";
    exit();
}

// Handle form submission to update or delete users
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_user'])) {
        $user_id = intval($_POST['user_id']);
        $username = $_POST['username'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // Update user details
        $query = "UPDATE users SET username = ?, full_name = ?, email = ?, role = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $username, $full_name, $email, $role, $user_id);
        $stmt->execute();
    } elseif (isset($_POST['delete_user'])) {
        $user_id = intval($_POST['user_id']);

        // Delete user
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    header("Location: manage_users.php");
    exit();
}

// Fetch users
$query = "SELECT id, username, full_name, email, role FROM users";
$result = $conn->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/manage_users.css">
    <script>
        function confirmAction(message, form) {
            if (confirm(message)) {
                form.submit();
            }
        }
    </script>
    <style>
        .scrollable-table {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class="container mt-4">
        <h2>Manage Users</h2>
        <div class="scrollable-table">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <form method="POST" action="">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <td><input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']) ?>"></td>
                                <td><input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>"></td>
                                <td><input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>"></td>
                                <td>
                                    <select name="role" class="form-select">
                                        <option value="registered" <?= $user['role'] === 'registered' ? 'selected' : '' ?>>Registered</option>
                                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="nutritional_expert" <?= $user['role'] === 'nutritional_expert' ? 'selected' : '' ?>>Nutritional Expert</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" onclick="confirmAction('Are you sure you want to save these changes?', this.form)">Save Changes</button>
                                    <button type="button" class="btn btn-danger" onclick="confirmAction('Are you sure you want to delete this user?', this.form)">Delete</button>
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
