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
                    <td style="text-align: center">'.$row["scholar_id"].'</td>
                    <td>'.$row["doc_name"].'</td>
                    <td style="text-align: center">'.$row["sub_date"].'</td>
                    <td style="text-align: center">'.$row["doc_type"].'</td>
                    <td style="'.$style.'; text-align: center">'.$row["doc_status"].'</td>
                    <td style="float: right;" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip">View</div>
                            <span> <ion-icon name="eye-outline" onclick="openPrev(this)"
                                data-id="'.$row["submit_id"].'"  
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
                                type="submission" 
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

//* DOCUMENT DISPLAY - ADMIN-SIDE *//
function docxAdmin($id, $sort_column = 'sub_date', $sort_order = 'asc') {
    global $conn, $year, $sem;
    $valid_columns = ['doc_name', 'sub_date', 'doc_type', 'doc_status'];

    if (!in_array($sort_column, $valid_columns)) {
        $sort_column = 'sub_date';
    }

    $sort_order = strtolower($sort_order) === 'desc' ? 'desc' : 'asc';

    // Fetch the scholar's information
    $scholarQuery = "SELECT school FROM scholar WHERE scholar_id = '$id'";
    $scholarResult = $conn->query($scholarQuery);
    
    if ($scholarResult && $scholarResult->num_rows > 0) {
        $scholar = $scholarResult->fetch_assoc();
        $school = $scholar['school'];
        $acadYear = $year;

        $groupKey = $school . ', A.Y. ' . $acadYear . ', SEMESTER ' . $sem;

        // Query the submissions table
        $displayQuery = "SELECT * FROM submission WHERE scholar_id = '$id' ORDER BY school, acad_year, sem, $sort_column $sort_order";
        $result = $conn->query($displayQuery);

        $docTypes = ['COR', 'GRADES', 'SOCIAL'];
        $groupedSubmissions = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $groupKey = $row['school'] . ', A.Y. ' . $acadYear . ', SEMESTER ' . $sem;
                if (!isset($groupedSubmissions[$groupKey])) {
                    $groupedSubmissions[$groupKey] = [];
                }
                $groupedSubmissions[$groupKey][] = $row;
            }
        } else {
            // No submissions, create empty group
            $groupedSubmissions[$groupKey] = [];
        }

        // Display the accordion structure for the scholar
        echo '
        <div class="table">
            <button class="tblTitle active">
                <span>' . $groupKey . '</span>
                <ion-icon name="chevron-down-outline"></ion-icon>
            </button>
            <div class="tblContent" style="display:block;">
                <table>
                    <tr style="font-weight: bold;">
                        <th style="width:10%"> Type </th>
                        <th style="width:65%">
                            <div class="docName-header" id="sortDocName" style="cursor: pointer;">
                                Document Name
                            </div>
                        </th>
                        <th style="width:10%"> Status </th>
                        <th style="width:10%"> Submisison Date </th>
                        <th style="width:5%"> Action </th>
                    </tr>';

        // Loop through document types and check for submissions or show missing
        foreach ($docTypes as $docType) {
            $row = null;
            if (!empty($groupedSubmissions[$groupKey])) {
                foreach ($groupedSubmissions[$groupKey] as $submission) {
                    if ($submission['doc_type'] === $docType) {
                        $row = $submission;
                        break;
                    }
                }
            }

            if (!$row) {
                $row = [
                    'doc_name' => '',
                    'doc_status' => 'MISSING',
                    'sub_date' => '',
                    'submit_id' => '',
                    'reason' => ''
                ];
            }

            $status = $row['doc_status'];
            $style = match ($status) {
                'MISSING' => 'color: rgb(100, 100, 100); font-weight: 600;',
                'PENDING' => 'color: rgb(212, 120, 0); font-weight: 600;',
                'APPROVED' => 'color: rgb(0, 136, 0); font-weight: 600;',
                'DECLINED' => 'color: rgb(189, 0, 0); font-weight: 600;',
                default => '',
            };

            $disabledActions = [
                'view' => ($status === 'MISSING'),
                'approve' => ($status === 'MISSING' || $status === 'APPROVED' || $status === 'DECLINED'),
                'decline' => ($status === 'MISSING' || $status === 'APPROVED' || $status === 'DECLINED'),
                'upload' => ($status === 'PENDING' || $status === 'APPROVED' || $status === 'DECLINED'),
                'download' => ($status === 'MISSING'),
                'delete' => ($status === 'MISSING')
            ];

            echo '
                <tr>
                    <td style="text-align:center">' . $docType . '</td>
                    <td>' . $row['doc_name'] . '</td>
                    <td style="text-align:center;' . $style . '">' . $status . '</td>
                    <td style="text-align:center">' . $row['sub_date'] . '</td>
                    <td style="float: right;" class="wrap"> 
                        <div class="icon ' . ($disabledActions['view'] ? 'disabled' : '') . '" style="opacity: ' . ($disabledActions['view'] ? '0.5' : '1') . ';">
                            <div class="tooltip ' . ($disabledActions['view'] ? 'disabled-tooltip' : '') . '">View</div>
                            <span> <ion-icon name="eye-outline" onclick="openPrev(this)"
                                data-id="' . $row['submit_id'] . '"  
                                data-doc_name="' . $row['doc_name'] . '" 
                                data-doc_status="' . $row['doc_status'] . '"
                                data-doc_reason="' . $row['reason'] . '"></ion-icon> </span>
                        </div>

                        <div class="icon ' . ($disabledActions['upload'] ? 'disabled' : '') . '" style="opacity: ' . ($disabledActions['upload'] ? '0.5' : '1') . ';">
                            <div class="tooltip ' . ($disabledActions['upload'] ? 'disabled-tooltip' : '') . '">Upload</div>
                            <form action="" method="post" enctype="multipart/form-data">
                                <span> 
                                    <label for="' . $docType . '_' . $year . '_' . $sem . '">
                                    <ion-icon name="cloud-upload-outline"></ion-icon>
                                    </label> 
                                </span>
                                <input 
                                    id="' . $docType . '_' . $year . '_' . $sem . '" 
                                    name="' . $docType . '" 
                                    type="file" 
                                    accept=".pdf" 
                                    style="display: none;" 
                                    onchange="form.submit()" 
                                />
                                <input type="hidden" name="type" value="' . $docType . '">
                                <input type="hidden" name="upload" value="true">
                            </form>
                        </div>

                        <div class="icon ' . ($disabledActions['approve'] ? 'disabled' : '') . '" style="opacity: ' . ($disabledActions['approve'] ? '0.5' : '1') . ';">
                            <div class="tooltip ' . ($disabledActions['approve'] ? 'disabled-tooltip' : '') . '">Approve</div>
                            <span> <ion-icon name="checkmark-circle-outline" onclick="openApprove(this)" 
                                data-id="' . $row['submit_id'] . '"></ion-icon> </span>
                        </div>

                        <div class="icon ' . ($disabledActions['decline'] ? 'disabled' : '') . '" style="opacity: ' . ($disabledActions['decline'] ? '0.5' : '1') . ';">
                            <div class="tooltip ' . ($disabledActions['decline'] ? 'disabled-tooltip' : '') . '">Decline</div>
                            <span> <ion-icon name="close-circle-outline" onclick="openDecline(this)" 
                                data-id="' . $row['submit_id'] . '"></ion-icon> </span>
                        </div>

                        <div class="icon ' . ($disabledActions['download'] ? 'disabled' : '') . '" style="opacity: ' . ($disabledActions['download'] ? '0.5' : '1') . ';">
                            <div class="tooltip ' . ($disabledActions['download'] ? 'disabled-tooltip' : '') . '">Download</div>
                            <a href="../assets/' . $row['doc_name'] . '" download="' . $row['doc_name'] . '">
                                <span> <ion-icon name="download-outline"></ion-icon> </span>
                            </a>
                        </div>

                        <div class="icon ' . ($disabledActions['delete'] ? 'disabled' : '') . '" style="opacity: ' . ($disabledActions['delete'] ? '0.5' : '1') . ';">
                            <div class="tooltip ' . ($disabledActions['delete'] ? 'disabled-tooltip' : '') . '">Delete</div>
                            <span> <ion-icon name="trash-outline" onclick="openDelete(this)" 
                                type="submission" 
                                data-id="' . $row['submit_id'] . '" 
                                data-name="' . $row['doc_name'] . '"></ion-icon> </span>
                        </div>
                    </td>
                </tr>';
        }

        echo '</table>
            </div>
        </div>';
    } else {
        // Handle case where scholar is not found
        echo 'Scholar not found.';
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
        $conditions .= " AND doc_status = '$filter'";
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
                                type="submission" 
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
if (!function_exists('getTotalRecords')) {
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
}
?>
