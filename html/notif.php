<?php include('../functions/notif_fx.php'); ?>
<!-- CSS FILE -->
<link rel="stylesheet" href="css/notif.css">      

<!-- HTML CODE -->
<div id="notifOverlay" class="notifOverlay">
    <div class="content-notif">
        <!-- <div class="header-notif">
            <h1>Notifications</h1>

            <button id="deleteSelectedBtn" class="delete-selected-btn" onclick="deleteSelectedNotifs()"> 
                <ion-icon name="trash-outline"></ion-icon> 
            </button>
            
            <span class="close-btn" onclick="closeNotif()"> &times; </span>
        </div> -->

        <div class="header-notif">
            <button class="icon-btn" onclick="deleteAllNotifs()">
                <ion-icon name="trash-outline"></ion-icon> 
                <p>Delete All</p>
            </button>
            <h1>Notifications</h1>
            <span class="closeOverlay" onclick="closeOverlay()">&times;</span>
        </div>
        
        <p id="noNotifsMessage" style="display: none;">There are currently no notifications.</p>

        <ul class="notif-list">
            <?php view_notif($_SESSION['uid']) ?>
        </ul>

        <!-- <ul class="notif-list">
            <li class="notif-item">
                <input type="checkbox" class="notif-checkbox" onclick="toggleDeleteIcon()">
                <span onclick="openNotifItem('Notification 1', 'April 29, 2024', 'Content...')">Notification 1</span>
            </li>
            <li class="notif-item">
                <input type="checkbox" class="notif-checkbox" onclick="toggleDeleteIcon()">
                <span onclick="openNotifItem('Notification 2', 'April 30, 2024', 'Content...')">Notification 2</span>
            </li>
            <li class="notif-item">
                <input type="checkbox" class="notif-checkbox" onclick="toggleDeleteIcon()">
                <span onclick="openNotifItem('Notification 3', 'May 1, 2024', 'Content...')">Notification 3</span>
            </li>
        </ul> -->
    </div>
</div>

<div id="notifContent" class="notifOverlay">
    <div class="content-notif">
        <div class="header-notif">
            <span class="back-btn" onclick="backToNotif()">	&lt; </span>
            <h1 id="notifTitle"></h1>
            <span class="close-btn" onclick="closeNotifItem()"> &times; </span>
        </div>
            
        <p id="notifDate"></p><br>
        <p id="notifContents"></p>

        <button id="deleteNotifButton" class="delete-btn">
            <ion-icon name="trash-outline"></ion-icon> Delete
        </button>
    </div>
</div>

<input type="hidden" id="userId" value="<?php echo $_SESSION['uid']; ?>">
<!-- JS CODE -->
<script>
    //NOTIFICATION
    function openOverlay() {
        $('#notifOverlay').show();
    }

    function closeOverlay() {
        $('#notifOverlay').hide();
    }

    function openNotif(title, date, content, id) {
        $('#notifOverlay').hide();
        $('#notifContent').show();
        $('#notifTitle').text(title);
        $('#notifDate').text(date);
        $('#notifContents').text(content);
        $('#deleteNotifButton').attr('onclick', 'deleteNotif(' + id + ')');
    }

    function closeNotif() {
        $('#notifContent').hide();
    }

    function backToNotif() {
        $('#notifContent').hide();
        $('#notifOverlay').show();
    }

    function deleteNotif(notif_id) {
        if (confirm('Are you sure you want to delete this notification?')) {
            console.log('Deleting notification ID:', notif_id); // Debugging line
            $.ajax({
                type: 'POST',
                url: '../functions/notif_fx.php',
                data: { action: 'delete', notif_id: notif_id },
                success: function(response) {
                    console.log('Delete response:', response); // Debugging line
                    $('#notif-' + notif_id).remove();
                    checkForNoNotifs();
                    closeNotif();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }
    }

    function deleteAllNotifs() {
        if (confirm('Are you sure you want to delete all notifications?')) {
            var userId = $('#userId').val();
            console.log('Deleting all notifications for user ID:', userId); // Debugging line
            $.ajax({
                type: 'POST',
                url: '../functions/notif_fx.php',
                data: { action: 'delete_all', user_id: userId },
                success: function(response) {
                    console.log('Delete all response:', response); // Debugging line
                    $('.notif-list').empty();
                    checkForNoNotifs();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }
    }

    function checkForNoNotifs() {
        if ($('.notif-list').children().length == 0) {
            $('#noNotifsMessage').show();
        } else {
            $('#noNotifsMessage').hide();
        }
    }
        // function openNotif() {
    //     document.getElementById('notifOverlay').style.display = 'block';
    // }
    // function closeNotif() {
    //     document.getElementById('notifOverlay').style.display = 'none';
    // }

    // function openNotifItem(title, date, content) {
    //     document.getElementById('notifOverlay').style.display = 'none';
    //     document.getElementById('notifContent').style.display = 'block';
    //     document.getElementById('notifTitle').innerText = title;
    //     document.getElementById('notifDate').innerText = date;
    //     document.getElementById('notifContents').innerText = content;
    // }
    // function closeNotifItem() {
    //     document.getElementById('notifContent').style.display = 'none';
    // }
    // function backToNotif() {
    //     document.getElementById('notifContent').style.display = 'none';
    //     document.getElementById('notifOverlay').style.display = 'block';
    // }

    // function toggleDeleteIcon() {
    //     const checkboxes = document.querySelectorAll('.notif-checkbox');
    //     const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    //     const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

    //     // Toggle visibility of the delete icon if any checkbox is checked
    //     if (anyChecked) {
    //         deleteSelectedBtn.style.display = 'block';
    //     } else {
    //         deleteSelectedBtn.style.display = 'none';
    //     }
    // }

    // function deleteSelectedNotifs() {
    //     const checkboxes = document.querySelectorAll('.notif-checkbox');
        
    //     checkboxes.forEach((checkbox, index) => {
    //         if (checkbox.checked) {
    //             checkbox.parentElement.remove(); // Remove the notification item
    //         }
    //     });

    //     // Hide the delete icon after deletion
    //     toggleDeleteIcon();
    // }
</script>
