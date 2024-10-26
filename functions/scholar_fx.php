<?php
include_once('../functions/general.php');
global $conn, $batch;

error_reporting(0);

//* INDIVIDUAL CREATION IS HELL *//
if (isset($_POST['individual'])) {
    header('Content-Type: application/json');

    $scholar_id = $_POST['scholar_id'];
    $last_name = strtoupper($_POST['last_name']);
    $first_name = strtoupper($_POST['first_name']);
    $middle_name = strtoupper($_POST['middle_name']);
    $batch_no = substr($scholar_id, 0, 2);
    $school = strtoupper($_POST['school']);
    $course = strtoupper($_POST['course']);
    $address = strtoupper($_POST['address']);
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $username = substr($scholar_id, 0, 2) . '-' . substr($scholar_id, 2, 3);
    $password = $last_name;

    // Step 1: Check if scholar_id or email exists
    $query = "SELECT COUNT(*) as count FROM scholar WHERE scholar_id = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $scholar_id, $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    // If a duplicate scholar_id or email is found, return JSON response and halt the submission
    if ($count > 0) {
        echo json_encode(['exists' => true]);
        exit();
    } else {
        // Step 2: Proceed with the insertion if no duplicate is found
        $insertUser = "INSERT INTO user (user_id, role_id, username, email, passhash) VALUES (NULL, '2', '$username', '$email', '$password')";
        if ($conn->query($insertUser)) {
            $user_id = $conn->insert_id; // Get the last inserted user_id

            $insertScholar = "INSERT INTO scholar (scholar_id, batch_no, user_id, status, last_name, first_name, middle_name, school, course, _address, contact, email, remarks) 
                              VALUES ('$scholar_id', '$batch_no', '$user_id', 'ACTIVE', '$last_name', '$first_name', '$middle_name', '$school', '$course', '$address', '$contact', '$email', NULL)";
            $run = $conn->query($insertScholar);
            $subject = "Your PIO ISKOLAR System Account Credentials";
            $content = "
                <p>Dear Mr./Ms. $last_name,</p>
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
                <p>Pio Iskolar Team</p>";
            // Return success if insertion was successful
            if ($run) {
                // First, send immediate success response for the database operation
                echo json_encode(['success' => true]);
                
                // Ensure the response is sent to the client
                if (function_exists('fastcgi_finish_request')) {
                    fastcgi_finish_request();
                } else {
                    ob_end_flush();
                    flush();
                }
                
                sendEmailAsync($email, $subject, $content);
                
                exit();
            } else {
                echo json_encode(['success' => false]);
                exit();
            }
        } else {
        }
        exit();
    }
}

//* BATCH CREATION *//
if(isset($_FILES['csv'])) {
    if($_FILES['csv']['error'] == 0) {
        $tmpName = $_FILES['csv']['tmp_name'];
        $errorRows = [];
        $batch_id = $_POST['batch_id'];

        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            set_time_limit(0);
            
            // First pass: validate all data
            $skipRows = 2;
            $currentRow = 0;
            
            while(($data = fgetcsv($handle, 501, ',')) !== FALSE) {
                // Skip header rows
                if($currentRow < $skipRows) {
                    $currentRow++;
                    continue;
                }
                
                // Skip empty rows
                $isEmptyRow = true;
                for ($i = 1; $i <= 8; $i++) {
                    if (!empty($data[$i])) {
                        $isEmptyRow = false;
                        break;
                    }
                }
                if ($isEmptyRow) continue;

                $rowNum = $currentRow + 1;
                $rowErrors = [];

                // Required fields check (excluding control number)
                $requiredFields = [
                    1 => "Last Name",
                    2 => "First Name",
                    4 => "School",
                    5 => "Course",
                    6 => "Address",
                    7 => "Contact",
                    8 => "Email"
                ];
                
                foreach ($requiredFields as $field => $fieldName) {
                    if (empty($data[$field])) {
                        $rowErrors[] = "Missing $fieldName";
                    }
                }

                // Email format check
                if (!empty($data[8]) && !filter_var($data[8], FILTER_VALIDATE_EMAIL)) {
                    $rowErrors[] = "Invalid email format";
                }

                // Contact number format check
                if (!empty($data[7])) {
                    // Remove all spaces and non-digit characters
                    $contactNum = preg_replace('/[^0-9]/', '', $data[7]);
                    // Check if exactly 10 digits
                    if (strlen($contactNum) !== 10) {
                        $rowErrors[] = "Contact should be 10 digits";
                    }
                }

                // Check for duplicates
                if (!empty($data[0])) {
                    $scholar_id = $batch_id . sprintf('%03d', $data[0]);
                    $stmt = $conn->prepare("SELECT 1 FROM scholar WHERE scholar_id = ? OR email = ?");
                    $stmt->bind_param("ss", $scholar_id, $data[8]);
                    $stmt->execute();
                    if ($stmt->get_result()->num_rows > 0) {
                        $rowErrors[] = "Scholar ID or email already exists";
                    }
                }

                if (!empty($rowErrors)) {
                    $errorRows[] = "Row $rowNum: " . implode(", ", $rowErrors);
                }
                
                $currentRow++;
            }

            // If there are errors, return them immediately as JSON
            if (!empty($errorRows)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => implode("\n", $errorRows),
                    'title' => 'Validation Errors'
                ]);
                exit();
            }

            // If no errors, proceed with insertion
            rewind($handle);
            $currentRow = 0;
            
            while(($data = fgetcsv($handle, 501, ',')) !== FALSE) {
                if($currentRow < $skipRows) {
                    $currentRow++;
                    continue;
                }
                
                // Skip empty rows
                $isEmptyRow = true;
                for ($i = 1; $i <= 8; $i++) {
                    if (!empty($data[$i])) {
                        $isEmptyRow = false;
                        break;
                    }
                }
                if ($isEmptyRow) continue;

                // Insert user
                $username = $batch_id . '-' . sprintf('%03d', $data[0]);
                $email = $data[8];
                
                $stmt = $conn->prepare("INSERT INTO user (user_id, role_id, username, email, passhash) VALUES (NULL, '2', ?, ?, ?)");
                $stmt->bind_param("sss", $username, $email, $data[1]); // Plain text password
                $stmt->execute();
                
                $uid = $conn->insert_id;
                
                // Insert scholar
                $sid = $batch_id . sprintf('%03d', $data[0]);
                // Clean contact number and add +63
                $contact = '+63' . preg_replace('/[^0-9]/', '', $data[7]);
                
                $stmt = $conn->prepare("INSERT INTO scholar (scholar_id, batch_no, user_id, status, last_name, first_name, middle_name, school, course, _address, contact, email, remarks) VALUES (?, ?, ?, 'ACTIVE', ?, ?, ?, ?, ?, ?, ?, ?, NULL)");
                $stmt->bind_param("sssssssssss", $sid, $batch_id, $uid, $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $contact, $email);
                $stmt->execute();

                // Send welcome email to the scholar
                $subject = "Your PIO ISKOLAR System Account Credentials";
                $content = "
                    <p>Dear Mr./Ms. $data[1],</p>
                    <p>We are pleased to inform you that your account for the PIO ISKOLAR System has been successfully created. This system is designed to help you manage your scholarship documents and stay updated with the latest announcements from the Dr. Pio Valenzuela Scholarship Program.</p>
                    <p>Below are your account credentials, which you will use to access the PIO ISKOLAR website:</p>
                    <p>
                        <strong>Username:</strong> $username<br>
                        <strong>Password:</strong> $data[1]
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
                    <p>Pio Iskolar Team</p>";

                sendEmailAsync($email, $subject, $content);
            }
            
            fclose($handle);
            
            // Return success response
            echo json_encode([
                'status' => 'success',
                'message' => 'CSV data successfully uploaded and welcome emails sent',
                'title' => 'Success'
            ]);
            exit();
        }
    }
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

function exportScholarListToCSV() {
    global $conn, $year, $sem;

    // Get sort parameters from POST or default values
    $sort_column = isset($_POST['sort_column']) ? $_POST['sort_column'] : 'scholar_id';
    $sort_order = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'asc';
    
    $valid_columns = ['scholar_id', 'last_name', 'first_name', 'school', 'status'];
    if (!in_array($sort_column, $valid_columns)) {
        $sort_column = 'scholar_id';
    }

    $sort_order = strtolower($sort_order) === 'desc' ? 'desc' : 'asc';

    // Get search and filter parameters from POST instead of GET
    $search = isset($_POST['search']) ? $conn->real_escape_string($_POST['search']) : '';
    $filter = isset($_POST['filter']) ? $conn->real_escape_string($_POST['filter']) : '';
    $category = isset($_POST['category']) ? $conn->real_escape_string($_POST['category']) : '';
    
    // Rest of your existing export function remains the same
    $conditions = "1=1";

    if ($search !== '') {
        $conditions .= " AND (batch_no LIKE '%$search%' OR scholar_id LIKE '%$search%' OR 
                        last_name LIKE '%$search%' OR first_name LIKE '%$search%' OR 
                        middle_name LIKE '%$search%' OR school LIKE '%$search%')";
    }

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
