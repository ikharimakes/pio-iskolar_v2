<?php
include_once('../functions/general.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // Log the values to ensure they are correct
    error_log("Username: $user");
    error_log("Password: $pass");

    // Prepare the SQL statement
    $log = $conn->prepare("SELECT * FROM user WHERE username = ? AND passhash = ? LIMIT 1");
    $log->bind_param("ss", $user, $pass);
    $log->execute();
    $result = $log->get_result();

    // Log the result count for debugging
    error_log("Result count: " . $result->num_rows);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['uid'] = $row['user_id'];
        $roleId = $row['role_id'];

        if ($roleId == "1") {
            $_SESSION['role'] = "admin";
            echo 'admin';
        } elseif ($roleId == "2") {
            $_SESSION['role'] = "scholar";
            $grab = $conn->prepare("SELECT scholar_id FROM scholar WHERE user_id = ?");
            $grab->bind_param("i", $row['user_id']);
            $grab->execute();
            $account = $grab->get_result();
            $scholarRow = $account->fetch_assoc();
            $_SESSION['sid'] = $scholarRow['scholar_id'];
            echo 'scholar';
        }
    } else {
        sleep(1);
        echo 'Invalid Credentials!';
    }
    exit;
}
?>
