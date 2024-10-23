<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toast Notification</title>
    <style>
        /* Toast Container */
        .toast-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Individual Toast */
        .toast {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 300px;
            padding: 15px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, opacity 0.3s ease;
            opacity: 0;
            transform: translateY(-100%);
        }

        /* Toast visible state */
        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        /* Toast header */
        .toast-header {
            display: flex;
            align-items: center;
            font-weight: bold;
        }

        /* Toast close button */
        .toast-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
        }

        /* Auto-hide fade-out */
        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }

    </style>
</head>
<body>

<div class="toast-container" id="toast-container">
    <!-- Toast will be dynamically created here -->
</div>

<!-- Button to trigger toast -->
<button onclick="showToast('This is a toast message!', 'Toast Title')">Show Toast</button>

<script>
    // Function to show the toast
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

        // Auto-hide toast after 3 seconds
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
</script>

</body>
</html>
