<?php
    include_once('../functions/general.php');
	global $conn;

//* DOCUMENT DISPLAY - SCHOLAR *//
	function docxDisplay($id, $currentPage = 1, $recordsPerPage = 15, $search = '', $sortColumn = 'sub_date', $sortOrder = 'ASC'){
	    global $conn;
	    $offset = ($currentPage - 1) * $recordsPerPage;
	    $searchQuery = $search ? " AND (doc_name LIKE '%$search%' OR doc_type LIKE '%$search%' OR doc_status LIKE '%$search%')" : '';

	    $display = "SELECT * FROM submission WHERE scholar_id = '$id'
                    $searchQuery 
                    ORDER BY $sortColumn $sortOrder 
                    LIMIT $recordsPerPage OFFSET $offset";
                    
	    $result = $conn->query($display);

	    if ($result->num_rows > 0) {
	        while ($row = $result->fetch_assoc()) {
				// Determine the color based on status
				$style = "";
				if ($row["doc_status"] == "PENDING") {
					$style = "color: rgb(212, 120, 0);
					font-weight: 600;";
                    $disabledClass = "";
				} elseif ($row["doc_status"] == "APPROVED") {
					$style = "color: rgb(0, 136, 0);
					font-weight: 600;";
                    $disabledClass = "disabled";
				} elseif ($row["doc_status"] == "DECLINED") {
					$style = "color: rgb(189, 0, 0);
					font-weight: 600;";
                    $disabledClass = "";
				}

	            print '
	                <tr> 
	                    <td> '.$row["sub_date"].' </td>
	                    <td> '.$row["doc_name"].' </td>
	                    <td> '.$row["doc_type"].' </td>
                    	<td style="'.$style.'">'.$row["doc_status"].'</td>
	                    <td class="wrap" style="width:100%">
							<div class="icon">
								<div class="tooltip">View</div>
								<span> <ion-icon name="eye-outline" onclick="openPrev(this)" 
									data-doc_status="'.$row["doc_status"].'"
									data-doc_reason="'.$row["reason"].'"
									data-doc_name="'.$row["doc_name"].'" ></ion-icon> </span>
							</div>

	                        <div class="icon">
								<div class="tooltip">Download</div>
								<a href="../assets/'.$row["doc_name"].'" download="'.$row["doc_name"].'">
									<span> <ion-icon name="download-outline"></ion-icon> </span>
								</a>
	                        </div>

							<div class="icon '.$disabledClass.'">
								<div class="tooltip">Delete</div>

								<span> <ion-icon name="trash-outline" onclick="openDelete(this)" 
									data-id="'.$row["submit_id"].'" 
									data-name="'.$row["doc_name"].'"></ion-icon> </span>
								</div>
	                        </td>
	                    </tr>
	                ';
	        }
	    } else {
			echo "<tr><td colspan='6'>No records found</td></tr>";
		}
	}

//* DOCUMENT DISPLAY - ADMIN *//
function docxScholar($currentPage = 1, $recordsPerPage = 15, $search = '', $sortColumn = 'sub_date', $sortOrder = 'ASC') { 
    global $conn, $context;

    $context = 'scholar';
    $offset = ($currentPage - 1) * $recordsPerPage;
    $searchQuery = $search ? " AND (doc_name LIKE '%$search%' OR doc_type LIKE '%$search%' OR doc_status LIKE '%$search%')" : '';
    $id = $_SESSION['id'];

    $displayQuery = "SELECT * FROM submission WHERE scholar_id = '$id' 
                    $searchQuery 
                    ORDER BY $sortColumn $sortOrder 
                    LIMIT $recordsPerPage OFFSET $offset";
    
    $result = $conn->query($displayQuery);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Determine the color based on status
            $style = "";
            if ($row["doc_status"] == "PENDING") {
                $style = "color: rgb(212, 120, 0); font-weight: 600;";
                $disabledClass = "";
            } elseif ($row["doc_status"] == "APPROVED") {
                $style = "color: rgb(0, 136, 0); font-weight: 600;";
                $disabledClass = "disabled";
            } elseif ($row["doc_status"] == "DECLINED") {
                $style = "color: rgb(189, 0, 0); font-weight: 600;";
                $disabledClass = "disabled";
            }

            echo '
                <tr> 
                    <td>'.$row["doc_name"].'</td>
                    <td>'.$row["sub_date"].'</td>
                    <td>'.$row["doc_type"].'</td>
                    <td style="'.$style.'">'.$row["doc_status"].'</td>
                    <td style="float: right;" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip">View</div>
                            <span> <ion-icon name="eye-outline" onclick="openPrev(this)"
                                data-submit_id="'.$row["submit_id"].'"  
                                data-doc_name="'.$row["doc_name"].'" 
                                data-doc_status="'.$row["doc_status"].'"
                                data-doc_reason="'.$row["reason"].'"></ion-icon> </span>
                        </div>

                        <div class="icon '.$disabledClass.'">
                            <div class="tooltip"> Approve</div>
                            <span> <ion-icon name="checkmark-circle-outline" onclick="openApprove(this)" 
                                data-id="'.$row["submit_id"].'"></ion-icon> </span>
                        </div>

                        <div class="icon '.$disabledClass.'">
                            <div class="tooltip"> Decline</div>
                            <span> <ion-icon name="close-circle-outline" onclick="openDecline(this)" 
                                data-id="'.$row["submit_id"].'"></ion-icon> </span>
                        </div>

                        <div class="icon">
                            <div class="tooltip">Download</div>
                            <a href="../assets/'.$row["doc_name"].'" download="'.$row["doc_name"].'">
                                <span> <ion-icon name="download-outline"></ion-icon> </span>
                            </a>
                        </div>

                        <div class="icon">
                            <div class="tooltip">Delete</div>

                            <span> <ion-icon name="trash-outline" onclick="openDelete(this)" 
                                data-id="'.$row["submit_id"].'" 
                                data-name="'.$row["doc_name"].'"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
            ';
        }
    } else {
        echo "<tr><td colspan='6'>No records found</td></tr>";
    }
}

//* DOCUMENT DISPLAY - PENDING *//
function docxPending($currentPage = 1, $recordsPerPage = 15, $search = '', $sortColumn = 'sub_date', $sortOrder = 'ASC'){ 
    global $conn, $context;

    $context = 'pending';
    $offset = ($currentPage - 1) * $recordsPerPage;
    $searchQuery = $search ? " AND (doc_name LIKE '%$search%' OR doc_type LIKE '%$search%')" : '';

    $displayQuery = "SELECT * FROM submission WHERE doc_status LIKE 'PENDING' 
                    $searchQuery 
                    ORDER BY $sortColumn $sortOrder 
                    LIMIT $recordsPerPage OFFSET $offset";
    
    $result = $conn->query($displayQuery);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Determine the color based on status
            $style = "";
            if ($row["doc_status"] == "PENDING") {
				$style = "color: rgb(212, 120, 0); font-weight: 600;";
            }

            echo '
                <tr> 
					<td>'.$row["scholar_id"].'</td>
                    <td>'.$row["doc_name"].'</td>
                    <td>'.$row["sub_date"].'</td>
                    <td>'.$row["doc_type"].'</td>
                    <td style="'.$style.'">'.$row["doc_status"].'</td>
                    <td style="float: right;" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip">View</div>
                            <span> <ion-icon name="eye-outline" onclick="openPrev(this)"
                                data-submit_id="'.$row["submit_id"].'"  
                                data-doc_name="'.$row["doc_name"].'" 
                                data-doc_status="'.$row["doc_status"].'"
                                data-doc_reason="'.$row["reason"].'"></ion-icon> </span>
                        </div>

                        <div class="icon">
                            <div class="tooltip">Download</div>
                            <a href="../assets/'.$row["doc_name"].'" download="'.$row["doc_name"].'">
                                <span> <ion-icon name="download-outline"></ion-icon> </span>
                            </a>
                        </div>

                        <div class="icon">
                            <div class="tooltip"> Approve</div>
                            <span> <ion-icon name="checkmark-circle-outline" onclick="openApprove(this)" 
                                data-id="'.$row["submit_id"].'"></ion-icon> </span>
                        </div>

                        <div class="icon">
                            <div class="tooltip"> Decline</div>
                            <span> <ion-icon name="close-circle-outline" onclick="openDecline(this)" 
                                data-id="'.$row["submit_id"].'"></ion-icon> </span>
                        </div>

                        <div class="icon">
                            <div class="tooltip">Delete</div>

                            <span> <ion-icon name="trash-outline" onclick="openDelete(this)" 
                                data-id="'.$row["submit_id"].'" 
                                data-name="'.$row["doc_name"].'"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
            ';
        }
    } else {
        echo "<tr><td colspan='6'>No records found</td></tr>";
    }
}

function getTotalRecords($search = '') {
    global $conn, $context;

    $searchQuery = $search ? " AND (doc_name LIKE '%$search%' OR doc_type LIKE '%$search%' OR doc_status LIKE '%$search%')" : '';

    if ($context == 'pending') {
        $countQuery = "SELECT COUNT(*) as total FROM submission WHERE doc_status LIKE 'PENDING' $searchQuery";
    } else {
        $id = $_SESSION['id'];
        $countQuery = "SELECT COUNT(*) as total FROM submission WHERE scholar_id = '$id' $searchQuery";
    }

    $result = $conn->query($countQuery);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
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

    header('Location: ad_skoDocs.php');
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

//* DOCUMENT DELETION *//
if (isset($_POST['delete'])) {
    $path = "../assets/" . $_POST['name'];
    unlink($path);

    $id = $_POST['id'];
    $delete = "DELETE FROM submission WHERE submit_id = '$id'";
    $result = $conn->query($delete);
}

?>
