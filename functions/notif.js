// NOTIFICATION
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
            url: '../functions/view_notif.php',
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
            url: '../functions/view_notif.php',
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
