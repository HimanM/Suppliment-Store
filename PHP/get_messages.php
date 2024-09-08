<?php
include 'db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the current user type
$sql = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    http_response_code(404); // Not Found
    echo json_encode(["error" => "User not found"]);
    exit();
}

$user_type = $user['role'];

// Fetch messages where the current user is either the sender or receiver
$sql = "SELECT * FROM messages WHERE (sender_id = ? OR receiver_id = ?) ORDER BY sent_at ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$messages = [];

while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

// Send the messages as JSON
echo json_encode($messages);
?>
