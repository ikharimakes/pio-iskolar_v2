<?php
    include_once('../functions/general.php');
global $conn;

function reportList($currentPage = 1, $recordsPerPage = 15, $search = '', $sortColumn = 'creation_date', $sortOrder = 'DESC'){
    global $conn;
    $offset = ($currentPage - 1) * $recordsPerPage;
    $searchQuery = $search ? "WHERE batch_no LIKE '%$search%' OR title LIKE '%$search%' OR report_type LIKE '%$search%'" : '';

    $display = "SELECT report_id, batch_no, title, report_type, creation_date, content
                FROM reports
                $searchQuery
                ORDER BY $sortColumn $sortOrder 
                LIMIT $recordsPerPage OFFSET $offset";
    $result = $conn->query($display);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            print '   
            <tr>
                <td> '.$row["batch_no"].' </td>
                <td> '.$row["title"].' </td>
                <td> '.$row["creation_date"].' </td>
                <td style="text-align: right;" class="wrap"> 
                    <div class="icon">
                        <div class="tooltip"> View</div>
                        <span>
                            <ion-icon name="eye-outline" onclick="openReport(this)"
                                data-report_id="'.$row["report_id"].'"
                                data-batch_no="'.$row["batch_no"].'"
                                data-title="'.$row["title"].'"
                                data-report_type="'.$row["report_type"].'"
                                data-creation_date="'.$row["creation_date"].'"
                                data-content="'.$row["content"].'"></ion-icon>
                        </span>
                    </div>
            '; 
            /*
                    <div class="icon">
                        <div class="tooltip"> Download</div>
                        <span> <ion-icon name="download-outline"></ion-icon> </span>
                    </div>
            */
            print '
                    <div class="icon">
                        <div class="tooltip"> Delete</div>
                        <span>
                            <ion-icon name="trash-outline" onclick="openDelete(this)"
                                data-id="'.$row["report_id"].'"></ion-icon>
                        </span>
                    </div>
                </td>
            </tr>
            ';
        }
    }
}

function getTotalRecords($search = '') {
    global $conn;
    $searchQuery = $search ? "WHERE batch_no LIKE '%$search%' OR title LIKE '%$search%' OR report_type LIKE '%$search%'" : '';
    $countQuery = "SELECT COUNT(*) as total FROM reports $searchQuery";
    $result = $conn->query($countQuery);
    $row = $result->fetch_assoc();
    return $row['total'];
}

if (isset($_POST['delete'])) {
    $reportId = $_POST['report_id'];
    $deleteQuery = "DELETE FROM reports WHERE report_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $reportId);
    if ($stmt->execute()) {
        echo "<script>alert('Report deleted successfully.'); window.location.href = 'ad_reports.php';</script>";
    } else {
        echo "<script>alert('Error deleting report.'); window.location.href = 'ad_reports.php';</script>";
    }
}
?>
