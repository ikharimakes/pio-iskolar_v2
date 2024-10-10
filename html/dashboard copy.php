<?php 
    include_once('../functions/general.php'); 
    include('../functions/announce_view.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio Iskolar</title>
    <link rel="icon" type="image/x-icon" href="images/pio-logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/confirm.css">
</head>

<body>
    <!-- SIDEBAR - ad_nav.php -->
    <?php include 'navbar.php'; ?>
    
    <div class="main5">
        <!-- TOP BAR -->
        <div class="topBar">
            <div class="headerName">
                <h1>Dashboard</h1>
            </div>

            <div class="headerRight">
                <div class="notif">
                    <ion-icon name="notifications-outline" onclick="openOverlay()"></ion-icon>
                </div>

                <a class="user" href="profile.php">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <div class="line"></div>

        <!-- DASHBOARD -->
        <div class="info">  
            <div class="welcome-box">
                <h1><?php scholarName(); ?></h1> <!-- modify to pull name from db -->
                <ion-icon name="school"></ion-icon> 
            </div>
        </div>


        <div class="box-container">
            <div class="box-row">
                <div class="box box-small">
                    <h5 class='detail'>Total Submitted Documents</h5>

                    <div class="box-num">
                        <h2 class='num'>8</h2>
                    </div>
                </div>

                <div class="box box-small">
                    <h5 class='detail'>Approved Documents</h5>

                    <div class="box-num">
                        <h2 class='num'>8</h2>
                    </div>
                </div>

                <div class="box box-small">
                    <h5 class='detail'>Declined Documents</h5>

                    <div class="box-num">
                        <h2 class='num'>0</h2>
                    </div>
                </div>
            </div>

            <div class="box-row">
                <div class="box-small-big">
                    <h1>Requirements</h1>
                    <h5> <?php echo 'A.Y. '.$year.', Semester '.$sem?> </h5>

                    <div class="event">
                        <ul>
                            <li>Photocopy of Certificate of Registration</li> <hr>
                            <li>Photocopy of Grades/Transcript of Records</li> <hr>
                            <li>Social Service Monitoring Record with complete 40 hours</li> <hr>
                            <li>Diploma</li> <hr>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <!-- CALENDAR 
        <div class="calendar">
            <div class="month">
                <div class="prev">&#10094;</div>

                <div class="date">
                    <h1 id="month"></h1>
                </div>

                <div class="next">&#10095;</div>
            </div> <br>

            <div class="weekdays">
                <div>Sunday</div>
                <div>Monday</div>
                <div>Tuesday</div>
                <div>Wednesday</div>
                <div>Thursday</div>
                <div>Friday</div>
                <div>Saturday</div>
            </div> <br>

            <div class="days" id="days"></div>
        </div>-->
        

        <!-- ANNOUNCEMENT -->
        <div class="announcement">
            <h1>Announcement</h1>
            <?php annDisplay();?>
        </div>
    </div>


    <!-- VIEW MODAL -->
    <div id="viewOverlay" class="viewOverlay">
        <div class="overlay-content">
            <span class="closeOverlay" onclick="closeView()">&times;</span>
            <br>

            <div class="card"> 
                <img id="modalImage" class="pic" src="" alt="Image" /> <!-- Updated src -->
                <div class="container">
                    <h2 id="modalTitle"> <!-- Updated title --> </h2>
                    <p id="modalDate" class="date"> <!-- Updated date --> </p>
                    <center> 
                        <p id="modalContent" class="caption"> <!-- Updated content --> </p>
                    </center>
                </div> 
            </div>
        </div>
    </div>

    
    <!-- NOTIFICATION - notif.php -->
    <?php include 'notif.php'; ?>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // VIEW
        function openView(img, title, content, date) {
            // Display the modal
            document.getElementById("viewOverlay").style.display = "block";

            // Populate modal fields
            document.getElementById("modalImage").src = "../assets/" + img;
            document.getElementById("modalTitle").innerText = title;
            document.getElementById("modalContent").innerText = content;
            document.getElementById("modalDate").innerText = date;
        }

        function closeView() {
            document.getElementById("viewOverlay").style.display = "none";
        }
    </script>
</body>
</html>