<?php
include_once('../functions/general.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $remember = isset($_POST['remember']) ? $_POST['remember'] : false;  // Check if 'remember' is checked

    // Prepare the SQL statement to allow login with either username or email
    $log = $conn->prepare("SELECT * FROM user WHERE (username = ? OR email = ?) AND passhash = ? LIMIT 1");
    $log->bind_param("sss", $user, $user, $pass);
    $log->execute();
    $result = $log->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['uid'] = $row['user_id'];
        $_SESSION['role'] = $row['role_id'];  // Set session role (admin, scholar, evaluator)
        
        // Set cookie only if 'remember' is checked
        if ($remember) {
            setcookie("user_role", $row['role_id'], time() + (86400 * 30), "/");  // 30 days expiration
        }
        
        if ($row['role_id'] == "1") {
            echo 'admin';
        } elseif ($row['role_id'] == "2") {
            $query = $conn->prepare("SELECT scholar_id, batch_no FROM scholar WHERE user_id = ?");
            $query->bind_param("i", $row['user_id']);
            $query->execute();
            $account = $query->get_result();
            $scholarRow = $account->fetch_assoc();
            $_SESSION['sid'] = $scholarRow['scholar_id'];
            $_SESSION['bid'] = $scholarRow['batch_no'];
            echo 'scholar';
        } elseif ($row['role_id'] == "3") {
            echo 'evaluator';
        }
    } else {
        sleep(1);  // Prevent brute-force attacks
        echo 'Invalid Credentials!';
    }
    exit;
}
?>
