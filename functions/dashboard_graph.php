<?php
include_once('../functions/general.php');
global $conn, $sem;

// Force JSON output, even for errors
header('Content-Type: application/json');

// Get selected batches from the query parameters
$batches = isset($_GET['batches']) ? $_GET['batches'] : 'ALL';

// Prepare the data structure
$batch_data = [];

// Initialize base condition
$conditions = "1=1"; // Default base condition (true)

// Handle batch filtering dynamically
if ($batches !== 'ALL') {
    $batchesArray = explode(',', $batches);
    $conditions .= " AND (";
    
    // Loop through each batch to create conditions like: batch_no = 31 OR batch_no = 32
    foreach ($batchesArray as $index => $batch_no) {
        $batch_no = intval($batch_no);  // Sanitize batch number
        if ($index > 0) {
            $conditions .= " OR ";
        }
        $conditions .= "batch_no = $batch_no";
    }
    
    $conditions .= ")";
}

// Debug the constructed WHERE clause
error_log("Final WHERE conditions: $conditions");

// Query for total scholars per batch
$query = "SELECT batch_no, COUNT(scholar_id) AS scholar_count FROM scholar WHERE $conditions GROUP BY batch_no";
$result = mysqli_query($conn, $query);

// Process the result
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

// Query for ACTIVE scholars
$active_query = "SELECT batch_no, COUNT(scholar_id) AS active_scholar_count FROM scholar WHERE $conditions AND status = 'ACTIVE' GROUP BY batch_no";
$result = mysqli_query($conn, $active_query);

while ($row = mysqli_fetch_assoc($result)) {
    $batch_no = $row['batch_no'];
    if (isset($batch_data[$batch_no])) {
        $batch_data[$batch_no]['active_scholars'] = $row['active_scholar_count'];
    }
}

// Query for PROBATION scholars
$probation_query = "SELECT batch_no, COUNT(scholar_id) AS probation_scholar_count FROM scholar WHERE $conditions AND status = 'PROBATION' GROUP BY batch_no";
$result = mysqli_query($conn, $probation_query);

while ($row = mysqli_fetch_assoc($result)) {
    $batch_no = $row['batch_no'];
    if (isset($batch_data[$batch_no])) {
        $batch_data[$batch_no]['probation_scholars'] = $row['probation_scholar_count'];
    }
}

// Query for LOA scholars
$loa_query = "SELECT batch_no, COUNT(scholar_id) AS loa_scholar_count FROM scholar WHERE $conditions AND status = 'LOA' GROUP BY batch_no";
$result = mysqli_query($conn, $loa_query);

while ($row = mysqli_fetch_assoc($result)) {
    $batch_no = $row['batch_no'];
    if (isset($batch_data[$batch_no])) {
        $batch_data[$batch_no]['loa_scholars'] = $row['loa_scholar_count'];
    }
}

// Query for DROPPED scholars
$dropped_query = "SELECT batch_no, COUNT(scholar_id) AS dropped_scholar_count FROM scholar WHERE $conditions AND status = 'DROPPED' GROUP BY batch_no";
$result = mysqli_query($conn, $dropped_query);

while ($row = mysqli_fetch_assoc($result)) {
    $batch_no = $row['batch_no'];
    if (isset($batch_data[$batch_no])) {
        $batch_data[$batch_no]['dropped_scholars'] = $row['dropped_scholar_count'];
    }
}

// Query for GRADUATED scholars
$graduated_query = "SELECT batch_no, COUNT(scholar_id) AS graduated_scholar_count FROM scholar WHERE $conditions AND status = 'GRADUATED' GROUP BY batch_no";
$result = mysqli_query($conn, $graduated_query);

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
?>
