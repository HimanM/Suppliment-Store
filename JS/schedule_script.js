// JS/schedule_script.js

document.addEventListener('DOMContentLoaded', function() {
    const scheduleForm = document.getElementById('scheduleForm');
    const scheduleList = document.getElementById('scheduleList');

    // Fetch existing schedules on page load
    fetchSchedules();

    scheduleForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        const formData = new FormData(scheduleForm);
        const scheduleId = document.getElementById('scheduleId').value;

        if (scheduleId) {
            formData.append('action', 'update');
        } else {
            formData.append('action', 'add');
        }

        fetch('PHP/manage_schedule.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); // Alert success or error message
            if (data.success) {
                fetchSchedules(); // Refresh the schedule list
                scheduleForm.reset(); // Reset form
                document.getElementById('scheduleId').value = ''; // Clear schedule ID
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Function to fetch and display schedules
    function fetchSchedules() {
        const formData = new FormData(); // Create a new FormData object
        formData.append('action', 'fetch'); // Append the action

        fetch('PHP/manage_schedule.php', {
            method: 'POST',
            body: formData, // Use FormData as the body
        })
        .then(response => response.json())
        .then(data => {
            scheduleList.innerHTML = ''; // Clear existing list
            if (data.success) {
                data.data.forEach(schedule => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.innerHTML = `
                        <strong>${schedule.title}</strong> (${schedule.schedule_type})<br>
                        ${schedule.description}<br>
                        Reminder Time: ${schedule.reminder_time}<br>
                        Days: ${schedule.reminder_days}<br>
                        <button class="btn btn-warning btn-sm" onclick="editSchedule(${schedule.id}, '${schedule.title}', '${schedule.description}', '${schedule.reminder_time}', '${schedule.reminder_days}')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSchedule(${schedule.id})">Delete</button>
                    `;
                    scheduleList.appendChild(li);
                });
            } else {
                scheduleList.innerHTML = `<li class="list-group-item">${data.message}</li>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Function to edit a schedule
    window.editSchedule = function(id, title, description, reminderTime, reminderDays) {
        document.getElementById('scheduleId').value = id;
        document.getElementById('title').value = title;
        document.getElementById('description').value = description;
        document.getElementById('reminderTime').value = reminderTime;

        const reminderDaysArray = reminderDays.split(', ');
        const reminderDaysSelect = document.getElementById('reminderDays');

        for (let i = 0; i < reminderDaysSelect.options.length; i++) {
            reminderDaysSelect.options[i].selected = reminderDaysArray.includes(reminderDaysSelect.options[i].value);
        }
    };

    // Function to delete a schedule
    window.deleteSchedule = function(id) {
        if (confirm("Are you sure you want to delete this schedule?")) {
            const formData = new FormData(); // Create a new FormData object
            formData.append('action', 'delete'); // Append the action
            formData.append('scheduleId', id); // Replace with dynamic user ID
            fetch('PHP/manage_schedule.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    fetchSchedules(); // Refresh the schedule list
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    };
});
