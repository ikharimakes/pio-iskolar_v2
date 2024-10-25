<?php
    include_once('../functions/general.php');
    global $conn;

//* DOCUMENT SUBMISSION - SCHOLAR *//
if (isset($_POST['submission'])) {
    global $sem, $year;
    $batch = $_SESSION['bid'];
    $id = $_SESSION['sid'];
    $date = date("Y-m-d");

    $file_fields = ['COR', 'GRADES', 'SOCIAL', 'DIPLOMA'];
    $submitted_docs = [];
    $scholar_info = null;

    foreach ($file_fields as $field) {
        if (!empty($_FILES[$field]['tmp_name']) && is_uploaded_file($_FILES[$field]['tmp_name'])) {
            $file_size = $_FILES[$field]['size'];
            $file_type = mime_content_type($_FILES[$field]['tmp_name']);
            
            // Validate file size (5MB or less) and type (PDF)
            if ($file_size > 5 * 1024 * 1024) { // 5MB in bytes
                echo "<script>showToast('File size should be 5MB or less.', 'Upload Error');</script>";
                continue; // Skip the file if size is invalid
            }
            if ($file_type !== 'application/pdf') {
                echo "<script>showToast('Only PDF files are accepted.', 'Upload Error');</script>";
                continue; // Skip if the file type is not PDF
            }

            if (!$scholar_info) {
                $query = "SELECT batch_no, last_name, first_name, middle_name, school FROM scholar WHERE scholar_id = '$id'";
                $result = $conn->query($query);
                $scholar_info = $result->fetch_assoc();
                $level = ($batch - $scholar_info['batch_no']) + 1;
            }

            $name = "{$scholar_info['last_name']}_{$scholar_info['first_name']}_{$scholar_info['middle_name']}_Year{$level}_Sem{$sem}_{$field}.pdf";
            $school = $scholar_info['school'];

            $upload_temp = $_FILES[$field]['tmp_name'];
            move_uploaded_file($upload_temp, "../assets/$name");

            // Check if a declined document exists
            $declined_doc = getDocumentDetails($id, $field, $year, $sem);
            if ($declined_doc && $declined_doc['doc_status'] === 'DECLINED') {
                // Update existing declined document
                $update = "UPDATE submission SET sub_date = '$date', doc_name = '$name', doc_status = 'PENDING' WHERE scholar_id = '$id' AND doc_type = '$field' AND acad_year = '$year' AND sem = '$sem'";
                $execute = $conn->query($update);
            } else {
                // Insert a new document record
                $insert = "INSERT INTO submission (submit_id, scholar_id, sub_date, doc_name, doc_type, acad_year, sem, doc_status, school) VALUES (NULL, '$id', '$date', '$name', '$field', '$year', '$sem', 'PENDING', '$school')";
                $execute = $conn->query($insert);
            }

            if (!$execute) {
                die(mysqli_error($conn));
            }

            $submitted_docs[] = $name;
        }
    }

    // Generate notification
    if (!empty($submitted_docs)) {
        $admin_id = 1; // Assuming the admin user_id is 1
        $title = "{$id}-{$scholar_info['last_name']} DOCUMENT SUBMISSION";
        $content = "Documents submitted: <br><br>" . implode('<br>', $submitted_docs);
        $notif_insert = "INSERT INTO notification (user_id, date, title, content) VALUES ('$admin_id', '$date', '$title', '$content')";
        $notif_execute = $conn->query($notif_insert);
        if (!$notif_execute) {
            die(mysqli_error($conn));
        }
    }

    header('Location: ./history.php');
    die;
}


//* DOCUMENT SUBMISSION - ADMIN *//
if (isset($_POST['upload'])) {
    global $sem, $year;
    $batch = '32'; // Temporary placeholder
    $id = $_SESSION['sid'];
    $date = date("Y-m-d");
    $type = $_POST['type'];

    $scholar_info = null;

    if (!empty($_FILES[$type]['tmp_name']) && is_uploaded_file($_FILES[$type]['tmp_name'])) {
        $file_size = $_FILES[$type]['size'];
        $file_type = mime_content_type($_FILES[$type]['tmp_name']);
        
        // Validate file size (5MB or less) and type (PDF)
        if ($file_size > 5 * 1024 * 1024) { // 5MB in bytes
            echo "<script>showToast('File size should be 5MB or less.', 'Upload Error');</script>";
            return; // Stop processing if size is invalid
        }
        if ($file_type !== 'application/pdf') {
            echo "<script>showToast('Only PDF files are accepted.', 'Upload Error');</script>";
            return; // Stop processing if the file type is not PDF
        }

        if (!$scholar_info) {
            $query = "SELECT batch_no, last_name, first_name, middle_name, school FROM scholar WHERE scholar_id = '$id'";
            $result = $conn->query($query);
            $scholar_info = $result->fetch_assoc();
            $level = ($batch - $scholar_info['batch_no']) + 1;
        }

        $name = "{$scholar_info['last_name']}_{$scholar_info['first_name']}_{$scholar_info['middle_name']}_Year{$level}_Sem{$sem}_{$type}.pdf";
        $school = $scholar_info['school'];
        
        $upload_temp = $_FILES[$type]['tmp_name'];
        move_uploaded_file($upload_temp, "../assets/$name");

        // Insert a new document record
        $insert = "INSERT INTO submission (submit_id, scholar_id, sub_date, doc_name, doc_type, acad_year, sem, doc_status, school) VALUES (NULL, '$id', '$date', '$name', '$type', '$year', '$sem', 'PENDING', '$school')";
        $execute = $conn->query($insert);
        
        if (!$execute) {
            die(mysqli_error($conn));
        }
    }

    header('Location: '.$_SERVER['PHP_SELF']);
    die;
}


//* PENDING OR APPROVED DOCUMENTS *//
function hasPendingDocument($scholar_id, $doc_type, $year, $sem) {
    global $conn;
    $query = "SELECT COUNT(*) as count FROM submission WHERE scholar_id = ? AND doc_type = ? AND acad_year = ? AND sem = ? AND (doc_status = 'PENDING' OR doc_status = 'APPROVED')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issi", $scholar_id, $doc_type, $year, $sem);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

//* DECLINED DOCUMENTS *//
function getDocumentDetails($scholar_id, $doc_type, $year, $sem) {
    global $conn;
    $query = "SELECT doc_name, doc_status FROM submission WHERE scholar_id = ? AND doc_type = ? AND acad_year = ? AND sem = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }
    $stmt->bind_param("issi", $scholar_id, $doc_type, $year, $sem);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

//* DOCUMENT UPDATE *//
if (isset($_POST['update'])) {
    $doc_id = $_POST['doc_id'];
    $status = $_POST['status'];
    
    if ($status === 'DECLINED') {
        if ($_POST['declineReason'] === 'OTHER') {
            $reason = $_POST['reason'];
        } else {
            $reason = $_POST['declineReason'];
        }
    } else {
        $reason = null;
    }

    $update = "UPDATE submission SET doc_status = ?, reason = ? WHERE submit_id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param('ssi', $status, $reason, $doc_id);
    $stmt->execute();
    
    // Notification
    $date = date('Y-m-d');
    $scholar_query = "SELECT s.user_id, s.last_name 
                      FROM scholar s
                      INNER JOIN submission sub ON s.scholar_id = sub.scholar_id
                      WHERE sub.submit_id = ?";
    $stmt_scholar = $conn->prepare($scholar_query);
    $stmt_scholar->bind_param('i', $doc_id);
    $stmt_scholar->execute();
    $scholar_result = $stmt_scholar->get_result();
    $scholar_info = $scholar_result->fetch_assoc();
    $user_id = $scholar_info['user_id'];

    $title = "{$doc_id}-{$scholar_info['last_name']} DOCUMENT UPDATE";
    $content = "Document status updated to: {$status}<br>Reason: {$reason}";
    $notif_insert = "INSERT INTO notification (user_id, date, title, content) VALUES ('$user_id', '$date', '$title', '$content')";
    $notif_execute = $conn->query($notif_insert);
    if (!$notif_execute) {
        die(mysqli_error($conn));
    }

    header('Location: ad_skoDetail.php');
    die;
}
?>
