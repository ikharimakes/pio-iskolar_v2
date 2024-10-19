<?php
include_once('../functions/general.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    global $conn; // Use the global connection variable

    $username = $_POST['username'];
    $password = $_POST['password'];
    $id = $_POST['id'];
    $type = $_POST['type'];
    $name = $_POST['name'];

    // Prepare SQL query to fetch valid user and passhash for user_id 1 or 3
    $query = "SELECT user_id, username, passhash FROM user WHERE user_id IN (1, 3)";
    $result = $conn->query($query);

    $validCredentials = false;

    if ($result && $result->num_rows > 0) {
        // Loop through the result to check for valid credentials
        while ($row = $result->fetch_assoc()) {
            if ($row['username'] === $username && $row['passhash'] === $password) {
                $validCredentials = true;
                break; // Stop checking once valid credentials are found
            }
        }
    }

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
        // Invalid credentials
        echo 'invalid';
    }
}

