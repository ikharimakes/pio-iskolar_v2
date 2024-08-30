<?php
    include_once('../functions/general.php');
global $conn;

//* REPORT CREATION *//
if(isset($_POST['generate'])){
    global $sem;
    global $batch;
    $report = $_POST['report'];
    $cur_batch = $_POST['batch_id'];
    $date = date("Y-m-d");

    if($report == 'status') {
        // Generate Scholar Status Report
        $status = "SELECT 
                    (SELECT acad_year FROM batch_year WHERE batch_no = '$batch') AS acad_year,
                    COUNT(*) AS scholar_count,
                    COUNT(CASE WHEN status = 'ACTIVE' THEN 1 END) AS active,
                    COUNT(CASE WHEN status = 'PROBATION' THEN 1 END) AS probation,
                    COUNT(CASE WHEN status = 'DROPPED' THEN 1 END) AS dropped,
                    COUNT(CASE WHEN status = 'LOA' THEN 1 END) AS loa,
                    COUNT(CASE WHEN status = 'GRADUATED' THEN 1 END) AS graduate
                FROM scholar WHERE batch_num = '$cur_batch'";
        $result = $conn->query($status);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $content = '
                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>
                SCHOLAR STATUS REPORT<br>
                S.Y. '.$row['acad_year'].'</h3> <br>
                    
                Batch Number: <strong>'.$cur_batch.'</strong>

                <p> This report provides an overview of the current status of scholars under the Dr. Pio Valenzuela Scholarship Program for the school year <strong>'.$row['acad_year'].'</strong>. As of <strong>'.$date.'</strong>, there are a total of <strong>'.$row['scholar_count'].'</strong> scholars enrolled in the program for Batch Number <strong>'.$cur_batch.'</strong>. The table below presents the current status of scholars under the Dr. Pio Valenzuela Scholarship Program, along with the total number of scholars based on their status: </p>
                <br>
                Total Active Scholars: <strong>'.$row['active'].'</strong> <br>
                Total Dropped Scholars: <strong>'.$row['dropped'].'</strong> <br>
                Total Scholars on Leave of Absence: <strong>'.$row['loa'].'</strong> <br>
                Total Graduated Scholars: <strong>'.$row['graduate'].'</strong> <br>
                ';
                
                $title = "Scholar Status Report for Batch $cur_batch - S.Y. ".$row['acad_year'];
                
                // Insert the report into the reports table
                $insertReport = $conn->prepare("INSERT INTO reports (batch_no, report_type, creation_date, acad_year, title, content) VALUES (?, ?, ?, ?, ?, ?)");
                $reportType = 'status';
                $insertReport->bind_param("ssssss", $cur_batch, $reportType, $date, $row['acad_year'], $title, $content);
                $insertReport->execute();
            }
        }
    } elseif ($report == 'profile') {
        // Generate Scholar Profile and Requirements Report
        $profile = "SELECT 
                        (SELECT acad_year FROM batch_year WHERE batch_no = '$batch') AS acad_year,
                        (SELECT COUNT(*) FROM scholar WHERE batch_num = '$cur_batch') AS scholar_count,
                        COUNT(CASE WHEN doc_type IN ('COR', 'TOR', 'SCF') AND status = 'APPROVED' THEN 1 END) AS approved,
                        COUNT(CASE WHEN doc_type NOT IN ('COR', 'TOR', 'SCF') OR status <> 'APPROVED' THEN 1 END) AS missing
                    FROM submission LEFT JOIN scholar ON submission.scholar_id = scholar.scholar_id WHERE scholar.batch_num = '$cur_batch'";
        
        $result = $conn->query($profile);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $content = "
                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>
                SCHOLAR PROFILE AND REQUIREMENTS REPORT<br>
                ".$sem." Semester of S.Y. ".$row['acad_year']."</h3><br>
        
                Batch Number: <strong>".$cur_batch."</strong>
        
                <p> This report provides a comprehensive overview of the profile and current requirement status of scholars under the Dr. Pio Valenzuela Scholarship Program for the <strong>".$sem."</strong> Semester of S.Y. <strong>".$row['acad_year']."</strong>. As of <strong>".$date."</strong>, there are a total of <strong>".$row['scholar_count']."</strong> scholars enrolled in the program for Batch Number <strong>".$cur_batch."</strong>. The table below presents the profile of scholars and the current status of their requirements, along with the total number of scholars who have completed their requirements, and the number of scholars with missing requirements. This report is crucial for monitoring the progress of scholars and ensuring that they meet the program's criteria and obligation. </p>
                <br>
                    
                Total Number of Scholars: <strong>".$row['scholar_count']."</strong> <br>
                Total Number of Scholars with Complete Requirements: <strong>".$row['approved']."</strong> <br>
                Total Number of Scholars with Missing Requirements: <strong>".$row['missing']."</strong> <br> <br>
                ";
                
                $title = "Scholar Profile and Requirements Report for Batch $cur_batch - ".$sem." Semester of S.Y. ".$row['acad_year'];
                
                // Insert the report into the reports table
                $insertReport = $conn->prepare("INSERT INTO reports (batch_no, report_type, creation_date, acad_year, title, content) VALUES (?, ?, ?, ?, ?, ?)");
                $reportType = 'profile';
                $insertReport->bind_param("ssssss", $cur_batch, $reportType, $date, $row['acad_year'], $title, $content);
                $insertReport->execute();
            }
        }
    }
}
?>
