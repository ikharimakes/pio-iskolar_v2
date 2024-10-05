<?php
    include_once('../functions/general.php');
    global $conn;

//* DASHBOARD *//
function pendingFiles() {
    global $conn, $sem;
    // Number of PENDING documents for each document label (doc_type)
    $query = "SELECT doc_type, COUNT(*) AS pending_count FROM submission WHERE doc_status = 'PENDING' GROUP BY doc_type";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "
            <tr> 
                <td style='text-align: center; width: 10%'>" . $row['pending_count'] . "</td>
                <td style='width: 90%'>" . $row['doc_type'] . "</td>
            </tr>
        ";
    }
    // Total number of PENDING documents
    $query = "SELECT COUNT(*) AS total_pending FROM submission WHERE doc_status = 'PENDING'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    echo "
        <tr> 
            <td style='text-align: center; width: 10%'>" . $row['total_pending'] . "</td>
            <td style='width: 90%'> PENDING</td>
        </tr>
    ";
}

function existingFiles() {
    global $conn, $sem;

    $query = "SELECT s.batch_no, COUNT(sub.submit_id) AS file_count
              FROM scholar s
              JOIN submission sub ON s.scholar_id = sub.scholar_id
              GROUP BY s.batch_no";
    $result= mysqli_query($conn, $query);
    while ($row= mysqli_fetch_assoc($result)) {
        echo "<li>Batch " . $row['batch_no'] . ": " . $row['file_count'] . " Documents </li>";
    }
}

function activeEvents() {
    global $conn, $sem;

    $query = "SELECT title FROM announcements WHERE status = 'ACTIVE' ORDER BY st_date DESC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li><a>" . $row['title'] . "</a></li>";
    }
}

function summaryScholars() {
    global $conn, $sem;

    $query = "SELECT 
        (SELECT COUNT(*) FROM scholar) AS total_scholars,
        (SELECT COUNT(*) FROM scholar WHERE status = 'ACTIVE') AS active_scholars,
        (SELECT COUNT(*) FROM scholar WHERE status = 'LOA') AS loa_scholars,
        (SELECT COUNT(*) FROM scholar WHERE status = 'DROPPED') AS dropped_scholars";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    echo "
        <div class='card'> 
            <div class='container'>
                <h5 class='detail'> Active Scholars </h5>
                <h2 class='num'>" . $row['active_scholars'] . "</h2>
            </div>
        </div>

        <div class='card'> 
            <div class='container'>
                <h5 class='detail'> Total Scholars </h5>
                <h2 class='num'>" . $row['total_scholars'] . "</h2>
            </div> 
        </div>

        <div class='card'> 
            <div class='container'>
                <h5 class='detail'> LOA </h5>
                <h2 class='num'>" . $row['loa_scholars'] . "</h2>
            </div>
        </div>

        <div class='card'> 
            <div class='container'>
                <h5 class='detail'> Dropped </h5>
                <h2 class='num'>" . $row['loa_scholars'] . "</h2>
            </div> 
        </div>
    ";
}
?>