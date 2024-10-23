<?php
include_once('../functions/general.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    global $conn; // Use the global connection variable

    $username = $_POST['username'];
    $password = $_POST['password'];
    $id = $_POST['id'];
    $type = $_POST['type'];
    $name = $_POST['name'];
    
    // Get the current session user ID
    $session_user_id = $_SESSION['uid'];

    // Prepare SQL query to fetch valid user and passhash for the logged-in user
    $query = "SELECT user_id, username, passhash FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $session_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $validCredentials = false;

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['username'] === $username && $row['passhash'] === $password) {
            $validCredentials = true;
        }
    }

    $stmt->close();

    if ($validCredentials) {
        // Proceed with deletion
        $typeToColumn = [
            'user' => 'user_id',
            'submission' => 'submit_id',
            'announcements' => 'announce_id',
            'reports' => 'report_id',
            'university' => 'school_id'
        ];

        if (isset($typeToColumn[$type])) {
            $column = $typeToColumn[$type];

            // Handle file deletion if name is provided
            if (!empty($name)) {
                $path = "../assets/" . $name;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            // Prepare the delete query
            $delete = "DELETE FROM {$type} WHERE {$column} = '$id'";
            if ($conn->query($delete)) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'invalid';
        }
    } else {
        sleep(1);  // Prevent brute-force attacks
        echo 'invalid';
    }
}
?>
