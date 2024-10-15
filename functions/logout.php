<?php
    session_start(); 

    // Clear all session variables
    $_SESSION = array();

    // Destroy the session
    session_unset(); 
    session_destroy(); 

    // Check if the user_role cookie exists and clear it
    if (isset($_COOKIE['user_role'])) {
        setcookie("user_role", "", time() - 3600, "/");  // Set the cookie expiration time to the past to delete it
    }

    // Redirect to the front page or login page after logout
    header("Location: ../html/front_page.php");
    exit();
?>