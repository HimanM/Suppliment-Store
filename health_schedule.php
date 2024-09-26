<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}


// Include database configuration
include 'PHP/db_config.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="CSS/login_styles.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <title>Health Schedule</title>
</head>
<body>
<?php include 'top_nav.php'; ?>

<div class="container mt-5">

    <h2>Manage Your Health Schedule</h2>
    <div class="container p-4 m-4 glass-card">
        <form id="scheduleForm">
            <input type="hidden" id="scheduleId" name="scheduleId" value="">
            
            <div class="form-group">
                <label for="scheduleType">Schedule Type</label>
                <select class="form-control" id="scheduleType" name="scheduleType" required>
                    <option value="workout">Workout</option>
                    <option value="meal">Meal Plan</option>
                    <option value="supplement">Supplement Intake</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="reminderTime">Reminder Time</label>
                <input type="time" class="form-control" id="reminderTime" name="reminderTime" required>
            </div>
            
            <div class="form-group">
                <label for="reminderDays">Reminder Days</label>
                <select multiple class="form-control" id="reminderDays" name="reminderDays[]" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Add Schedule</button>
        </form>
    </div>
    <div class="container p-4 m-4 glass-card">
        <h3 class="mb-3">Existing Schedules</h3>
        <ul id="scheduleList" class="list-group"></ul>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="JS/chat_script.js"></script>
<script src="JS/login_script.js"></script>
<script src="JS/schedule_script.js"></script>
</body>
</html>
