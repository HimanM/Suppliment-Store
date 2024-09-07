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

    // Show the login modal and blur the background content
    loginBtn.onclick = function() {
        loginModal.classList.add('show');
        mainContent.classList.add('blur-background');
    };

    // Close the modal when clicking the close button
    closeBtn.onclick = function() {
        loginModal.classList.remove('show');
        mainContent.classList.remove('blur-background');
    };

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target === loginModal) {
            loginModal.classList.remove('show');
            mainContent.classList.remove('blur-background');
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
