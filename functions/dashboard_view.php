<?php
    include_once('../functions/general.php');
    global $conn;

//* DASHBOARD *//
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
    //! on click - redirect to ad_scholar w/filters, hidden from url!//
    echo "
        <div class='box-row'>
            <div class='box box-small'>
                <h5 class='detail'>Academic Scholars</h5>

                <div class='box-num'>
                    <h2 class='num'>" . $row['active_scholars'] . "</h2>
                </div>
            </div>

            <div class='box box-small'>
                <h5 class='detail'>Total Scholars</h5>

                <div class='box-num'>
                    <h2 class='num'>" . $row['total_scholars'] . "</h2>
                </div>
            </div>

            <div class='box box-small'>
                <h5 class='detail'>Leave of Absence</h5>

                <div class='box-num'>
                    <h2 class='num'>" . $row['loa_scholars'] . "</h2>
                </div>
            </div>

            <div class='box box-small'>
                <h5 class='detail'>Dropped</h5>

                <div class='box-num'>
                    <h2 class='num'>" . $row['loa_scholars'] . "</h2>
                </div>
            </div>
        </div>
    ";
}
?>