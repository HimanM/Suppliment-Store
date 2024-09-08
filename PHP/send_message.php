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

// Check if a message is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];

    // Get a random nutritional expert if the user is not admin or expert
    if ($user_type !== 'admin' && $user_type !== 'nutritional_expert') {
        $sql = "SELECT id FROM users WHERE role = 'nutritional_expert' ORDER BY RAND() LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $expert = $result->fetch_assoc();
        $receiver_id = $expert['id'];
    } else {
        echo json_encode(["error" => "Admin or Expert cannot send messages"]);
        exit();
    }

    // Insert the message into the `messages` table
    $sql = "INSERT INTO messages (sender_id, receiver_id, message, sent_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $user_id, $receiver_id, $message);
    if ($stmt->execute()) {
        echo json_encode(["success" => "Message sent"]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Failed to send message"]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Invalid request"]);
}
?>
