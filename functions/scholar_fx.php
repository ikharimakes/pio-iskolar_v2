<?php
include_once('../functions/general.php');
global $conn, $batch;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmailNotification($email, $username, $password, $name,) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'raisseille@gmail.com';   //pio.iskolar@gmail.com
        $mail->Password = 'odaq gskz keoh vnwu';    //hadj fkxn jxjj kmdr
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('pio.iskolar@gmail.com', 'Pio Iskolar Team');
        $mail->addAddress($email); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Your PIO ISKOLAR System Account Credentials';
        $mail->Body    = "
        <p>Dear Mr./Ms. $name,</p>
        <p>We are pleased to inform you that your account for the PIO ISKOLAR System has been successfully created. This system is designed to help you manage your scholarship documents and stay updated with the latest announcements from the Dr. Pio Valenzuela Scholarship Program.</p>
        <p>Below are your account credentials, which you will use to access the PIO ISKOLAR website:</p>
        <p>
            <strong>Username:</strong> $username<br>
            <strong>Password:</strong> $password
        </p>
        <p>To ensure the security of your account, please log in using the above credentials and change your password immediately upon your first login.</p>
        <p><strong>Steps to Change Your Password:</strong></p>
        <ol>
            <li>Log in to the PIO ISKOLAR System using the credentials provided above.</li>
            <li>Navigate to your account settings.</li>
            <li>Select \"Change Password.\"</li>
            <li>Enter your temporary password, followed by your new password.</li>
            <li>Confirm your new password and save the changes.</li>
        </ol>
        <p>If you encounter any issues or have any questions, please do not hesitate to contact our support team at <a href=\"mailto:https://valenzuela.gov.ph/drpioscholarship\">https://valenzuela.gov.ph/drpioscholarship</a>
        <p>Thank you for being a part of the Dr. Pio Valenzuela Scholarship Program. We look forward to supporting your academic journey through this new system.</p>
        <br>
        <p>Best regards,</p>
        <p>Pio Iskolar Team</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

//* INDIVIDUAL CREATION IS HELL *//
if(isset($_POST['individual'])){
    $last_name = strtoupper($_POST['last_name']);
    $first_name = strtoupper($_POST['first_name']);
    $middle_name = strtoupper($_POST['middle_name']);
    $scholar_id = $_POST['scholar_id'];
    $batch_no = substr($scholar_id, 0, 2);
    $school = strtoupper($_POST['school']);
    $course = strtoupper($_POST['course']);
    $address = strtoupper($_POST['address']);
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $username = substr($scholar_id, 0, 2) . '-' . substr($scholar_id, 2, 3);
    $password = $last_name;

    $insert = "INSERT INTO user (user_id, role_id, username, passhash) VALUES (NULL, '2', '$username', '$password')";
    $run = $conn->query($insert);

    // inserts into user
    $idquery = "SELECT user_id from user where username = '$username'";
    $result = $conn->query($idquery);
    while ($row = $result->fetch_assoc()){
        $uid = $row['user_id'];
    }

    // inserts into scholar
    //! CHANGE BATCH NUMBER
    $insert = "INSERT INTO scholar (scholar_id, batch_no, user_id, status, last_name, first_name, middle_name, school, course, _address, contact, email, remarks) VALUES ('$scholar_id', '$batch_no', '$uid', 'ACTIVE', '$last_name', '$first_name', '$middle_name', '$school', '$course', '$address', '$contact', '$email', NULL)";
    $run = $conn->query($insert);

    //! Send email notification - DISABLED
    // sendEmailNotification($email, $username, $password, $last_name);
    sendEmailsAsync(["sail.havenfield@gmail.com"], "test", "testing", "pio.iskolar@gmail.com");
    
    header('Location: '.$_SERVER['PHP_SELF']);
}

//* BATCH CREATION *//
if(isset($_FILES['csv'])){
    if($_FILES['csv']['error'] == 0){
        $tmpName = $_FILES['csv']['tmp_name'];
        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);
            $error = array();
            while(($data = fgetcsv($handle, 501, ',')) !== FALSE) {
                // checks if row is "empty"
                $isEmptyRow = true;
                for ($i = 1; $i <= 8; $i++) {
                    if (!empty($data[$i])) {
                        $isEmptyRow = false;
                        break;
                    }
                }
                if ($isEmptyRow) {continue;}

                // checks for individual empty fields
                $requiredFields = [1, 2, 4, 5, 6, 7, 8];
                foreach ($requiredFields as $field) {
                    if (empty($data[$field])) {
                        array_push($error, $data[0]);
                        continue 2;
                    }
                }
            }
            if(!empty($error)) {
                // loads error modal
                $_SESSION['error_array'] = $error;
            }

            // rewinds pointer
            rewind($handle);

            // starts csv upload
            $skipRows = 2; // Number of rows to skip
            $currentRow = 0;
            while((($data = fgetcsv($handle, 501, ',')) !== FALSE) && (!isset($_SESSION['error_array']))) {
                // skips the first $skipRows lines (assuming headers and formats)
                if($currentRow < $skipRows) { 
                    $currentRow++;
                    continue; 
                }

                // checks if row is "empty"
                $isEmptyRow = true;
                for ($i = 1; $i <= 8; $i++) {
                    if (!empty($data[$i])) {
                        $isEmptyRow = false;
                        break;
                    }
                }
                if ($isEmptyRow) {continue;}

                // get the values from the csv
                $username = $_POST['batch_id'] . '-' . sprintf('%03d', $data[0]);
                $password = $data[1];
                $email = $data[8];
                $insert = "INSERT INTO user (user_id, role_id, username, passhash) VALUES (NULL, '2', '$username', '$password')";
                $run = $conn->query($insert);

                // inserts into user
                $idquery = "SELECT user_id from user where username = '$username'";
                $result = $conn->query($idquery);
                while ($row = $result->fetch_assoc()){
                    $uid = $row['user_id'];
                }
                // inserts into scholar
                //! CHANGE BATCH NUMBER
                $sid = $_POST['batch_id'] . sprintf('%03d', $data[0]);
                $string = str_replace(' ', '', $data['7']);
                $number = '+63' . $string;
                $batch_no = $_POST['batch_id'];

                $insert = "INSERT INTO scholar (scholar_id, batch_no, user_id, status, last_name, first_name, middle_name, school, course, _address, contact, email, remarks) VALUES ('$sid', '$batch_no', '$uid', 'ACTIVE', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$number', '$data[8]', NULL)";
                $run = $conn->query($insert);

                //! Send email notification - DISABLED
                //sendEmailNotification($data[8], $data[1], $password, $data[1]);
            }
            // closes pointer, deletes csv file
            fclose($handle);
            unset($_FILES['csv']);
        }
    }
    header('Location: '.$_SERVER['PHP_SELF']);
    die;
}

//* BATCH CREATION ERROR *//
if(isset($_SESSION['error_array'])) {
    print '
        <div id="errorOverlay" class="errorOverlay">
            <div class="error-content">
                <div class="infos">
                    <h2>Upload Failed</h2>
                        <span class="closeError" onclick="closeError()">&times;</span>
                </div>
                <div class="message"><h4>
    ';
        foreach ((array) $_SESSION['error_array'] as $line) {
        print '   
                Error in row '. $line .'.<br>
        ';
        }
    print '
                </div>
                <div class="ok-button-container">
                    <button class="ok-button" onclick="closeError()"> OK </button>
                </div>
            </div>
        </div>
    ';
    unset($_SESSION['error_array']);
    header('Location: '.$_SERVER['PHP_SELF']);
}

//* UPDATE SCHOLAR DETAILS *//
if (isset($_POST['save'])) {
    // Sanitize and validate input
    $school = strtoupper($conn->real_escape_string($_POST['school']));
    $course = strtoupper($conn->real_escape_string($_POST['course']));
    $scholar_status = strtoupper($conn->real_escape_string($_POST['scholar_status']));
    $address = strtoupper($conn->real_escape_string($_POST['address']));
    $contact = strtoupper($conn->real_escape_string($_POST['contact_number']));
    $email = $conn->real_escape_string($_POST['email']);

    $id = $_SESSION['sid'];

    // Update the database
    $updateQuery = "
        UPDATE scholar
        SET school = '$school',
            course = '$course',
            status = '$scholar_status',
            _address = '$address',
            contact = '$contact',
            email = '$email'
        WHERE scholar_id = '$id'
    ";

    if ($conn->query($updateQuery) === TRUE) {
    } else {
    }
}

function exportScholarListToCSV($sort_column = 'scholar_id', $sort_order = 'asc') {
    global $conn, $year, $sem;

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
        $valid_filter_columns = ['batch_no', 'status', 'school'];
        if (in_array($category, $valid_filter_columns)) {
            $conditions .= " AND $category = '" . $conn->real_escape_string($filter) . "'";
        }
    }

    // Query without the offset to fetch all records
    $query = "SELECT scholar_id, last_name, first_name, school, status FROM scholar WHERE $conditions ORDER BY $sort_column $sort_order";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="scholar_list.csv"');

        // Open file stream
        $output = fopen('php://output', 'w');
        
        // Output column headers
        fputcsv($output, ['Scholar ID', 'Last Name', 'First Name', 'School', 'Document Status', 'Status']);

        while ($row = $result->fetch_assoc()) {
            $scholar_id = $row['scholar_id'];

            // Check document submission status for COR, GRADES, SOCIAL
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
                    $doc_status = $doc_row['doc_status'];

                    // If any required document is pending, declined, or missing, mark as incomplete
                    if (in_array($doc_status, ['PENDING', 'DECLINED'])) {
                        $overall_status = 'INCOMPLETE';
                    }
                    $required_docs[$doc_row['doc_type']] = true; // Mark document as submitted
                }
            }

            // If any required document is missing, set status as INCOMPLETE
            if (in_array(false, $required_docs)) {
                $overall_status = 'INCOMPLETE';
            }

            // Output each row to CSV
            fputcsv($output, [
                $row['scholar_id'], 
                $row['last_name'], 
                $row['first_name'], 
                $row['school'], 
                $overall_status, 
                $row['status']
            ]);
        }

        fclose($output);
        exit();
    } else {
        echo "No records found.";
    }
}

if (isset($_POST['export_csv'])) {
    exportScholarListToCSV();
    exit; // Make sure no further output is generated after CSV export
}

?>
