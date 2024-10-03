<?php 
    include_once('../functions/general.php'); 
    include('../functions/scholar_view.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio Iskolar</title>
    <link rel="icon" type="image/x-icon" href="images/pio-logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/ad_skoDetail.css">
    <!-- <link rel="stylesheet" href="css/profile.css"> -->
    <link rel="stylesheet" href="css/confirm.css">
</head>
<body>
    <!-- SIDEBAR - navbar.php -->
    <?php include 'navbar.php';?>
    

    <!-- TOP BAR -->
    <div class="main1">
        <div class="topBar">
            <div class="headerName">
                <h1>My Profile</h1>
            </div>

            <div class="headerRight">
                <div class="notifs">
                    <ion-icon name="notifications-outline" onclick="openNotif()"></ion-icon>
                </div>
            </div>
        </div>

        <div class="line"></div>


        <!-- MY PROFILE-->
        <div class="details"><center> 
            <?php scholarFull(); ?>
        </center></div>

        <?php scholarDetail();?>
    </div>


    <!-- CHANGE PASS -->
    <div id="passOverlay" class="passOverlay">
        <div class="pass-content">
            <div class="infos">
                <h2>Change Password</h2>
                <span class="closePass" onclick="closePass()">&times;</span>
            </div>
            <br><br>
            
            <form action="" method="POST">
                <div class="inner-content">
                    <label class="passText" for="oldPassword">Enter Current Password:</label> <br>
                    <input class="input" type="password" id="oldPassword" name="oldPassword" placeholder="Current Password" required>
                </div>

                <div class="inner-content">
                    <label class="passText" for="newPassword">Enter New Password:</label> <br>
                    <input class="input" type="password" id="newPassword" name="newPassword" placeholder="New Password" required>
                </div>

                <div class="inner-content">
                    <label class="passText" for="confirmPassword">Confirm Password:</label> <br>
                    <input class="input" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                </div> <br>

                <div class="enter-button-container">
                    <button class="enter-button" type="submit"> Enter </button>
                </div>
            </form> <br>
        </div> 
    </div>


    <!-- NOTIFICATION - notif.php -->
    <?php include 'notif.php'; ?>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        //CHANGE PASS
        function openPass() {
            document.getElementById("passOverlay").style.display = "block";
        }
        function closePass() {
            document.getElementById("passOverlay").style.display = "none";
        }
        function submitForm() {
            closePass();
        }
    </script>
</body>
</html>