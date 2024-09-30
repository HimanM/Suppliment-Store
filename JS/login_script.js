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
    
    //Register Buttons 
    const verification_btn = document.getElementById('send-verification-btn');
    const verify_code_btn = document.getElementById('verifyCodeBtn');
    const password_form = document.getElementById('password-form');

    const messageDiv = document.getElementById('message-div');

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
                        dropdownContent += `<li class="notification-item">
    <span class="notification-message">${notification.message}</span>
    <button class="delete-btn" onclick="deleteNotification(${notification.id})">Delete</button>
</li>`;
                    });
                    notificationDropdown.innerHTML = dropdownContent;
                } else {
                    notificationDropdown.innerHTML = '<li class="notification-item">No new notifications</li>';
                }
            });
        }, 5000);
    }

    setInterval(function() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "PHP/inventory_check.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log('Inventory Check'); // Optionally display the response
            }
        };
        xhr.send();
    }, 60000); 


    // Function to delete notifications
    window.deleteNotification = function(id) {
        fetch(`PHP/delete_notification.php?id=${id}`)
            .then(response => response.text())
            .then(() => {
                // Remove the notification from the dropdown
                setTimeout(() => {
                    notificationIcon.querySelector('.badge').textContent = '0';
                    notificationDropdown.innerHTML = '<li class="notification-item">No new notifications</li>';
                }, 1000);
            });
    };

    password_form.addEventListener('submit', function(event) {
        console.log("password form clicked");
        // Prevent the default form submission
        event.preventDefault();
    
        // Get the password and confirm password values
        const password = document.getElementById('password').value;
        const confPassword = document.getElementById('conf_password').value;
    
        // Check if passwords match
        if (password !== confPassword) {
            alert('Password mismatch. Please make sure both passwords match.');
        } else {
            // If passwords match, submit the form
            this.submit();
        }
    });
    
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

    function getQueryParams() {
        let params = {};
        const queryString = window.location.search;
        if (queryString) {
            const pairs = queryString.substring(1).split("&");
            pairs.forEach(pair => {
                const [key, value] = pair.split("=");
                params[decodeURIComponent(key)] = decodeURIComponent(value);
            });
        }
        return params;
    }
    
    function displayMessage(message, type) {
        const messageBox = document.createElement('div');
        messageBox.className = `message-box ${type}`;
        messageBox.textContent = message;
        document.body.appendChild(messageBox);
    
        // Style the message box
        messageBox.style.position = 'fixed';
        messageBox.style.top = '20px';
        messageBox.style.left = '50%';
        messageBox.style.transform = 'translateX(-50%)';
        messageBox.style.padding = '10px 20px';
        messageBox.style.backgroundColor = type === 'success' ? 'green' : 'red';
        messageBox.style.color = 'white';
        messageBox.style.fontSize = '16px';
        messageBox.style.zIndex = '9999';
        messageBox.style.borderRadius = '5px';
        messageBox.style.boxShadow = '0px 4px 6px rgba(0,0,0,0.1)';
    
        // Remove the message after 3 seconds
        setTimeout(() => {
            messageBox.remove();
        }, 3000);
    }

    const params = getQueryParams();

    if (params.success === 'false') {
        if (params.error === 'register_error') {
            displayMessage('Registration Error Occured', 'error');
        } else if (params.error === 'invalid_password') {
            displayMessage('Incorrect password. Please try again.', 'error');
        } else if (params.error === 'email_not_found') {
            displayMessage('No user found with this email.', 'error');
        }else if (params.error === 'username_taken') {
            displayMessage('Username is taken', 'error');
        }else if (params.error === 'password_mismatch') {
            displayMessage('Password Mismatch', 'error');
        }else if (params.error === 'email_not_found') {
            displayMessage('Email Not Found', 'error');
        }else if (params.error === 'user_not_verified') {
            displayMessage('Not Verified', 'error');
        }

        
        
    } else if (params.success === 'true') {
        if (params.message === 'register_success') {
            displayMessage('Registration successful!', 'success');
        } else if (params.message === 'login_success') {
            displayMessage('Logged In...', 'success');
        }else if (params.message === 'email_sent') {
            displayMessage('Email Sent...', 'success');
        }
    }


    // Registration
    verification_btn.onclick = function(e){
        console.log('clicked');
        e.preventDefault();
        
        var username = document.getElementById('username').value;
        var fullname = document.getElementById('fullname').value;
        var email = document.getElementById('verify_email').value;
        // Make AJAX request to register.php to handle registration

        // Check if any field is empty
        if (username === '' || fullname === '' || email === '') {
            messageDiv.innerHTML = 'All fields are required.';  // Show message if fields are empty
            messageDiv.style.display = 'block';  // Make sure the message div is visible
            return;  // Prevent further execution if validation fails
        } else {
            messageDiv.style.display = 'none';  // Hide the message div if all fields are filled
        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'PHP/register.php', true);
        console.log('Open');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                if (xhr.responseText === 'email_sent') {
                    alert('Verification email sent. Please check your inbox.');
                    document.getElementById('register-form').style.display = 'none';  // Hide registration form
                    document.getElementById('hidden-email').value = email;  // Save email for verification
                    document.getElementById('verification-form').style.display = 'block';  // Show verification form
                } else if (xhr.responseText === 'duplicate_entry') {
                    alert('Email or username already exists.');
                } else if (xhr.responseText === 'email_error') {
                    alert('There was an error sending the email. Please try again.');
                } else {
                    alert('Error: ' + xhr.responseText);
                }
            }
        };
    
        xhr.send('username=' + encodeURIComponent(username) + '&fullname=' + encodeURIComponent(fullname) + '&email=' + encodeURIComponent(email));
    }

    verify_code_btn.onclick = function(e){
        e.preventDefault();
        var verificationCode = document.getElementById('verification_code').value;
        var email = document.getElementById('hidden-email').value;

        // Check if any field is empty
        if (verificationCode === '') {
            messageDiv.innerHTML = 'Enter the verification code.';  // Show message if fields are empty
            messageDiv.style.display = 'block';  // Make sure the message div is visible
            return;  // Prevent further execution if validation fails
        } else {
            messageDiv.style.display = 'none';  // Hide the message div if all fields are filled
        }
        // Send verification code for validation
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'PHP/verify_registration.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200 && xhr.responseText === 'code_verified') {
                alert('Verification successful! Now set your password.');

                // Show password form fields
                document.getElementById('password-form').style.display = 'block';
                document.getElementById('verification-form').style.display = 'none';

                // Set password fields as required
                document.getElementById('password').setAttribute('required', true);
                document.getElementById('conf_password').setAttribute('required', true);
            } else {
                alert('Invalid verification code');
            }
        };
        xhr.send('verification_code=' + encodeURIComponent(verificationCode) + '&email=' + encodeURIComponent(email));
        }
    
});


// Show the button when the user scrolls down 100px from the top of the document
window.onscroll = function() {
    showScrollButton();
};

function showScrollButton() {
    const scrollTopBtn = document.getElementById("scrollTopBtn");
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        scrollTopBtn.style.display = "block";
    } else {
        scrollTopBtn.style.display = "none";
    }
}

// Scroll to the top of the page when the user clicks the button
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}

