<?php
include_once('../functions/general.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // Prepare the SQL statement
    $log = $conn->prepare("SELECT * FROM user WHERE username = ? AND passhash = ? LIMIT 1");
    $log->bind_param("ss", $user, $pass);
    $log->execute();
    $result = $log->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['uid'] = $row['user_id'];
        $roleId = $row['role_id'];

        if ($roleId == "1") {
            $_SESSION['role'] = "admin";
            echo 'admin';
        } elseif ($roleId == "2") {
            $_SESSION['role'] = "scholar";
            $query = $conn->prepare("SELECT scholar_id, batch_no FROM scholar WHERE user_id = ?");
            $query->bind_param("i", $row['user_id']);
            $query->execute();
            $account = $query->get_result();
            $scholarRow = $account->fetch_assoc();
            $_SESSION['sid'] = $scholarRow['scholar_id'];
            $_SESSION['bid'] = $scholarRow['batch_no'];
            echo 'scholar';
        } elseif ($roleId == "3") {
            $_SESSION['role'] = "evaluator";
            echo 'evaluator';
        } 
    } else {
        sleep(1);
        echo 'Invalid Credentials!';
    }
    exit;
}
?>
