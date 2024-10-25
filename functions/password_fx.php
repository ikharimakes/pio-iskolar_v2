<?php
    include_once('../functions/general.php'); 
    global $conn;

    if (isset($_POST['change'])) {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        
        if (!isset($_SESSION['uid'])) {
            echo "missing";
            exit;
        }
        
        $userID = $_SESSION['uid'];
    
        // Verify the current password first
        $sql = "SELECT passhash FROM user WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($storedPassword);
        $stmt->fetch();
    
        // Check if the provided old password matches the stored one
        if ($storedPassword !== $oldPassword) {
            echo "incorrect";
            exit;
        }
    
        // Only check new passwords if old password was correct
        if ($newPassword !== $confirmPassword) {
            echo "mismatch";
            exit;
        }
    
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
    }

if (isset($_POST['check_email'])) {
    $email = $_POST['email'];
    $response = array('success' => false);

    // Check if email exists
    $sql = "SELECT user_id FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Generate one-time code
        $reset_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        $expiry = date('Y-m-d H:i:s', strtotime('+1 day'));
        
        // Update or insert reset code
        $sql = "UPDATE user SET reset_code = ?, reset_expiry = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $reset_code, $expiry, $email);
        
        if ($stmt->execute()) {
            // Send email with reset code
            $emailSubject = "Password Reset Code";
            $emailContent = "Your password reset code is: " . $reset_code . ". This code will expire in 24 hours.";
            sendEmailAsync($email, $emailSubject, $emailContent);
            $response['success'] = true;
        }
    }
    
    echo json_encode($response);
    exit;
}

// Handle password reset
if (isset($_POST['reset_password'])) {
    $response = array('success' => false, 'message' => '');
    $email = $_POST['email'];
    $code = $_POST['reset_code'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($email) || empty($code) || empty($newPassword) || empty($confirmPassword)) {
        $response['message'] = 'empty_fields';
        echo json_encode($response);
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        $response['message'] = 'password_mismatch';
        echo json_encode($response);
        exit;
    }

    // Verify reset code
    $sql = "SELECT user_id FROM user WHERE email = ? AND reset_code = ? AND reset_expiry > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update password and clear reset code
        $sql = "UPDATE user SET passhash = ?, reset_code = NULL, reset_expiry = NULL WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $newPassword, $email);
        
        if ($stmt->execute()) {
            // Send confirmation email
            $emailSubject = "Password Changed Successfully";
            $emailContent = "Your password has been successfully changed. If you did not make this change, please contact pio.iskolar.team@gmail.com immediately.";
            sendEmailAsync($email, $emailSubject, $emailContent);
            
            $response['success'] = true;
            $response['message'] = 'success';
        }
    } else {
        $response['message'] = 'invalid_code';
    }

    echo json_encode($response);
    exit;
}
?>