document.addEventListener("DOMContentLoaded", function() {
    // Get the modal elements
    const loginModal = document.getElementById('loginModal');
    const loginBtn = document.getElementById('loginBtn');
    const closeBtn = document.getElementById('closeBtn');
    const mainContent = document.querySelector('.main-content');

    // Section navigation buttons
    const showRegisterBtn = document.getElementById('show-register');
    const showRegisterFromForgotBtn = document.getElementById('show-register-from-forgot');
    const showLoginFromRegisterBtn = document.getElementById('show-login-from-register');
    const showForgotPasswordBtn = document.getElementById('show-forgot-password');
    const showLoginFromForgotBtn = document.getElementById('show-login-from-forgot');

    // Sections
    const loginSection = document.getElementById('login-section');
    const registerSection = document.getElementById('register-section');
    const forgotPasswordSection = document.getElementById('forgot-password-section');

    // Notification Sections
    const notificationIcon = document.getElementById('notificationIcon');
    const notificationDropdown = document.getElementById('notificationDropdown');


    fetch('PHP/check_login_status.php')
        .then(response => response.json())
        .then(data => {
            // If user is logged in, modify the navbar to show profile options
            if (data.loggedIn) {
                fetchNotification()
                // Initialize Bootstrap dropdown manually
                const dropdownTrigger = new bootstrap.Dropdown(notificationIcon);

                // Handle dropdown visibility
                notificationIcon.addEventListener('click', function (event) {
                    dropdownTrigger.toggle();
                });

            }
        })
        .catch(error => console.error('Error fetching login status:', error));

    // Fetch notifications periodically
    function fetchNotification(){
        setInterval(() => {
        fetch('PHP/get_notifications.php')
            .then(response => response.json())
            .then(data => {
                let notificationCount = data.length;
                if (notificationCount > 0) {
                    notificationIcon.querySelector('.badge').textContent = notificationCount;
                    let dropdownContent = '';
                    data.forEach(notification => {
                        dropdownContent += `<li>${notification.message} <button onclick="deleteNotification(${notification.id})">Delete</button></li>`;
                    });
                    notificationDropdown.innerHTML = dropdownContent;
                } else {
                    notificationDropdown.innerHTML = '<li>No new notifications</li>';
                }
            });
        }, 5000);
    }

    // Function to delete notifications
    window.deleteNotification = function(id) {
        fetch(`PHP/delete_notification.php?id=${id}`)
            .then(response => response.text())
            .then(() => {
                // Remove the notification from the dropdown
                setTimeout(() => {
                    notificationIcon.querySelector('.badge').textContent = '0';
                    notificationDropdown.innerHTML = '<li>No new notifications</li>';
                }, 1000);
            });
    };

    
    // Show the login modal and blur the background content
    loginBtn.onclick = function() {
        loginModal.classList.add('show');
        // mainContent.classList.add('blur-background');
    };

    // Close the modal when clicking the close button
    closeBtn.onclick = function() {
        loginModal.classList.remove('show');
        // mainContent.classList.remove('blur-background');
    };

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target === loginModal) {
            loginModal.classList.remove('show');
            // mainContent.classList.remove('blur-background');
        }
    };

    // Section transitions
    if (showRegisterBtn) {
        showRegisterBtn.onclick = function() {
            loginSection.style.display = 'none';
            registerSection.style.display = 'block';
        };
    }

    if (showRegisterFromForgotBtn) {
        showRegisterFromForgotBtn.onclick = function() {
            forgotPasswordSection.style.display = 'none';
            registerSection.style.display = 'block';
        };
    }

    if (showLoginFromRegisterBtn) {
        showLoginFromRegisterBtn.onclick = function() {
            registerSection.style.display = 'none';
            loginSection.style.display = 'block';
        };
    }

    if (showForgotPasswordBtn) {
        showForgotPasswordBtn.onclick = function() {
            loginSection.style.display = 'none';
            forgotPasswordSection.style.display = 'block';
        };
    }

    if (showLoginFromForgotBtn) {
        showLoginFromForgotBtn.onclick = function() {
            forgotPasswordSection.style.display = 'none';
            loginSection.style.display = 'block';
        };
    }

    // Handle dropdown menu for profile button
    const profileBtn = document.getElementById('profileBtn');
    if (profileBtn) {
        profileBtn.addEventListener('click', function() {
            const dropdownMenu = profileBtn.nextElementSibling;
            dropdownMenu.classList.toggle('show');
        });
    }

});
