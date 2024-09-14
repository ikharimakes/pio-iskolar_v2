<?php
include_once('../functions/general.php');
global $conn;

function scholarDisplay($current_page = 1, $sort_column = 'scholar_id', $sort_order = 'asc') {
    global $conn;

    $records_per_page = 15;
    $offset = ($current_page - 1) * $records_per_page;

    $valid_columns = ['scholar_id', 'last_name', 'first_name', 'school', 'status'];
    if (!in_array($sort_column, $valid_columns)) {
        $sort_column = 'scholar_id';
    }

    $sort_order = strtolower($sort_order) === 'desc' ? 'desc' : 'asc';

    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';

    $conditions = "1=1";
    if ($search !== '') {
        $conditions .= " AND (batch_no LIKE '%$search%' OR scholar_id LIKE '%$search%' OR last_name LIKE '%$search%' OR first_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR school LIKE '%$search%')";
    }
    if ($filter !== '' && $filter !== 'all') {
        $conditions .= " AND status = '$filter'";
    }

    $displayQuery = "SELECT * FROM scholar WHERE $conditions 
                     ORDER BY $sort_column $sort_order 
                     LIMIT $offset, $records_per_page";
    echo '<script> console.log('.'$displayQuery'.'"); </script>';
    $result = $conn->query($displayQuery);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sch_id = substr($row["scholar_id"], 0, 2) . '-' . substr($row["scholar_id"], 2, 3);
            $style = match ($row["status"]) {
                "ACTIVE" => "color: rgb(0, 136, 0); font-weight: 600;",
                "PROBATION" => "color: rgb(255,148,0); font-weight: 600;",
                "DROPPED" => "color: rgb(189, 0, 0); font-weight: 600;",
                "LOA" => "color: rgb(255, 219, 88); font-weight: 600;",
                "GRADUATE" => "color: rgb(0,68,255); font-weight: 600;",
                default => "",
            };

            echo '
                <tr>
                    <td><input type="checkbox" name="selected_rows[]"></td> 
                    <td style="text-align:center">'.$sch_id.'</td>
                    <td>'.$row["last_name"].'</td>
                    <td>'.$row["first_name"].'</td>
                    <td>'.$row["school"].'</td>
                    <td style="'.$style.'; text-align:center;">'.$row["status"].'</td>
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
                                data-id="'.$row["user_id"].'" ></ion-icon> </span>
                        </div>
                    </td>
                </tr>
            ';
        }
    } else {
        echo "<tr><td colspan='20'>No records found</td></tr>";
    }
}

function getTotalRecords() {
    global $conn;

    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';

    // Base condition for filtering
    $conditions = "1=1"; // This ensures that the WHERE clause is always valid

    // Add search conditions
    if ($search !== '') {
        $conditions .= " AND (last_name LIKE '%$search%' OR first_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR status LIKE '%$search%')";
    }

    // Add filter conditions
    if ($filter !== '' && $filter !== 'all') {
        $conditions .= " AND status = '$filter'";
    }

    $countQuery = "SELECT COUNT(*) as total FROM scholar WHERE $conditions";
    $result = $conn->query($countQuery);
    return $result->fetch_assoc()['total'];
}

?>
