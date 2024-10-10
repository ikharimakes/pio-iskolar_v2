<?php
include_once('../functions/general.php');
global $conn, $sem;

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Force JSON output, even for errors
header('Content-Type: application/json');

// Debugging helper function to log and output errors
function debug_log($message) {
    error_log($message);
    echo json_encode(["error" => $message]);
    exit;
}

// Check if database connection is established
if (!$conn) {
    debug_log("Database connection failed: " . mysqli_connect_error());
}

// Get selected batches from the query parameters
$batches = isset($_GET['batches']) ? $_GET['batches'] : 'ALL';
$batchCondition = "";

// If specific batches are selected, filter by those batches
if ($batches !== 'ALL') {
    // Convert the batches into a comma-separated string of quoted batch numbers
    $batchesArray = explode(',', $batches);
    $batchCondition = "WHERE batch_no IN ('" . implode("','", array_map('intval', $batchesArray)) . "')";
}

// Debug: log batch condition and request
error_log("Batches: " . json_encode($batches));
error_log("Batch Condition: $batchCondition");

// Prepare the data structure
$batch_data = [];

// Fetch total scholars per batch
$query = "SELECT batch_no, COUNT(scholar_id) AS scholar_count FROM scholar $batchCondition GROUP BY batch_no";
error_log("Query: $query");

$result = mysqli_query($conn, $query);

if (!$result) {
    debug_log("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $batch_no = $row['batch_no'];
    $batch_data[$batch_no] = [
        'batch_no' => "Batch " . $batch_no,
        'total_scholars' => $row['scholar_count'],
        'active_scholars' => 0,
        'probation_scholars' => 0,
        'loa_scholars' => 0,
        'dropped_scholars' => 0,
        'graduated_scholars' => 0
    ];
}

// Fetch ACTIVE scholars
$query = "SELECT batch_no, COUNT(scholar_id) AS active_scholar_count FROM scholar WHERE status = 'ACTIVE' $batchCondition GROUP BY batch_no";
error_log("Query: $query");

$result = mysqli_query($conn, $query);

if (!$result) {
    debug_log("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $batch_no = $row['batch_no'];
    if (isset($batch_data[$batch_no])) {
        $batch_data[$batch_no]['active_scholars'] = $row['active_scholar_count'];
    }
}

// Fetch PROBATION scholars
$query = "SELECT batch_no, COUNT(scholar_id) AS probation_scholar_count FROM scholar WHERE status = 'PROBATION' $batchCondition GROUP BY batch_no";
error_log("Query: $query");

$result = mysqli_query($conn, $query);

if (!$result) {
    debug_log("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $batch_no = $row['batch_no'];
    if (isset($batch_data[$batch_no])) {
        $batch_data[$batch_no]['probation_scholars'] = $row['probation_scholar_count'];
    }
}

// Fetch LOA scholars
$query = "SELECT batch_no, COUNT(scholar_id) AS loa_scholar_count FROM scholar WHERE status = 'LOA' $batchCondition GROUP BY batch_no";
error_log("Query: $query");

$result = mysqli_query($conn, $query);

if (!$result) {
    debug_log("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $batch_no = $row['batch_no'];
    if (isset($batch_data[$batch_no])) {
        $batch_data[$batch_no]['loa_scholars'] = $row['loa_scholar_count'];
    }
}

// Fetch DROPPED scholars
$query = "SELECT batch_no, COUNT(scholar_id) AS dropped_scholar_count FROM scholar WHERE status = 'DROPPED' $batchCondition GROUP BY batch_no";
error_log("Query: $query");

$result = mysqli_query($conn, $query);

if (!$result) {
    debug_log("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $batch_no = $row['batch_no'];
    if (isset($batch_data[$batch_no])) {
        $batch_data[$batch_no]['dropped_scholars'] = $row['dropped_scholar_count'];
    }
}

// Fetch GRADUATED scholars
$query = "SELECT batch_no, COUNT(scholar_id) AS graduated_scholar_count FROM scholar WHERE status = 'GRADUATED' $batchCondition GROUP BY batch_no";
error_log("Query: $query");

$result = mysqli_query($conn, $query);

if (!$result) {
    debug_log("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $batch_no = $row['batch_no'];
    if (isset($batch_data[$batch_no])) {
        $batch_data[$batch_no]['graduated_scholars'] = $row['graduated_scholar_count'];
    }
}

// Prepare data for JSON response
$response = [
    'labels' => array_column($batch_data, 'batch_no'),
    'total_scholars' => array_column($batch_data, 'total_scholars'),
    'active_scholars' => array_column($batch_data, 'active_scholars'),
    'probation_scholars' => array_column($batch_data, 'probation_scholars'),
    'loa_scholars' => array_column($batch_data, 'loa_scholars'),
    'dropped_scholars' => array_column($batch_data, 'dropped_scholars'),
    'graduated_scholars' => array_column($batch_data, 'graduated_scholars')
];

// Output the final JSON response
echo json_encode($response);

// Debug: Log final response
error_log("Final JSON response: " . json_encode($response));
?>
