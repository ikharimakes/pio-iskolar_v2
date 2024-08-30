<?php
    include_once('../functions/general.php');
    global $conn;
    $announcements = [];
    $query = "SELECT announce_id, title, st_date, end_date FROM announcements WHERE _status = 'ACTIVE'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $announcements[] = $row;
        }
    }

    echo json_encode($announcements);
?>
