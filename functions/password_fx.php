<?php
    include_once('../functions/general.php'); 
    global $conn;

if (isset($_POST['change'])) {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    error_log($_SESSION['uid']);
    ob_start();
    var_dump( $_POST );
    $output = ob_get_clean();
    error_log( $output );
    if ($newPassword === $confirmPassword) {
        if (isset($_SESSION['uid'])) {
            $userID = $_SESSION['uid'];

            // Verify the current password
            $sql = "SELECT passhash FROM user WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $userID);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($storedPassword);
            $stmt->fetch();

            // Check if the provided old password matches the stored one
            if ($storedPassword === $oldPassword) {
                // Update the password in the database
                $sql = "UPDATE user SET passhash = ? WHERE user_id = ?";
                error_log($sql);
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $newPassword, $userID);

                if ($stmt->execute()) {
                    echo "success";
                } else {
                    echo "error";
                }
            } else {
                echo "incorrect";
            }
        } else {
            echo "missing";
        }
    } else {
        echo "mismatch";
    }
}

if (isset($_POST['reset'])) {
    $response = array('success' => false, 'message' => '');

    if (isset($_POST['newPassword'], $_POST['confirmPassword'])) {
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($newPassword !== $confirmPassword) {
        } else {
            // Assuming the user is identified via session or a token from a password reset link
            session_start();
            if (isset($_SESSION['uid'])) {
                $userID = $_SESSION['uid'];

                // Update the password in the database
                $sql = "UPDATE user SET passhash = ? WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $newPassword, $userID);

                if ($stmt->execute()) {
                    echo 'success';
                } else {
                }
                $stmt->close();
            } else {
            }
        }
    } else {
    }
}
?>