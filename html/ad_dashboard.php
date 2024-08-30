<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio Iskolar</title>
    <link rel="icon" type="image/x-icon" href="images/pio-logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/ad_dashboard.css">
    <link rel="stylesheet" href="css/confirm.css">
</head>
<body>
    <!-- SIDEBAR - ad_nav.php -->
    <?php include 'ad_navbar.php'; ?>
    

    <!-- TOP BAR -->
    <d class="main1">
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
                <h1>Welcome Back, Coordinator</h1>
                <ion-icon name="school"></ion-icon>
            </div>
        </div>


        <div class="content-grid">
            <div class="cards">
                <div class="card"> 
                    <div class="container">
                        <h5 class="detail"> Total Scholars </h5>
                        <br>
                        <h2 class="num"> 21,350 </h2>
                    </div>
                </div>

                <div class="card"> 
                    <div class="container">
                        <h5 class="detail"> Current Scholars </h5>
                        <br>
                        <h2 class="num"> 2,500 </h2>
                    </div> 
                </div>

                <div class="card"> 
                    <div class="container">
                        <h5 class="detail"> Pending Documents Approval </h5>
                        <br>
                        <h2 class="num"> 100 </h2>
                    </div> 
                </div>
            </div> <br> <br>
                
            <!-- LINE GRAPH -->
            <div class="chart-container">
                <h1> Number of Scholars per Batch </h1>
                <canvas id="canvas" width="950" height="400"></canvas>
            </div>
        </div>

        <div class="right">
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

            <div class="event">
                <h4>Events and Announcements</h4>
                <table id="eventTable">
                    <!-- Dynamic content will be inserted here -->
                </table>
            </div>
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
        
        // LINE GRAPH
        var lineChartData = {
            labels : ["Batch 1","Batch 2","Batch 3","Batch 4","Batch 5","Batch 6","Batch 7","Batch 8","Batch 9","Batch 10"],
            datasets : [
                {
                    fillColor : "#FFEFD8",
                    strokeColor : "#FFE4C7",
                    pointColor : "#CCCCCC",
                    pointStrokeColor : "#FFF",
                    data : [200, 195, 250, 257, 270, 186, 204, 237, 178, 241]
                }
            ]
        }

        var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData);
    </script>
</body>
</html>
