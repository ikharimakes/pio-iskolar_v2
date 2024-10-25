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
    $img_extension = pathinfo($img, PATHINFO_EXTENSION); // Get the file extension
    $img_name = $img_base_name . '.' . $img_extension; // Initial image name with extension

    // Check if the file already exists and append a number if needed
    $upload_dir = "../assets/";
    $counter = 1; // Start with 1 for the first duplicate

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

    $query = "SELECT email FROM scholar WHERE batch_no = '$batch'";
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $recipients[] = $row['email'];
        }
        $result->free();
    }
    // sendEmailsAsync($recipients, $title, $content);
    tempMail($recipients, $title, $content);

    if ($run) {
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
        $content = $conn -> real_escape_string($_POST['content']);
        
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

        if ($run){
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