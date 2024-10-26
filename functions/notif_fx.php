<?php
    include_once('../functions/general.php');

    function view_notif($id) {
        global $conn;
        $notify = "SELECT notif_id, date, title, content FROM notification WHERE user_id = '$id' ORDER BY date DESC";
        
        $result = $conn->query($notify);

        if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $notif_id = $row['notif_id'];
                $title = $row['title'];
                $date = $row['date'];
                $content = $row['content'];
                print '
                    <li class="notif-item" id="notif-'.$notif_id.'" onclick="openNotif(';
                print "'$title', '$date', '$content', $notif_id";
                print ')">
                        '.$title.' <br>
                    </li>
                ';
            //     <button class="delete-btn" onclick="event.stopPropagation(); deleteNotif('.$notif_id.')">
            //     <ion-icon name="trash-outline"></ion-icon>
            // </button>
            }
        } else {
            echo '<script>document.getElementById("noNotifsMessage").style.display = "block";</script>';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'];
        // error_log("Action received: $action");

        if ($action == 'delete') {
            $notif_id = $_POST['notif_id'];
            // error_log("Deleting notification ID: $notif_id");
            $delete_query = "DELETE FROM notification WHERE notif_id = '$notif_id'";
            if ($conn->query($delete_query)) {
                // echo "Notification deleted.";
            } else {
                error_log("Error deleting notification: " . $conn->error);
                // echo "Error deleting notification.";
            }
        } elseif ($action == 'delete_all') {
            $user_id = $_POST['user_id'];
            // error_log("Deleting all notifications for user ID: $user_id");
            $delete_all_query = "DELETE FROM notification WHERE user_id = '$user_id'";
            if ($conn->query($delete_all_query)) {
                // echo "All notifications deleted.";
            } else {
                error_log("Error deleting all notifications: " . $conn->error);
                // echo "Error deleting all notifications.";
            }
        }
    }
?>
