<?php
    include_once('../functions/general.php');
    global $conn;

//* DASHBOARD *//
function activeEvents() {
    global $conn, $sem;

    $query = "SELECT title FROM announcements WHERE status = 'ACTIVE' ORDER BY st_date DESC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row['title'] . "</li>";
        // echo "<li><a>" . $row['title'] . "</a></li>";
    }
}

function summaryScholars() {
    global $conn;

    $query = "SELECT 
        (SELECT COUNT(*) FROM scholar) AS total_scholars,
        (SELECT COUNT(*) FROM scholar WHERE status = 'ACTIVE') AS active_scholars,
        (SELECT COUNT(*) FROM scholar WHERE status = 'PROBATION') AS probation_scholars,
        (SELECT COUNT(*) FROM scholar WHERE status = 'LOA') AS loa_scholars";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Create the form submissions using PHP
    echo "
        <div class='box-row'>
            <div class='box box-small'>
                <form method='POST' style='margin:0;'>
                    <input type='hidden' name='scholar_redirect' value='1'>
                    <button type='submit' class='box-link'>
                        <h5 class='detail'>Total Scholars</h5>
                        <div class='box-num'>
                            <h2 class='num'>{$row['total_scholars']}</h2>
                        </div>
                    </button>
                </form>
            </div>

            <div class='box box-small'>
                <form method='POST' style='margin:0;'>
                    <input type='hidden' name='scholar_redirect' value='1'>
                    <input type='hidden' name='category' value='status'>
                    <input type='hidden' name='filter' value='ACTIVE'>
                    <button type='submit' class='box-link'>
                        <h5 class='detail'>Active Scholars</h5>
                        <div class='box-num'>
                            <h2 class='num'>{$row['active_scholars']}</h2>
                        </div>
                    </button>
                </form>
            </div>

            <div class='box box-small'>
                <form method='POST' style='margin:0;'>
                    <input type='hidden' name='scholar_redirect' value='1'>
                    <input type='hidden' name='category' value='status'>
                    <input type='hidden' name='filter' value='PROBATION'>
                    <button type='submit' class='box-link'>
                        <h5 class='detail'>Scholars on Probation</h5>
                        <div class='box-num'>
                            <h2 class='num'>{$row['probation_scholars']}</h2>
                        </div>
                    </button>
                </form>
            </div>

            <div class='box box-small'>
                <form method='POST' style='margin:0;'>
                    <input type='hidden' name='scholar_redirect' value='1'>
                    <input type='hidden' name='category' value='status'>
                    <input type='hidden' name='filter' value='LOA'>
                    <button type='submit' class='box-link'>
                        <h5 class='detail'>Scholars on Leave of Absence</h5>
                        <div class='box-num'>
                            <h2 class='num'>{$row['loa_scholars']}</h2>
                        </div>
                    </button>
                </form>
            </div>
        </div>

        <style>
        .box-link {
            width: 100%;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            text-align: left;
        }
        .box-link:hover {
            opacity: 0.9;
        }
        </style>
    ";
}

function summaryDocs() {
    global $conn;
    $scholar_id = $_SESSION['sid'];

    $query = "SELECT 
            (SELECT COUNT(*) from submission WHERE doc_status = 'PENDING' AND scholar_id = '$scholar_id') AS pending_docs,
            (SELECT COUNT(*) from submission WHERE doc_status = 'APPROVED' AND scholar_id = '$scholar_id') AS approved_docs,
            (SELECT COUNT(*) from submission WHERE doc_status = 'DECLINED' AND scholar_id = '$scholar_id') AS declined_docs";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    echo "
        <div class='box-row'>
        <div class='box box-small'>
            <h5 class='detail'>Total Submitted Documents</h5>

            <div class='box-num'>
                <h2 class='num'>{$row['pending_docs']}</h2>
            </div>
        </div>

        <div class='box box-small'>
            <h5 class='detail'>Approved Documents</h5>

            <div class='box-num'>
                <h2 class='num'>{$row['approved_docs']}</h2>
            </div>
        </div>

        <div class='box box-small'>
            <h5 class='detail'>Declined Documents</h5>

            <div class='box-num'>
                <h2 class='num'>{$row['declined_docs']}</h2>
            </div>
        </div>
    </div>
    ";
}
?>