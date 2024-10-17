<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change'])) {
    $response = array('success' => false, 'message' => '');

    if (isset($_POST['oldPassword'], $_POST['newPassword'], $_POST['confirmPassword'])) {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($newPassword !== $confirmPassword) {
            // $response['message'] = 'New passwords do not match.';
        } else {
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

                // Check if the provided old password matches the stored one (hash comparison recommended)
                if ($storedPassword === $oldPassword) {
                    // Update the password in the database
                    $sql = "UPDATE user SET passhash = ? WHERE user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('si', $newPassword, $userID);

                    if ($stmt->execute()) {
                        $response['success'] = true;
                        // $response['message'] = 'Password updated successfully.';
                    } else {
                        // $response['message'] = 'Failed to update password.';
                    }

                    $stmt->close();
                } else {
                    // $response['message'] = 'Current password is incorrect.';
                }
                $conn->close();
            } else {
                // $response['message'] = 'User not logged in.';
            }
        }
    } else {
        // $response['message'] = 'Please fill all the required fields.';
    }

    echo json_encode($response);
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method or button not clicked.'));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    $response = array('success' => false, 'message' => '');

    if (isset($_POST['newPassword'], $_POST['confirmPassword'])) {
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($newPassword !== $confirmPassword) {
            $response['message'] = 'New passwords do not match.';
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
                    $response['success'] = true;
                    $response['message'] = 'Password updated successfully.';
                } else {
                    $response['message'] = 'Failed to update password.';
                }

                $stmt->close();
                $conn->close();
            } else {
                $response['message'] = 'User not logged in.';
            }
        }
    } else {
        $response['message'] = 'Please fill all the required fields.';
    }

    echo json_encode($response);
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method or button not clicked.'));
}
?>