<?php
include_once('../functions/general.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Temporary credentials for verification
    $validUser = 'admin';
    $validPass = 'admin';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $id = $_POST['id'];
    $type = $_POST['type'];
    $name = $_POST['name'];

    if ($username === $validUser && $password === $validPass) {
        // Proceed with deletion
        $typeToColumn = [
            'user' => 'user_id',
            'submission' => 'submit_id',
            'announcements' => 'announce_id',
            'reports' => 'report_id'
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
