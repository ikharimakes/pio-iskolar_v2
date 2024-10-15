<?php 
    include_once('../functions/general.php'); 
    include('../functions/announce_view.php');
    
    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : (isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : null);

    if ($user_role == "2") {
    } elseif ($user_role == "1") {
        header("Location: ad_dashboard.php");
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
                <div class="notifs">
                    <ion-icon name="notifications-outline" onclick="openNotif()"></ion-icon>
                </div>
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


        <!-- CALENDAR -->
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
        </div>
        

        <!-- ANNOUNCEMENT -->
        <div class="announcement">
            <h1>Announcement</h1>
            <?php annDisplay();?>
        </div>
    </div>


    <!-- VIEW MODAL -->
    <div id="viewOverlay" class="overlay">
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
        //CALENDAR
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];

        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();

        function generateCalendar() {
            const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const startingDay = firstDayOfMonth.getDay();

            document.getElementById("month").innerHTML = monthNames[currentMonth] + " " + currentYear;

            let calendarDays = document.getElementById("days");
            calendarDays.innerHTML = "";

            for (let i = 0; i < startingDay; i++) {
                let day = document.createElement("div");
                calendarDays.appendChild(day);
            }

            for (let i = 1; i <= daysInMonth; i++) {
                let day = document.createElement("div");
                day.textContent = i;
                calendarDays.appendChild(day);
            }
        }

        document.querySelector(".prev").addEventListener("click", () => {
            currentMonth -= 1;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear -= 1;
            }
            generateCalendar();
        });

        document.querySelector(".next").addEventListener("click", () => {
            currentMonth += 1;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear += 1;
            }
            generateCalendar();
        });

        generateCalendar();


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