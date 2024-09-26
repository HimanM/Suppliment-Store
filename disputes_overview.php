<?php
include 'PHP/check_role_admin.php';

if (!$authorized) {
    echo "Unauthorized access";
    exit();
}

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch pending disputes
$query = "SELECT * FROM disputes WHERE status = 'pending'";
$result = $conn->query($query);
$disputes = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Disputes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/master.css">
    <link rel="stylesheet" href="CSS/disputes_overview.css">

    <style>
        .scrollable-container {
            max-height: 600px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
<?php include 'top_nav.php'; ?>
    <div class="container mt-4">
        <h2>Pending Disputes</h2>
        <div class="scrollable-container">
            <?php if (count($disputes) > 0): ?>
                <?php foreach ($disputes as $dispute): ?>
                    <div class="mb-3">
                        <h4><?= htmlspecialchars($dispute['dispute_type']) ?></h4>
                        <p><?= htmlspecialchars(substr($dispute['message'], 0, 100)) ?>...</p>
                        <a href="dispute_detail.php?id=<?= $dispute['id'] ?>" class="btn btn-primary">View Details</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No pending disputes found.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="JS/login_script.js"></script>
</body>
</html>
