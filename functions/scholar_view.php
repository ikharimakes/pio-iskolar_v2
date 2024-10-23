<?php
include_once('../functions/general.php');
global $conn;

//* Scholar List *//
function scholarList($current_page = 1, $sort_column = 'scholar_id', $sort_order = 'desc') {
    global $conn, $year, $sem, $batch;

    $records_per_page = 15;
    $offset = ($current_page - 1) * $records_per_page;

    $valid_columns = ['scholar_id', 'last_name', 'first_name', 'school', 'status'];
    if (!in_array($sort_column, $valid_columns)) {
        $sort_column = 'scholar_id';
    }

    $sort_order = strtolower($sort_order) === 'desc' ? 'desc' : 'asc';

    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';
    $category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
    $conditions = "1=1"; // Base condition

    // Search conditions
    if ($search !== '') {
        $conditions .= " AND (batch_no LIKE '%$search%' OR scholar_id LIKE '%$search%' OR last_name LIKE '%$search%' OR first_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR school LIKE '%$search%')";
    }

    // Filter by the dynamic category if both category and filter are provided
    if ($category !== 'all' && $filter !== 'all') {
        // Make sure the category column is valid and the filter value is correctly applied
        $valid_filter_columns = ['batch_no', 'status', 'school'];
        if (in_array($category, $valid_filter_columns)) {
            $conditions .= " AND $category = '" . $conn->real_escape_string($filter) . "'";
        }
    }

    // Build the final SQL query
    $displayQuery = "SELECT * FROM scholar WHERE $conditions 
                     ORDER BY $sort_column $sort_order 
                     LIMIT $offset, $records_per_page";
    $result = $conn->query($displayQuery);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sch_id = substr($row["scholar_id"], 0, 2) . '-' . substr($row["scholar_id"], 2, 3);
            $statusStyle = match ($row["status"]) {
                "ACTIVE" => "color: rgb(0, 136, 0); font-weight: 600;",
                "PROBATION" => "color: rgb(255,148,0); font-weight: 600;",
                "DROPPED" => "color: rgb(189, 0, 0); font-weight: 600;",
                "LOA" => "color: rgb(255, 219, 88); font-weight: 600;",
                "GRADUATED" => "color: rgb(0,68,255); font-weight: 600;",
                default => "",
            };

            // Check document submission status for COR, GRADES, SOCIAL
            $scholar_id = $row['scholar_id'];
            $doc_status_query = "
                SELECT doc_type, doc_status 
                FROM submission 
                WHERE scholar_id = '$scholar_id' 
                AND acad_year = '$year' 
                AND sem = '$sem' 
                AND doc_type IN ('COR', 'GRADES', 'SOCIAL')";
            $doc_result = $conn->query($doc_status_query);

            $required_docs = ['COR' => false, 'GRADES' => false, 'SOCIAL' => false];
            $overall_status = 'COMPLETE'; // Assume complete unless found otherwise

            // Check each document status
            if ($doc_result && $doc_result->num_rows > 0) {
                while ($doc_row = $doc_result->fetch_assoc()) {
                    $doc_type = $doc_row['doc_type'];
                    $doc_status = $doc_row['doc_status'];

                    // If any required document is pending, declined, or missing, mark as incomplete
                    if (in_array($doc_status, ['PENDING', 'DECLINED'])) {
                        $overall_status = 'INCOMPLETE';
                    }
                    $required_docs[$doc_type] = true; // Mark document as submitted
                }
            }

            // If any required document is missing, set status as INCOMPLETE
            if (in_array(false, $required_docs)) {
                $overall_status = 'INCOMPLETE';
            }

            
            $docStyle = match ($overall_status) {
                "INCOMPLETE" => "color: rgb(189, 0, 0); font-weight: 600;",
                "COMPLETE" => "color: rgb(0, 136, 0); font-weight: 600;",
                default => "",
            };
            
            // Display the scholar information with the dynamically calculated overall document status
            echo '
                <tr>
                    <td style="text-align:center">'.$sch_id.'</td>
                    <td>'.$row["last_name"].'</td>
                    <td>'.$row["first_name"].'</td>
                    <td>'.$row["school"].'</td>
                    <td style="'.$docStyle.'; text-align:center;">'.$overall_status.'</td>
                    <td style="'.$statusStyle.'; text-align:center;">'.$row["status"].'</td>
                    <td style="text-align: right;" class="wrap"> 
                        <form style="display:inline" action="ad_skoDetail.php" method="post">
                            <div class="icon">
                                <div class="tooltip"> View</div>
                                <input type="hidden" name="scholar_id" value="'.$row["scholar_id"].'">
                                <button type="submit" name="view" style="all:unset;">
                                <span><ion-icon name="eye-outline"></ion-icon> </span></button>
                            </div>
                        </form>
                        <div class="icon">
                            <div class="tooltip"> Delete</div>
                            <span> <ion-icon name="trash-outline" onclick="openDelete(this)" 
                                type="user" 
                                data-id="'.$row["user_id"].'" ></ion-icon> </span>
                        </div>
                    </td>
                </tr>
            ';
        }
    } else {
        echo "<tr><td colspan='20'>No results found</td></tr>";
    }
}

function getTotalRecords($category = '', $filter_value = '') {
    global $conn;

    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $conditions = "1=1"; // Base condition

    // Add search conditions
    if ($search !== '') {
        $conditions .= " AND (batch_no LIKE '%$search%' OR scholar_id LIKE '%$search%' OR last_name LIKE '%$search%' OR first_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR school LIKE '%$search%')";
    }

    // Add filter conditions if category and filter are set
    if ($category !== '' && $filter_value !== '' && $filter_value !== 'all') {
        $conditions .= " AND $category = '$filter_value'";
    }

    $countQuery = "SELECT COUNT(*) as total FROM scholar WHERE $conditions";
    $result = $conn->query($countQuery);
    return $result->fetch_assoc()['total'];
}

function getUniqueFilterValues($column) {
    global $conn;

    $valid_columns = ['batch_no', 'status', 'school']; // Define valid filterable columns
    if (!in_array($column, $valid_columns)) {
        return [];
    }

    // Query to get unique values sorted numerically/alphabetically
    $query = "SELECT DISTINCT $column FROM scholar ORDER BY $column";
    $result = $conn->query($query);

    $values = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values[] = $row[$column];
        }
    }

    return $values;
}

//* Scholar View - Admin*//
function scholarDetail() {
    global $conn;
    if(isset($_POST['scholar_id'])) {$_SESSION['sid'] = $_POST['scholar_id'];}
    $id = $_SESSION['sid'];
    // SCHOLAR DETAILS
    $display = "SELECT * FROM scholar WHERE scholar_id = '$id'";
    $result = $conn->query($display);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sch_id = substr($row["scholar_id"], 0, 2) . '-' . substr($row["scholar_id"], 2, 3);
            $profile = [
                'Scholar No.' => $sch_id,
                'School' => $row['school'],
                'Course' => $row['course'],
                'Scholar Status' => $row['status'],
                // '' => '',
                'Address' => $row['_address'],
                'Contact Number' => $row['contact'],
                'Email' => $row['email']
            ];
            echo '
                <div class="profile">
                    <form action="" method="post" id="profileForm">
                        <div class="profile_name">
                            <img src="images/profile.png" alt="Profile Picture"> <br>
                        </div>

                        <div class="profile-info">
                            <div class="detail-container">
                                <button type="button" class="edit" id="editButton">
                                    <h3> Edit </h3>
                                </button>
                                <button type="button" class="cancel" id="cancelButton" style="display:none;"> 
                                    <h3> Cancel </h3>
                                </button>
                            </div>
                            <table>
            ';
            foreach ($profile as $key => $value) {
                echo '
                    <tr>
                        <th style="width: 20%">'.$key.'</th>
                        <td>';
                if ($key == 'School') {
                    echo '<input type="text" list="school" name="school" value="'.$value.'" class="input2" style="text-align: left; width: 100%;" readonly>';
                    datalisting("school", "scholar", "school");
                } elseif ($key == 'Course') {
                    echo '<input type="text" list="course" name="course" value="'.$value.'" class="input2" style="text-align: left;" readonly>';
                    datalisting("course", "scholar", "course");
                } elseif ($key == 'Scholar Status') {
                    echo '<select name="scholar_status" id="scholarStatus" class="input2" style="text-align: left; border: none; outline: 0;" disabled>
                            <option value="ACTIVE" '.($value == 'ACTIVE' ? 'selected' : '').' style="color: rgb(0, 136, 0);">ACTIVE</option>
                            <option value="PROBATION" '.($value == 'PROBATION' ? 'selected' : '').' style="color: rgb(255,148,0);">PROBATION</option>
                            <option value="DROPPED" '.($value == 'DROPPED' ? 'selected' : '').' style="color: rgb(189, 0, 0);">DROPPED</option>
                            <option value="LOA" '.($value == 'LOA' ? 'selected' : '').' style="color: rgb(255, 219, 88);">LOA</option>
                            <option value="GRADUATED" '.($value == 'GRADUATED' ? 'selected' : '').' style="color: rgb(0,68,255);">GRADUATED</option>
                        </select>';
                } elseif ($key == 'Batch ID') {
                    echo '<input type="text" name="batch_id" value="'.$value.'" class="input2" style="text-align: left;s" readonly>';
                } else {
                    echo '<input type="text" name="'.strtolower(str_replace(' ', '_', $key)).'" value="'.$value.'" class="input2" style="text-align: left;" readonly>';
                }
                echo '</td>
                    </tr>
                ';
            }
            echo '
                            </table>
                            <button type="submit" name="save" class="save" id="saveButton" style="display:none;">
                                <h3>Save</h3>
                            </button>
                        </div>
                    </form>
                </div>
            ';
        }
    }
}

//* Scholar View - Scholar*//
function scholarView() {
    global $conn;
    if(isset($_POST['scholar_id'])) {$_SESSION['sid'] = $_POST['scholar_id'];}
    $id = $_SESSION['sid'];
    // SCHOLAR DETAILS
    $display = "SELECT * FROM scholar WHERE scholar_id = '$id'";
    $result = $conn->query($display);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sch_id = substr($row["scholar_id"], 0, 2) . '-' . substr($row["scholar_id"], 2, 3);
            $profile = [
                'Scholar No.' => $sch_id,
                'School' => $row['school'],
                'Course' => $row['course'],
                'Scholar Status' => $row['status'],
                // '' => '',
                'Address' => $row['_address'],
                'Contact Number' => $row['contact'],
                'Email' => $row['email']
            ];
            echo '
                <div class="profile">
                    <form action="" method="post" id="profileForm">
                        <div class="profile_name">
                            <img src="images/profile.png" alt="Profile Picture"> <br>
                        </div>

                        <div class="profile-info">
                            <table>
            ';
            foreach ($profile as $key => $value) {
                echo '
                    <tr>
                        <th style="width: 20%">'.$key.'</th>
                        <td>';
                if ($key == 'School') {
                    echo '<input type="text" name="school" value="'.$value.'" class="input2" style="text-align: left; width: 100%;" readonly>';
                } elseif ($key == 'Course') {
                    echo '<input type="text" name="course" value="'.$value.'" class="input2" style="text-align: left;" readonly>';
                } elseif ($key == 'Scholar Status') {
                    echo '<input name="scholar_status" id="scholarStatus" class="input2" style="text-align: left;" readonly>';
                } elseif ($key == 'Batch ID') {
                    echo '<input type="text" name="batch_id" value="'.$value.'" class="input2" style="text-align: left;s" readonly>';
                } else {
                    echo '<input type="text" name="'.strtolower(str_replace(' ', '_', $key)).'" value="'.$value.'" class="input2" style="text-align: left;" readonly>';
                }
                echo '</td>
                    </tr>
                ';
            }
            echo '
                            </table>
                        </div>
                    </form>
                </div>
            ';
        }
    }
}
?>
