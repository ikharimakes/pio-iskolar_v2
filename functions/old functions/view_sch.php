<?php
include_once('../functions/general.php');
global $conn;

function scholarDisplay($currentPage = 1, $recordsPerPage = 15, $search = '', $sortColumn = 'scholar_id', $sortOrder = 'ASC') {
    global $conn;
    $offset = ($currentPage - 1) * $recordsPerPage;
    $searchQuery = $search ? "WHERE batch_num LIKE '%$search%' OR last_name LIKE '%$search%' OR first_name LIKE '%$search%' OR status LIKE '%$search%' OR school LIKE '%$search%'" : '';
    
    // Validate sort column and order
    $display = "SELECT * FROM scholar
                $searchQuery
                ORDER BY $sortColumn $sortOrder
                LIMIT $recordsPerPage OFFSET $offset";
    
    $result = $conn->query($display);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sch_id = substr($row["scholar_id"], 0, 2) . '-' . substr($row["scholar_id"], 2, 3);
            $style = "";
            if ($row["status"] == "ACTIVE") {
                $style = "color: rgb(0, 136, 0); font-weight: 600;";
            } elseif ($row["status"] == "PROBATION") {
                $style = "color: rgb(255,148,0); font-weight: 600;";
            } elseif ($row["status"] == "DROPPED") {
                $style = "color: rgb(189, 0, 0); font-weight: 600;";
            } elseif ($row["status"] == "LOA") {
                $style = "color: rgb(255, 219, 88); font-weight: 600;";
            } elseif ($row["status"] == "GRADUATE") {
                $style = "color: rgb(0,68,255); font-weight: 600;";
            }
            
            print '
                <tr>
                    <td> '.$sch_id.' </td>
                    <td> '.$row["last_name"].' </td>
                    <td> '.$row["first_name"].' </td>
                    <td> '.$row["school"].' </td>
                    <td style="'.$style.'"> '.$row["status"].' </td>
                    <td style="text-align: right;" class="wrap"> 
                        <form style="display:inline" action="ad_detail.php" method="post"><div class="icon">
                            <div class="tooltip"> View</div>
                            <input type="hidden" name="scholar_id" value="'.$row["scholar_id"].'">
                            
                            <button type="submit" name="view" style="all:unset;">
                            <span><ion-icon name="eye-outline"></ion-icon> </span></button>
                        </div></form>
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
                            <span> <ion-icon name="trash-outline" onclick="openDelete(this)" 
                                data-id="'.$row["user_id"].'" ></ion-icon> </span>
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
    global $conn;
    $searchQuery = $search ? "WHERE last_name LIKE '%$search%' OR first_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR status LIKE '%$search%'" : '';
    $countQuery = "SELECT COUNT(*) as total FROM scholar $searchQuery";
    $result = $conn->query($countQuery);
    $row = $result->fetch_assoc();
    return $row['total'];
}
?>
