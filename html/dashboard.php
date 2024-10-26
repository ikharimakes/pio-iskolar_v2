<?php 
    include_once('../functions/general.php'); 
    include('../functions/announce_view.php');
    include('../functions/dashboard_view.php');
    
    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : (isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : null);

    if ($user_role == "2") {
    } elseif ($user_role == "1") {
        header("Location: ad_dashboard.php");
    } elseif ($user_role == "3") {
        header("Location: eval_dashboard.php");
    } else {
        header("Location: index.php");
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
            <?php summaryDocs(); ?>

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
        <div class="overlay-content" style="width:initial !important;">
            <span class="closeOverlay" onclick="closeView()">&times;</span>
            <br>

            <div class="card"> 
                <img id="modalImage" class="pic" src="" alt="Image" />
                <div class="container">
                    <h2 id="modalTitle"></h2>
                    <p id="modalDate" class="date"></p>
                    <center> 
                        <p id="modalContent" class="caption"></p>
                    </center>
                </div> 
            </div>
        </div>
    </div>

    <?php include 'notif.php'; ?>
    <?php include 'toast.php'; ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // VIEW
        function openView(elem) {
            // Display the modal
            document.getElementById("viewOverlay").style.display = "block";

            // Populate modal fields using data attributes
            document.getElementById("modalImage").src = "../assets/" + elem.getAttribute("data-img");
            document.getElementById("modalTitle").innerText = elem.getAttribute("data-title");
            document.getElementById("modalContent").innerText = elem.getAttribute("data-content");
            document.getElementById("modalDate").innerText = elem.getAttribute("data-date");
        }

        function closeView() {
            document.getElementById("viewOverlay").style.display = "none";
        }
    </script>
</body>
</html>