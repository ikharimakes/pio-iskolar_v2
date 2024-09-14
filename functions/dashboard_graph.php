<?php
    include_once('../functions/general.php');
    global $conn, $sem;
    $query = "SELECT batch_no, COUNT(scholar_id) AS scholar_count FROM scholar GROUP BY batch_no";
    $result = mysqli_query($conn, $query);

    // Prepare data for labels and the first dataset (total scholars)
    $batch_data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $batch_no = $row['batch_no'];
        $batch_data[$batch_no] = [
            'batch_no' => "Batch " . $batch_no,
            'total_scholars' => $row['scholar_count'],
            'active_scholars' => 0 // default, will update next
        ];
    }

    // Retrieve the number of ACTIVE scholars per batch
    $query = "SELECT batch_no, COUNT(scholar_id) AS active_scholar_count FROM scholar WHERE status = 'ACTIVE' GROUP BY batch_no";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $batch_no = $row['batch_no'];
        if (isset($batch_data[$batch_no])) {
            $batch_data[$batch_no]['active_scholars'] = $row['active_scholar_count'];
        }
    }

    // Prepare data for JSON response
    $response = [
        'labels' => array_column($batch_data, 'batch_no'),
        'total_scholars' => array_column($batch_data, 'total_scholars'),
        'active_scholars' => array_column($batch_data, 'active_scholars')
    ];

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>