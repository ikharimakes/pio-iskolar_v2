<?php
include_once('../functions/general.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    // Format the message
    $formatted_message = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    
    error_log($formatted_message);
    try {
        // Send to team
        $team_subject = "New Inquiry from $name";
        sendEmailAsync('pio.iskolar.team@gmail.com', $team_subject, $formatted_message);
        
        // Send copy to user
        $user_subject = "Copy of your Dr. Pio Valenzuela Scholarship Program Inquiry";
        $user_message = "This is a copy of your inquiry regarding the Dr. Pio Valenzuela Scholarship Program\n\n" . $formatted_message;
        sendEmailAsync($email, $user_subject, $user_message);
        
        echo "success";
    } catch (Exception $e) {
        echo "error";
    }
    exit();
}
?>