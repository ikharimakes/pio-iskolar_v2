<?php
include_once('../functions/general.php');
global $conn;

function reportDisplay($current_page = 1, $sort_column = 'title', $sort_order = 'asc') {
    global $conn;

    $records_per_page = 15;
    $offset = ($current_page - 1) * $records_per_page;

    $valid_columns = ['title', 'creation_date'];
    if (!in_array($sort_column, $valid_columns)) {
        $sort_column = 'creation_date';
    }

    $sort_order = strtolower($sort_order) === 'desc' ? 'desc' : 'asc';

    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';

    $conditions = $search !== '' ? "WHERE title LIKE '%$search%' OR creation_date LIKE '%$search%'" : '';
    if ($filter !== '' && $filter !== 'all') {
        $conditions .= $conditions === '' ? "WHERE batch_no = '$filter'" : " AND batch_no = '$filter'";
    }

    $displayQuery = "SELECT * FROM reports $conditions 
                     ORDER BY $sort_column $sort_order 
                     LIMIT $offset, $records_per_page";
    echo '<script> console.log('.'$displayQuery'.'"); </script>';
    $result = $conn->query($displayQuery);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
                <tr>
                    <td style="text-align: center;"> Batch '.$row["batch_no"].'</td>
                    <td>'.$row["title"].'</td>
                    <td>'.$row["creation_date"].'</td>';
            echo '
                    <td style="text-align: right;" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View</div>
                            <span> <ion-icon name="eye-outline" onclick="openReport(this)" 
                                data-report_id="'.$row["report_id"].'"
                                data-batch_no="'.$row["batch_no"].'"
                                data-title="'.$row["title"].'"
                                data-report_type="'.$row["report_type"].'"
                                data-creation_date="'.$row["creation_date"].'"
                                data-content="'.$row["summary"].'"></ion-icon>
                        </div>

                        <div class="icon">
                            <div class="tooltip">Download</div>
                            <a href="../assets/'.$row["file_name"].'" download="'.$row["file_name"].'">
                                <span> <ion-icon name="download-outline"></ion-icon> </span>
                            </a>
                        </div>

                        <div class="icon">
                            <div class="tooltip"> Delete</div>
                            <span> <ion-icon name="trash-outline" onclick="openDelete(this)" 
                                type="reports" 
                                data-id="'.$row["report_id"].'"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
            ';
        }
    } else {
        echo "<tr><td colspan='5'>No records found</td></tr>";
    }
}

function getTotalRecords() {
    global $conn;
    
    // Retrieve search and filter values
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';

    // Base condition for filtering
    $conditions = "1=1"; // Ensures WHERE clause is always valid

    // Add search conditions
    if ($search !== '') {
        $conditions .= " AND (title LIKE '%$search%' OR creation_date LIKE '%$search%')";
    }

    // Add filter conditions
    // if ($filter !== '' && $filter !== 'all') {
    //     $conditions .= " AND status = '$filter'";
    // }

    // Final query to count the records
    $countQuery = "SELECT COUNT(*) as total FROM reports WHERE $conditions";
    $result = $conn->query($countQuery);
    return $result->fetch_assoc()['total'];
}

?>
