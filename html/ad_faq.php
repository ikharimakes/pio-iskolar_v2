<?php 
include_once('../functions/general.php'); 

$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : (isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : null);

if ($user_role == "1") {
} elseif ($user_role == "2") {
    header("Location: dashboard.php");
} elseif ($user_role == "3") {
    header("Location: eval_dashboard.php");
} else {
    header("Location: front_page.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio Iskolar</title>
    <link rel="icon" type="image/x-icon" href="images/pio-logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/ad_faq.css">
    <link rel="stylesheet" href="css/confirm.css">
</head>
<body>
    <!-- SIDEBAR - ad_navbar.php -->
    <?php include 'ad_navbar.php';?>
    

    <!-- TOP BAR -->
    <div class="main1">
        <div class="topBar">
            <div class="headerName">
                <h1>FAQ</h1>
            </div>

            <div class="headerRight">
                <a class="user" href="ad_profile.php">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <div class="line"></div>


        <!-- FAQ-->
        <div class="info"></div>
        
    </div>


    <!-- NOTIFICATION - notif.php -->
    <?php include 'notif.php'; ?>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>