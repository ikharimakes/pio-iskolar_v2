<?php
include_once('../functions/general.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = array('success' => false, 'message' => '');

    if (isset($_POST['oldPassword'], $_POST['newPassword'], $_POST['confirmPassword'])) {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($newPassword !== $confirmPassword) {
            $response['message'] = 'New passwords do not match.';
        } else {
            // Assuming you have user identification logic
            if (isset($_SESSION['uid'])) {
                $userID = $_SESSION['uid'];

                // Verify the current password
                $sql = "SELECT password FROM user WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $userID);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($storedPassword);
                $stmt->fetch();

                if ($storedPassword === $oldPassword) {
                    // Update the password in the database
                    $sql = "UPDATE user SET password = ? WHERE user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('si', $newPassword, $userID);

                    if ($stmt->execute()) {
                        $response['success'] = true;
                        $response['message'] = 'Password reset successfully';
                    } else {
                        $response['message'] = 'Error resetting password';
                    }

                    $stmt->close();
                } else {
                    $response['message'] = 'Current password is incorrect.';
                }
                $conn->close();
            } else {
                $response['message'] = 'User ID not set in session.';
            }
        }
    } else {
        $response['message'] = 'Invalid request';
    }

    echo json_encode($response);
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
}
?>
