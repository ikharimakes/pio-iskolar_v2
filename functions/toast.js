function showToast(message, title) {
    const container = document.getElementById('toast-container');

    // Create toast element
    const toast = document.createElement('div');
    toast.classList.add('toast');

    // Set toast content
    toast.innerHTML = `
        <div>
            <div class="toast-header">${title}</div>
            <div class="toast-body">${message}</div>
        </div>
        <button class="toast-close">&times;</button>
    `;

    // Close button functionality
    toast.querySelector('.toast-close').addEventListener('click', () => {
        hideToast(toast);
    });

    // Add toast to container
    container.appendChild(toast);

    // Show the toast
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);

    // Auto-hide toast after 5 seconds
    setTimeout(() => {
        hideToast(toast);
    }, 3000);
}

// Function to hide and remove the toast
function hideToast(toast) {
    toast.classList.remove('show');
    setTimeout(() => {
        toast.remove();
    }, 300); // wait for transition to finish
}