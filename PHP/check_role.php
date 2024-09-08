<?php
session_start();
include 'db_config.php';


//TODO edit this, this for debugging
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// $user_id = $_SESSION['user_id'];

$user_id = '3';

$sql = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['role'] == 'admin' || $row['role'] == 'nutritional_expert') {
    // User is either admin or nutritional expert
    $authorized = true;
} else {
    // Unauthorized access
    $authorized = false;
}
?>
