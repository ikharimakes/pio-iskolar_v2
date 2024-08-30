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
    

    <!-- TOP BAR -->
    <div class="main1">
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
                <h1>Welcome Back, Jessica Raye</h1>
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
        
            <div class="title">Application for Batch 23</div>
            <div class="titleDate">August 20, 2024</div>
            <div class="info-box">
                <img src="images/pic1.jpg">
                <p class="message">
                    The City Government of Valenzuela will start accepting applicants for the Dr. Pio Valenzuela Scholarship 
                    Program on December 13, 2023. Here are the qualifications and requirements for the scholarship program. <br> <br>
                    Get the downloadable scholarship application form here: https://www.valenzuela.gov.ph/drpioscholarship <br> <br>
                    For other concerns, you may send an email to drpioscholarshiphelpdesk@gmail.com.
                </p>
            </div> <br> <br>

            <div class="title">Contract Signing</div>
            <div class="titleDate">July 1, 2024</div>
            <div class="info-box">
                <img src="images/pic2.jpg">
                <p class="message">
                    City Mayor REX Gatchalian graces the orientation and contract signing of 212 recipients of the Dr. Pio 
                    Valenzuela Scholarship program at the Pamantasan ng Lungsod ng Valenzuela (#PLV) Qualified Grantees 
                    are required to report at the Scholarship Office at PLV Maysan Campus, 2nd floor on December 10 to 16, 2023 
                    (except Saturday and Sunday) 8:00 AM to 5:00 PM. Look for Ms. Miko Tongco regarding Contract Signing and 
                    Orientation. Thank you!
                </p>
            </div> <br> <br>
                
            <div class="title">Results for Batch 23</div>
            <div class="titleDate">May 22, 2024</div>
            <div class="info-box">
                <img src="images/pic3.jpg">
                <p class="message">
                    The results of the Dr. Pio Valenzuela Scholarship Program will be released on Dr. Pio's 154th Birth 
                    Anniversary on December 11, 2023. <br> <br>
                    deserving of the grant, they are currently getting to know more about their future college journeys 
                    as Dr. Pio Valenzuela scholars. <br> <br>
                    Congratulations and make us proud, dear students!
                </p>
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
    </script>
</body>
</html>