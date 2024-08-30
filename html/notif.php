    <!-- CSS FILE -->
    <link rel="stylesheet" href="css/notif.css">      
    
    <!-- HTML CODE -->
    <div id="notifOverlay" class="notifOverlay">
        <div class="content-notif">
            <div class="header-notif">
                <h1>Notifications</h1>

                <button id="deleteSelectedBtn" class="delete-selected-btn" onclick="deleteSelectedNotifs()"> 
                    <ion-icon name="trash-outline"></ion-icon> 
                </button>
                
                <span class="close-btn" onclick="closeOverlay()"> &times; </span>
            </div>

            <ul class="notif-list">
                <li class="notif-item">
                    <input type="checkbox" class="notif-checkbox" onclick="toggleDeleteIcon()">
                    <span onclick="openNotif('Notification 1', 'April 29, 2024', 'Content...')">Notification 1</span>
                </li>
                <li class="notif-item">
                    <input type="checkbox" class="notif-checkbox" onclick="toggleDeleteIcon()">
                    <span onclick="openNotif('Notification 2', 'April 30, 2024', 'Content...')">Notification 2</span>
                </li>
                <li class="notif-item">
                    <input type="checkbox" class="notif-checkbox" onclick="toggleDeleteIcon()">
                    <span onclick="openNotif('Notification 3', 'May 1, 2024', 'Content...')">Notification 3</span>
                </li>
            </ul>
        </div>
    </div>

    <div id="notifContent" class="notifOverlay">
        <div class="content-notif">
            <div class="header-notif">
                <span class="back-btn" onclick="backToNotif()">	&lt; </span>
                <h1 id="notifTitle"></h1>
                <span class="close-btn" onclick="closeNotif()"> &times; </span>
            </div>
                
            <p id="notifDate"></p><br>
            <p id="notifContents"></p>

            <button id="deleteNotifButton" class="delete-btn">
                <ion-icon name="trash-outline"></ion-icon> Delete
            </button>
        </div>
    </div>

    <!-- JS CODE -->
    <script>
        //NOTIFICATION
        function openOverlay() {
            document.getElementById('notifOverlay').style.display = 'block';
        }
        function closeOverlay() {
            document.getElementById('notifOverlay').style.display = 'none';
        }

        function openNotif(title, date, content) {
            document.getElementById('notifOverlay').style.display = 'none';
            document.getElementById('notifContent').style.display = 'block';
            document.getElementById('notifTitle').innerText = title;
            document.getElementById('notifDate').innerText = date;
            document.getElementById('notifContents').innerText = content;
        }
        function closeNotif() {
            document.getElementById('notifContent').style.display = 'none';
        }
        function backToNotif() {
            document.getElementById('notifContent').style.display = 'none';
            document.getElementById('notifOverlay').style.display = 'block';
        }

        function toggleDeleteIcon() {
            const checkboxes = document.querySelectorAll('.notif-checkbox');
            const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

            // Toggle visibility of the delete icon if any checkbox is checked
            if (anyChecked) {
                deleteSelectedBtn.style.display = 'block';
            } else {
                deleteSelectedBtn.style.display = 'none';
            }
        }

        function deleteSelectedNotifs() {
            const checkboxes = document.querySelectorAll('.notif-checkbox');
            
            checkboxes.forEach((checkbox, index) => {
                if (checkbox.checked) {
                    checkbox.parentElement.remove(); // Remove the notification item
                }
            });

            // Hide the delete icon after deletion
            toggleDeleteIcon();
        }
    </script>