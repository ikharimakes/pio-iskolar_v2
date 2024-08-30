<?php
    include_once('../functions/general.php');
    global $conn;

//* ANNOUNCEMENT UPLOAD *//
    if(isset($_POST['add_ann'])){
        $title = $_POST['title'];
        $start = $_POST['startDate'];
        $end = $_POST['endDate'];
        $content = $conn -> real_escape_string($_POST['content']);

        $img = $_FILES['cover']['name'];
        $img_temp = $_FILES['cover']['tmp_name'];

        move_uploaded_file($img_temp,"../assets/$img");

        $insert = "INSERT INTO announcements (announce_id, st_date, end_date, img_name, title, content, _status) VALUES (NULL, '$start', '$end', '$img', '$title', '$content', 1)";
        $run = $conn->query($insert);

        if ($run){} else {
            die(mysqli_error($conn));
        }
    }

//* ANNOUNCEMENT UPDATE *//
    if(isset($_POST['update_ann'])){
        $id = $_POST['id'];
        $title = $_POST['title'];
        $start = $_POST['startDate'];
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

        if ($run){} else {
            die(mysqli_error($conn));
        }
    }

//* ANNOUNCEMENT DELETION *//
    if(isset($_POST['delete'])){
        $path = "../assets/".$_POST['img'];
        unlink($path);

        $id = $_POST['id'];
        $delete = "DELETE FROM announcements WHERE announce_id = '$id'";
        $result = $conn->query($delete);
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }
?>