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
    
    <div class="main1">
        <!-- TOP BAR -->
        <div class="topBar">
            <div class="headerName">
                <h1>Dashboard</h1>
            </div>

            <div class="headerRight">
                <div class="notifs">
                    <ion-icon name="notifications-outline" onclick="openOverlay()"></ion-icon>
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

            <!-- CALENDAR -->
            <div class="calendar">
                <div class="month">
                    <div class="prev">&#10094;</div>

                    <div class="date">
                        <h1 id="month"></h1>
                    </div>

                    <div class="next">&#10095;</div>
                </div>

                <div class="weekdays">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>

                <div class="days" id="days"></div>
            </div>
        </div>


        <!-- ANNOUNCEMENT -->
        <div class="announcement">
            <h1>Announcement</h1>
            <?php annDisplay();?>
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
    </script>
</body>
</html>