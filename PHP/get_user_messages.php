<?php
include 'db_config.php';
session_start();

// Ensure the admin or expert is logged in
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'nutritional_expert')) {
    http_response_code(403); // Forbidden
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

$user_id = $_GET['user_id'];

// Fetch messages between the admin/expert and the selected user
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
