<?php


include 'db_config.php'; 
include 'set_notification.php';


session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Handle different operations based on the action parameter
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    

    switch ($action) {
        case 'add':
            $userId = $_SESSION['user_id'];
            $response = addSchedule($userId);
            break;
        case 'update':
            $response = updateSchedule();
            break;
        case 'delete':
            $response = deleteSchedule();
            break;
        case 'fetch':
            $userId = $_SESSION['user_id']; 
            $response = fetchSchedules($userId);
            break;
        default:
            $response = ["success" => false, "message" => "Invalid action."];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

// Add new schedule
function addSchedule($userId) {
    global $conn;

    $scheduleType = $_POST['scheduleType'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $reminderTime = $_POST['reminderTime'];
    $reminderDays = $_POST['reminderDays']; // Multiple days

    // Insert into health_schedule table
    $sql = "INSERT INTO health_schedule (user_id, schedule_type, title, description, reminder_time) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $userId, $scheduleType, $title, $description, $reminderTime);

    if ($stmt->execute()) {
        $scheduleId = $stmt->insert_id; // Get the newly created schedule ID

        // Prepare SQL to insert each reminder day into the new table
        foreach ($reminderDays as $reminderDay) {
            $reminderSql = "INSERT INTO schedule_reminders (schedule_id, reminder_day) 
                            VALUES (?, ?)";
            $reminderStmt = $conn->prepare($reminderSql);
            $reminderStmt->bind_param("is", $scheduleId, $reminderDay);
            $reminderStmt->execute();
        }

        setNotification($userId, "Reminder set for " . implode(", ", $reminderDays) . " at $reminderTime");
        return ["success" => true, "message" => "Schedule added successfully!"];
    } else {
        return ["success" => false, "message" => "Error: " . $stmt->error];
    }
}

// Update an existing schedule
function updateSchedule() {
    global $conn;

    $scheduleId = $_POST['scheduleId'];
    $title = $_POST['title'];
    $scheduleType = $_POST['scheduleType'];
    $description = $_POST['description'];
    $reminderTime = $_POST['reminderTime'];
    $reminderDays = $_POST['reminderDays']; // Multiple days

    // First, delete existing reminders
    $deleteSql = "DELETE FROM schedule_reminders WHERE schedule_id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $scheduleId);
    $deleteStmt->execute();

    // Prepare SQL to insert each reminder day into the new table
    foreach ($reminderDays as $reminderDay) {
        $reminderSql = "INSERT INTO schedule_reminders (schedule_id, reminder_day) 
                        VALUES (?, ?)";
        $reminderStmt = $conn->prepare($reminderSql);
        $reminderStmt->bind_param("is", $scheduleId, $reminderDay);
        $reminderStmt->execute();
    }

    // Update the health_schedule record
    $updateSql = "UPDATE health_schedule SET title=?, description=?, schedule_type=?, reminder_time=? WHERE id=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssi", $title, $description, $scheduleType, $reminderTime, $scheduleId);
    if ($updateStmt->execute()) {
        return ["success" => true, "message" => "Schedule updated successfully!"];
    } else {
        return ["success" => false, "message" => "Error: " . $updateStmt->error];
    }
}

// Fetch schedules for a specific user
function fetchSchedules($userId) {
    global $conn;

    $sql = "SELECT hs.*, GROUP_CONCAT(sr.reminder_day) as reminder_days 
            FROM health_schedule hs 
            LEFT JOIN schedule_reminders sr ON hs.id = sr.schedule_id 
            WHERE hs.user_id = ? GROUP BY hs.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    $result = $stmt->get_result();
    $schedules = $result->fetch_all(MYSQLI_ASSOC);

    return ["success" => true, "data" => $schedules];
}

// Delete a schedule
function deleteSchedule() {
    global $conn;

    $scheduleId = $_POST['scheduleId'];

    $sql = "DELETE FROM health_schedule WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $scheduleId);

    if ($stmt->execute()) {
        return ["success" => true, "message" => "Schedule deleted successfully!"];
    } else {
        return ["success" => false, "message" => "Error: " . $stmt->error];
    }
}
?>
