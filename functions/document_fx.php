<?php
include_once('../functions/general.php');

global $conn;

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

    header('Location: ' . $_SERVER['PHP_SELF']);
    die;
}

//* DOCUMENT APPROVAL *//
if (isset($_POST['approve'])) {
    $doc_id = $_POST['doc_id'];
    $status = "APPROVED";
    $reason = null;

    $approve = "UPDATE submission SET doc_status = ?, reason = ? WHERE submit_id = ?";
    $stmt = $conn->prepare($approve);
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

    $title = "{$doc_id}-{$scholar_info['last_name']} DOCUMENT APPROVAL";
    $content = "Document has been approved.";
    $notif_insert = "INSERT INTO notification (user_id, date, title, content) VALUES ('$user_id', '$date', '$title', '$content')";
    $notif_execute = $conn->query($notif_insert);
    if (!$notif_execute) {
        die(mysqli_error($conn));
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    die;
}

//* DOCUMENT DECLINE *//
if (isset($_POST['decline'])) {
    $doc_id = $_POST['doc_id'];
    $status = "DECLINED";
    if ($_POST['declineReason_alt'] === 'OTHER') {
        $reason = $_POST['reason_alt'];
    } else {
        $reason = $_POST['declineReason_alt'];
    }

    $decline = "UPDATE submission SET doc_status = ?, reason = ? WHERE submit_id = ?";
    $stmt = $conn->prepare($decline);
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

    $title = "{$doc_id}-{$scholar_info['last_name']} DOCUMENT DECLINE";
    $content = "Document has been declined.<br>Reason: {$reason}";
    $notif_insert = "INSERT INTO notification (user_id, date, title, content) VALUES ('$user_id', '$date', '$title', '$content')";
    $notif_execute = $conn->query($notif_insert);
    if (!$notif_execute) {
        die(mysqli_error($conn));
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    die;
}
?>