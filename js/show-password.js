document.addEventListener('DOMContentLoaded', function () {
    // Find the password input and the toggle icon in the document
    const passwordInput = document.querySelector('#password');
    const toggleIcon = document.querySelector('#togglePassword');
    const icon = toggleIcon.querySelector('i');

    // Add a click event listener to the icon container
    toggleIcon.addEventListener('click', function () {
        // Check the current type of the input field
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        
        // Set the new type
        passwordInput.setAttribute('type', type);
        
        // Toggle the icon class to switch between the 'eye' and 'eye-slash' icons
        icon.classList.toggle('fa-eye-slash');
        icon.classList.toggle('fa-eye');
    });
});
