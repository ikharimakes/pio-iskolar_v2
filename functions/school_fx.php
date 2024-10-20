<?php
    include_once('../functions/general.php');
    global $conn;

//* ADD SCHOOL *//
    if (isset($_POST['add'])) {
        global $year;
        $school = $_POST['school'];
        $address = $_POST['address'];
        $sem = $_POST['semester'];

        $insert = "INSERT INTO university (school_id, school_name, address, acad_year, sem_count)
                   VALUES (NULL, '$school', '$address', '$year', '$sem')";
        $run = $conn->query($insert);

        if ($run) {
            header('Location: ' . $_SERVER['PHP_SELF']);
        } else {
            die(mysqli_error($conn));
        }
    }

//* EDIT SCHOOL *//
    if (isset($_POST['edit'])) {
        global $year;
        $id = $_POST['id'];  // Get the university ID from the hidden field
        $school = $_POST['school'];
        $address = $_POST['address'];
        $sem = $_POST['semester'];

        // Prepare the UPDATE query
        $update = "UPDATE university 
                   SET school_name = '$school', address = '$address', acad_year = '$year', sem_count = '$sem' 
                   WHERE school_id = '$id'";
        
        // Run the query
        $run = $conn->query($update);

        if ($run) {
            // Redirect after successful update
            header('Location: ' . $_SERVER['PHP_SELF']);
        } else {
            // Handle error
            die(mysqli_error($conn));
        }
    }
?>