<?php
include_once('../functions/general.php');

global $conn;

//* DOCUMENT DISPLAY - PENDING *//
function docxPending($current_page = 1, $sort_column = 'scholar_id', $sort_order = 'asc') {
    global $conn;

    $records_per_page = 15;
    $offset = ($current_page - 1) * $records_per_page;

    $valid_columns = ['scholar_id', 'doc_name', 'sub_date'];
    if (!in_array($sort_column, $valid_columns)) {
        $sort_column = 'sub_date';
    }

    $sort_order = strtolower($sort_order) === 'desc' ? 'desc' : 'asc';

    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';

    $conditions = "WHERE doc_status LIKE 'PENDING'";
    if ($search !== '') {
        $conditions .= " AND (doc_name LIKE '%$search%' OR scholar_id LIKE '%$search%')";
    }
    if ($filter !== '' && $filter !== 'all') {
        $conditions .= " AND doc_type = '$filter'";
    }

    $displayQuery = "SELECT * FROM submission $conditions 
                     ORDER BY $sort_column $sort_order 
                     LIMIT $offset, $records_per_page";
    $result = $conn->query($displayQuery);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $style = ($row["doc_status"] == "PENDING") ? "color: rgb(212, 120, 0); font-weight: 600;" : "";
            echo '
                <tr> 
                    <td><input type="checkbox" name="selected_rows[]"></td> 
                    <td style="text-align: center">'.$row["scholar_id"].'</td>
                    <td>'.$row["doc_name"].'</td>
                    <td style="text-align: center">'.$row["sub_date"].'</td>
                    <td style="text-align: center">'.$row["doc_type"].'</td>
                    <td style="'.$style.'; text-align: center">'.$row["doc_status"].'</td>
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
        echo "<tr><td colspan='7'>No records found</td></tr>";
    }
}

//* DOCUMENT DISPLAY - SCHOLAR-SIDE *//
function docxScholar($id, $current_page = 1, $sort_column = 'sub_date', $sort_order = 'asc') {
    global $conn, $context;
    $context = 'scholar';

    $records_per_page = 15;
    $offset = ($current_page - 1) * $records_per_page;

    $valid_columns = ['sub_date', 'doc_name'];
    if (!in_array($sort_column, $valid_columns)) {
        $sort_column = 'sub_date';
    }

    $sort_order = strtolower($sort_order) === 'desc' ? 'desc' : 'asc';

    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';

    $conditions = "WHERE scholar_id = '$id'";
    if ($search !== '') {
        $conditions .= " AND (doc_name LIKE '%$search%' OR doc_type LIKE '%$search%')";
    }
    if ($filter !== '' && $filter !== 'all') {
        $conditions .= " AND doc_type = '$filter'";
    }

    $displayQuery = "SELECT * FROM submission $conditions 
                     ORDER BY $sort_column $sort_order 
                     LIMIT $offset, $records_per_page";
    $result = $conn->query($displayQuery);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $style = "";
            $disabledClass = "";
            $style = match ($row["doc_status"]) {
                "PENDING" => "color: rgb(212, 120, 0); font-weight: 600;",
                "APPROVED" => "color: rgb(0, 136, 0); font-weight: 600;",
                "DECLINED" => "color: rgb(189, 0, 0); font-weight: 600;",
                default => "",
            };

            echo '
                <tr> 
                    <td><input type="checkbox" name="selected_rows[]"></td> 
                    <td style="text-align: center;">'.$row["sub_date"].'</td>
                    <td>'.$row["doc_name"].'</td>
                    <td style="text-align: center;">'.$row["doc_type"].'</td>
                    <td style="'.$style.'; text-align: center;">'.$row["doc_status"].'</td>
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

//* DOCUMENT DISPLAY - ADMIN-SIDE *//
function docxAdmin($id, $current_page = 1, $sort_column = 'sub_date', $sort_order = 'asc') {
    global $conn, $context;
    $context = 'scholar';

    $records_per_page = 15;
    $offset = ($current_page - 1) * $records_per_page;

    $valid_columns = ['doc_name', 'sub_date', 'doc_type', 'doc_status'];
    if (!in_array($sort_column, $valid_columns)) {
        $sort_column = 'sub_date';
    }

    $sort_order = strtolower($sort_order) === 'desc' ? 'desc' : 'asc';

    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';

    $conditions = "WHERE scholar_id = '$id'";
    if ($search !== '') {
        $conditions .= " AND (doc_name LIKE '%$search%' OR doc_type LIKE '%$search%')";
    }
    if ($filter !== '' && $filter !== 'all') {
        $conditions .= " AND doc_type = '$filter'";
    }

    $displayQuery = "SELECT * FROM submission $conditions 
                     ORDER BY $sort_column $sort_order 
                     LIMIT $offset, $records_per_page";
    $result = $conn->query($displayQuery);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $style = "";
            $disabledClass = "";
            $style = match ($row["doc_status"]) {
                "PENDING" => "color: rgb(212, 120, 0); font-weight: 600;",
                "APPROVED" => "color: rgb(0, 136, 0); font-weight: 600;",
                "DECLINED" => "color: rgb(189, 0, 0); font-weight: 600;",
                default => "",
            };

            echo '
                <tr>
                    <td><input type="checkbox" name="selected_rows[]"></td> 
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

//* FUNCTION TO FETCH TOTAL RECORDS *//
function getTotalRecords($context) {
    global $conn;
    
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';

    $conditions = "doc_status LIKE 'PENDING'";
    $id = '197';
    // $id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
    
    $conditions = $context === 'pending' ? $conditions : "scholar_id = '$id'";

    if ($search !== '') {
        $conditions .= " AND (doc_name LIKE '%$search%' OR scholar_id LIKE '%$search%')";
    }
    if ($filter !== '' && $filter !== 'all') {
        $conditions .= " AND doc_type = '$filter'";
    }

    $countQuery = "SELECT COUNT(*) as total_records FROM submission WHERE $conditions";
    $countResult = $conn->query($countQuery);
    return $countResult->fetch_assoc()['total_records'];
}
?>
