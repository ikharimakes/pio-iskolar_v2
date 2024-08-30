<?php
    include_once('../functions/general.php');
    global $conn;
    global $year;
    global $sem;

//* DISPLAY DOCUMENTS *//
    function getDocumentsStatus() {
        global $conn;
        if(isset($_POST['scholar_id'])) {$_SESSION['sid'] = $_POST['scholar_id'];}
        $id = $_SESSION['sid'];

        $query = "SELECT acad_year, sem, doc_type, doc_status FROM submission WHERE scholar_id = '$id'";
        $result = $conn->query($query);

        $documents = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $documents[$row['acad_year']][$row['sem']][$row['doc_type']] = $row['doc_status'];
            }
        }
        return $documents;
    }
    
    function displayDocumentsTable($documents) {
        global $conn;
        global $year;
        global $sem;
    
        $currentYear = $year;
        $currentSem = $sem;
    
        if (isset($_POST['scholar_id'])) {
            $_SESSION['sid'] = $_POST['scholar_id'];
        }
        $id = substr($_SESSION['sid'], 0, 2);
    
        // Fetch the academic year based on the scholar's batch number
        $query = "SELECT acad_year FROM batch_year WHERE batch_no = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($acadYear);
        $stmt->fetch();
        $stmt->close();
    
        // Extract the starting year from the formatted acad_year (e.g., "2020-2021")
        list($startYear, $endYear) = explode('-', $acadYear);
        $startYear = (int)$startYear;  // Ensure it is an integer
    
        // Define the number of years to be displayed
        $numberOfYears = 5;
    
        // Generate the academic years array starting from the retrieved start year
        $years = [];
        for ($i = 0; $i < $numberOfYears; $i++) {
            $start = $startYear + $i;
            $end = $start + 1;
            $years[] = "$start-$end";
        }
    
        // Define the semesters and types
        $sems = [1, 2, 3];
        $types = ['COR', 'TOR', 'SCF'];
    
        // Status colors
        $statusColors = [
            'PENDING' => 'rgb(212, 120, 0)',
            'APPROVED' => 'rgb(0, 136, 0)',
            'DECLINED' => 'rgb(189, 0, 0)',
            'MISSING' => 'grey'
        ];
    
        // Display the documents table
        foreach ($years as $acad_year) {
            echo "<tr><th class='details2'>$acad_year</th>";
    
            foreach ($sems as $semester) {
                foreach ($types as $type) {
                    if (($acad_year < $currentYear || ($acad_year == $currentYear && $semester <= $currentSem)) && !($semester == 3)) {
                        // Show status for past and present academic years and semesters
                        $status = isset($documents[$acad_year][$semester][$type]) ? $documents[$acad_year][$semester][$type] : 'MISSING';
                        $color = $statusColors[$status];
                        echo "<td class='details2' style='color: $color;'>$status</td>";
                    } else if ($semester == 3 && isset($documents[$acad_year][$semester][$type])) {
                        // Show status if data exists for future 3rd semester
                        $status = $documents[$acad_year][$semester][$type];
                        $color = $statusColors[$status];
                        echo "<td class='details2' style='color: $color;'>$status</td>";
                    } else {
                        // Leave blank for future 3rd semester if no data exists
                        echo "<td class='details2'></td>";
                    }
                }
            }
    
            echo "</tr>";
        }
    }    


//* DISPLAY STATUS *//
// Function to display status table with empty entries
function displayStatusTable() {
    global $conn;
    if (isset($_POST['scholar_id'])) {
        $_SESSION['sid'] = $_POST['scholar_id'];
    }
    $id = substr($_SESSION['sid'], 0, 2);

    // Fetch the academic year based on the scholar's batch number
    $query = "SELECT acad_year FROM batch_year WHERE batch_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($acadYear);
    $stmt->fetch();
    $stmt->close();

    // Extract the starting year from the formatted acad_year (e.g., "2020-2021")
    list($startYear, $endYear) = explode('-', $acadYear);
    $startYear = (int)$startYear;  // Ensure it is an integer

    // Define the number of years to be displayed
    $numberOfYears = 5;

    // Generate the academic years array starting from the retrieved start year
    $years = [];
    for ($i = 0; $i < $numberOfYears; $i++) {
        $start = $startYear + $i;
        $end = $start + 1;
        $years[] = "$start-$end";
    }

    $query = "SELECT acad_year, sem, _status FROM status WHERE scholar_id = '{$_SESSION['sid']}'";
    $result = $conn->query($query);
    $statuses = [];
    while ($row = $result->fetch_assoc()) {
        $statuses[$row['acad_year']][$row['sem']] = $row['_status'];
    }

    foreach ($years as $acad_year) {
        echo "<tr><th class='details2'>$acad_year</th>";
        for ($i = 1; $i <= 3; $i++) {
            $status = isset($statuses[$acad_year][$i]) ? $statuses[$acad_year][$i] : '';
            echo "<td><input type='text' class='input2' value='$status' data-acad-year='$acad_year' data-sem='$i' readonly></td>";
        }
        echo "</tr>";
    }
}

//* DISPLAY REMARKS *//
    function displayRemarks() {
        global $conn;
        $query = "SELECT remarks FROM scholar WHERE scholar_id = '{$_SESSION['sid']}'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $remarks = $row['remarks'] ?? '';

        print '
            <td>
                <textarea rows="10" class="input3" disabled>'.$remarks.'</textarea>
            </td>
        ';
    }
    
//* DOCUMENT UPLOAD - ADMIN *//
    if(isset($_POST['submission'])) {
        global $conn;
        $sem = $_POST['sem'];
        $year = $_POST['acad_year'];
        $id = $_SESSION['sid'];
        $date = date("Y-m-d");
        
        $file_fields = ['COR', 'TOR', 'SCF'];
        $submitted_docs = [];
        $scholar_info = null;

        $batch_query = "SELECT batch_no FROM batch_year WHERE acad_year = '$year'";
        $batch_result = $conn->query($batch_query);
        if ($batch_result->num_rows > 0) {
            $batch_row = $batch_result->fetch_assoc();
            $batch = $batch_row['batch_no'];
        }

        foreach($file_fields as $field) {
            if(!empty($_FILES[$field]['tmp_name']) && is_uploaded_file($_FILES[$field]['tmp_name'])) {
                if (!$scholar_info) {
                    $query = "SELECT batch_num, last_name, first_name, middle_name FROM scholar WHERE scholar_id = '$id'";
                    $result = $conn->query($query);
                    $scholar_info = $result->fetch_assoc();
                    $level = ($batch - $scholar_info['batch_num']) + 1;
                }

                $name = $scholar_info['last_name'].'_'.$scholar_info['first_name'].'_'.$scholar_info['middle_name'].'_Year'.$level.'_Sem'.$sem.'_'.$field.'.pdf';
                
                $upload_temp = $_FILES[$field]['tmp_name'];
                move_uploaded_file($upload_temp, "../assets/$name");

                // Override if a document exists with the same acad_year, sem, and doc_type
                $check_query = "SELECT * FROM submission WHERE scholar_id = '$id' AND doc_type = '$field' AND acad_year = '$year' AND sem = '$sem'";
                $check_result = $conn->query($check_query);
                if ($check_result->num_rows > 0) {
                    // Update the existing document record
                    $update = "UPDATE submission SET sub_date = '$date', doc_name = '$name', doc_status = 'APPROVED' WHERE scholar_id = '$id' AND doc_type = '$field' AND acad_year = '$year' AND sem = '$sem'";
                    $execute = $conn->query($update);
                } else {
                    // Insert a new document record
                    $insert = "INSERT INTO submission (submit_id, scholar_id, sub_date, doc_name, doc_type, acad_year, sem, doc_status) VALUES (NULL, '$id', '$date', '$name', '$field', '$year', '$sem', 'APPROVED')";
                    $execute = $conn->query($insert);
                }
                
                if (!$execute) {
                    die(mysqli_error($conn));
                }

                $submitted_docs[] = $name;
            }
        }
    }

    if (isset($_POST['scholarship'])) {
        foreach ($_POST['scholarship'] as $entry) {
            $acad_year = $conn->real_escape_string($entry['acad_year']);
            $sem = $conn->real_escape_string($entry['sem']);
            $status = $conn->real_escape_string($entry['status']);
            $scholar_id = $_SESSION['sid'];

            $query = "REPLACE INTO status (scholar_id, acad_year, sem, status) VALUES ('$scholar_id', '$acad_year', '$sem', '$status')";
            $conn->query($query);
        }
    }

    if (isset($_POST['remarks'])) {
        $remarks = $conn->real_escape_string($_POST['remarks']);
        $scholar_id = $_SESSION['sid'];

        $query = "UPDATE scholar SET remarks = '$remarks' WHERE scholar_id = '$scholar_id'";
        $conn->query($query);
    }
?>
