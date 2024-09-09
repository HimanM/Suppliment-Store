<?php
session_start();
include 'db_config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['role'] == 'admin') {
    // User is admin 
    $authorized = true;
} else {
    // Unauthorized access
    $authorized = false;
}
?>
