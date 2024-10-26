<?php
    include_once('../functions/general.php');
    global $conn;

//* ANNOUNCEMENT UPLOAD *//
if (isset($_POST['add_ann'])) {
    $batch = $_POST['batch'];
    $title = $_POST['title'];
    $start = date("Y-m-d");
    $end = $_POST['endDate'];
    $content = $conn->real_escape_string($_POST['content']);

    $img = $_FILES['cover']['name'];
    $img_temp = $_FILES['cover']['tmp_name'];

    // Create a base image name using title and batch
    $img_base_name = $title . '_Batch-' . $batch;
    $img_extension = pathinfo($img, PATHINFO_EXTENSION);
    $img_name = $img_base_name . '.' . $img_extension;

    // Check if the file already exists and append a number if needed
    $upload_dir = "../assets/";
    $counter = 1;

    while (file_exists($upload_dir . $img_name)) {
        $img_name = $img_base_name . ' (' . $counter . ').' . $img_extension;
        $counter++;
    }

    // Move the uploaded file to the determined unique file name
    move_uploaded_file($img_temp, $upload_dir . $img_name);

    // Validate the batch input: if it's not an integer, set it to 0
    $batch = is_numeric($batch) && intval($batch) == $batch ? intval($batch) : "0";

    // Modified insert query to include batch_no column and updated $img_name
    $insert = "INSERT INTO announcements (announce_id, batch_no, st_date, end_date, img_name, title, content, status) 
               VALUES (NULL, '$batch', '$start', '$end', '$img_name', '$title', '$content', 1)";
    $run = $conn->query($insert);

    if ($run) {
        // Add notifications for all scholars in the batch
        $date = date('Y-m-d');
        $notif_title = "New Announcement: $title";
        $notif_content = "An announcement has been posted that is valid until: $end\n\n$content";
        
        $scholar_query = "SELECT user_id FROM scholar WHERE batch_no = '$batch'";
        $scholar_result = $conn->query($scholar_query);
        
        while ($row = $scholar_result->fetch_assoc()) {
            $user_id = $row['user_id'];
            $notif_insert = "INSERT INTO notification (user_id, date, title, content) 
                            VALUES ('$user_id', '$date', '$notif_title', '$notif_content')";
            $conn->query($notif_insert);
        }

        // Get recipients if end date is in future
        if ($end > date('Y-m-d')) {
            $recipients = [];
            $query = "SELECT email FROM scholar WHERE batch_no = '$batch'";
            if ($result = $conn->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    $recipients[] = $row['email'];
                }
                $result->free();
            }

            if (!empty($recipients)) {
                $emailData = [];
                foreach ($recipients as $email) {
                    $emailData[] = [
                        'email' => $email,
                        'subject' => "New Announcement: $title",
                        'content' => "Dear Scholar,\n\n"
                                . "$title\n\n"
                                . "$content\n\n"
                                . "Valid until: $end"
                    ];
                }
                sendBulkEmailAsync($emailData);
            }
        }

        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        die(mysqli_error($conn));
    }
}

//* ANNOUNCEMENT UPDATE *//
if(isset($_POST['update_ann'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $start = date("Y-m-d");
    $end = $_POST['endDate'];
    $content = $conn->real_escape_string($_POST['content']);
    
    // Check if an image was uploaded
    if(!empty($_FILES['cover']['name'])) {
        $img = $_FILES['cover']['name'];
        $img_temp = $_FILES['cover']['tmp_name'];
        move_uploaded_file($img_temp, "../assets/$img");

        // Construct update query with image
        $update = "UPDATE announcements SET st_date = '$start', end_date = '$end', img_name = '$img', title = '$title', content = '$content' WHERE announce_id = '$id';";
    } else {
        // Construct update query without image
        $update = "UPDATE announcements SET st_date = '$start', end_date = '$end', title = '$title', content = '$content' WHERE announce_id = '$id';";
    }

    $run = $conn->query($update);

    $batch_query = "SELECT batch_no FROM announcements WHERE announce_id = '$id'";
    $batch_result = $conn->query($batch_query);
    $batch_row = $batch_result->fetch_assoc();
    $batch = $batch_row['batch_no'];

    if ($run){
        $date = date('Y-m-d');
        $notif_title = "Updated Announcement: $title";
        $notif_content = "An announcement has been updated and is valid until: $end\n\n$content";
        
        $scholar_query = "SELECT user_id FROM scholar WHERE batch_no = '$batch'";
        $scholar_result = $conn->query($scholar_query);
        
        while ($row = $scholar_result->fetch_assoc()) {
            $user_id = $row['user_id'];
            $notif_insert = "INSERT INTO notification (user_id, date, title, content) 
                            VALUES ('$user_id', '$date', '$notif_title', '$notif_content')";
            $conn->query($notif_insert);
        }

        // Get recipients if end date is in future
        if ($end > date('Y-m-d')) {
            // Get batch number for this announcement
            $batch_query = "SELECT batch_no FROM announcements WHERE announce_id = '$id'";
            $batch_result = $conn->query($batch_query);
            if ($batch_row = $batch_result->fetch_assoc()) {
                $batch = $batch_row['batch_no'];
                
                // Get recipient emails
                $recipients = [];
                $query = "SELECT email FROM scholar WHERE batch_no = '$batch'";
                if ($result = $conn->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                        $recipients[] = $row['email'];
                    }
                    $result->free();
                }
    
                if (!empty($recipients)) {
                    $emailData = [];
                    foreach ($recipients as $email) {
                        $emailData[] = [
                            'email' => $email,
                            'subject' => "Updated Announcement: $title",
                            'content' => "Dear Scholar,\n\n"
                                      . "$title\n\n"
                                      . "$content\n\n"
                                      . "Valid until: $end"
                        ];
                    }
                    sendBulkEmailAsync($emailData);
                }
            }
        }

        header('Location: '.$_SERVER['PHP_SELF']);
    } else {
        die(mysqli_error($conn));
    }
}
    
//* ANNOUNCEMENT DEACTIVATE *//
if(isset($_POST['deactivate'])){
    global $conn;
    $id = $_POST['announce_id'];

    // Calculate the end date as one day before today
    $end = date('Y-m-d', strtotime('-1 day'));

    // Construct the update query to modify only the end_date
    $update = "UPDATE announcements SET end_date = '$end' WHERE announce_id = '$id';";

    error_log($update);
    if ($conn->query($update)){
        // Send a 'success' response instead of redirecting
        echo 'success';
    } else {
        // Send an error response if the query fails
        echo 'error';
    }
}
?>