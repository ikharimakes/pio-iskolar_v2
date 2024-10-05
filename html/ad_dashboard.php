<?php 
    include_once('../functions/general.php');
    include_once('../functions/dashboard_view.php');
    include_once('../functions/announce_view.php');
    updateStatus();
?>

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
    <div class="main1">
        <div class="topBar">
            <div class="headerName">
                <h1>Dashboard</h1>
            </div>

            <div class="headerRight">
                <a class="user" href="ad_settings.php">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <div class="line"></div>


        <!-- DASHBOARD 
         <div class="info">  
            <div class="welcome-box">
                <h1>Welcome Back, Coordinator</h1>
                <ion-icon name="school"></ion-icon>
            </div>
        </div>-->


        <div class="info">
            <div class="search">
                <form>
                    <label>
                        <input type="text" name="search" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </form>
            </div>

            <div class="actions" style="display: none;">
                <button id="downloadBtn" class="action-btn" onclick="downloadSelected()">
                    <ion-icon name="download-outline"></ion-icon>
                </button>
                <button id="deleteBtn" class="action-btn" onclick="deleteSelected()">
                    <ion-icon name="trash-outline"></ion-icon>
                </button>
            </div>

            <div class="sorts">
                <h4> Filter by:</h4>

                <div class="sort">
                    <select id="acadYearSort">
                        <option value="" disabled selected>Academic Year</option>
                        <option value="all">All</option>
                        <option value="24-25">2024-2025</option>
                        <option value="25-26">2025-2026</option>
                        <option value="26-27">2026-2027</option>
                        <option value="27-28">2027-2028</option>
                    </select>
                </div>

                <div class="sort">
                    <select id="semSort">
                        <option value="" disabled selected>Semester</option>
                        <option value="all">All</option>
                        <option value="1st">1st Semester</option>
                        <option value="2nd">2nd Semester</option>
                        <option value="3rd">3rd Semester</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="box-container">
            <div class="box-row">
                <div class="box box-small">
                    <h5 class='detail'>Academic Scholars</h5>

                    <div class="box-num">
                        <h2 class='num'>17</h2>
                    </div>
                </div>

                <div class="box box-small">
                    <h5 class='detail'>Total Scholars</h5>

                    <div class="box-num">
                        <h2 class='num'>32</h2>
                    </div>
                </div>

                <div class="box box-small">
                    <h5 class='detail'>Leave of Absence</h5>

                    <div class="box-num">
                        <h2 class='num'>2</h2>
                    </div>
                </div>

                <div class="box box-small">
                    <h5 class='detail'>Dropped</h5>

                    <div class="box-num">
                        <h2 class='num'>4</h2>
                    </div>
                </div>
            </div>

            <div class="box-row">
                <div class="box-small-big">
                    <h1>No. of Scholars & Active Scholars per Batch</h1>

                    <div class="box-graph">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="calendar-container">
            <div class="box box-large">
                <h1>Events</h1>

                <div class="event">
                    <ul>
                        <?php activeEvents(); ?>
                    </ul>
                </div>
            </div> <br>

            <div class="box box-large">
                <h1>Recent Submitted Documents</h1>

                <div class="event">
                    <ul>
                        <li><a href="">Adriano, Jessica Raye</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- FOR GRAPH-->
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
        document.addEventListener("DOMContentLoaded", function() {
            const monthYearElement = document.getElementById("monthYear");
            const weekdaysElement = document.getElementById("weekdays");
            const monthDaysElement = document.getElementById("monthDays");
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");

            const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

            let currentDate = new Date();

            function renderWeekdays() {
                weekdaysElement.innerHTML = "";  // Clear previous weekdays

                // Render the days of the week (Mon, Tue, ...)
                daysOfWeek.forEach(day => {
                    const weekdayElement = document.createElement("div");
                    weekdayElement.classList.add("weekday-name");
                    weekdayElement.textContent = day;
                    weekdaysElement.appendChild(weekdayElement);
                });
            }

            function renderMonth(date) {
                monthDaysElement.innerHTML = "";  // Clear previous days

                const firstDayOfMonth = new Date(date.getFullYear(), date.getMonth(), 1);
                const lastDayOfMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0);

                const month = firstDayOfMonth.toLocaleString('default', { month: 'long' });
                const year = firstDayOfMonth.getFullYear();
                monthYearElement.textContent = `${month} ${year}`;

                // Find the day of the week the month starts on
                let startDay = firstDayOfMonth.getDay();

                // Add empty days before the first day of the month to align days
                for (let i = 0; i < startDay; i++) {
                    const emptyDay = document.createElement("div");
                    monthDaysElement.appendChild(emptyDay);
                }

                // Render all days of the month (without the day name)
                for (let day = 1; day <= lastDayOfMonth.getDate(); day++) {
                    const dayElement = document.createElement("div");
                    dayElement.classList.add("day");

                    const dayNumberElement = document.createElement("div");
                    dayNumberElement.classList.add("day-number");
                    dayNumberElement.textContent = day;

                    dayElement.appendChild(dayNumberElement);
                    monthDaysElement.appendChild(dayElement);
                }
            }

            prevBtn.addEventListener("click", function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderMonth(currentDate);
            });

            nextBtn.addEventListener("click", function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderMonth(currentDate);
            });

            renderWeekdays();  // Render the weekday names once
            renderMonth(new Date());  // Render the current month
        });



        //GRAPH
        // const ctx = document.getElementById('myBarChart').getContext('2d');
        // const myBarChart = new Chart(ctx, {
        //     type: 'bar',
        //     data: {
        //         labels: ['Batch 21', 'Batch 22', 'Batch 23', 'Batch 24', '  Batch 25'],
        //         datasets: [
        //             {
        //                 label: '1st Semester',
        //                 data: [65, 59, 80, 81, 56],
        //                 backgroundColor: 'rgb(47, 55, 135)',
        //                 borderWidth: 1
        //             },
        //             {
        //                 label: '2nd Semester',
        //                 data: [28, 48, 40, 19, 86],
        //                 backgroundColor: 'rgb(217, 217, 217)',
        //                 borderWidth: 1
        //             }
        //         ]
        //     },
        //     options: {
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });

        async function fetchChartData() {
            try {
                const response = await fetch('../functions/dashboard_graph.php'); // Fetch data from PHP script
                const data = await response.json(); // Parse JSON response

                // Check if data was fetched successfully
                if (!data || !data.labels || !data.total_scholars || !data.active_scholars) {
                    console.error("Invalid data structure received from the server.");
                    return;
                }

                // Initialize the chart with fetched data
                const ctx = document.getElementById('myBarChart').getContext('2d');
                const myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,  // Use dynamic labels from PHP
                        datasets: [
                            {
                                label: 'Total Scholars',
                                data: data.total_scholars,  // Use dynamic data for total scholars
                                backgroundColor: 'rgb(47, 55, 135)',
                                borderWidth: 1
                            },
                            {
                                label: 'ACTIVE Scholars',
                                data: data.active_scholars,  // Use dynamic data for ACTIVE scholars
                                backgroundColor: 'rgb(217, 217, 217)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } catch (error) {
                console.error("Error fetching chart data:", error);
            }
        }

        // Fetch data and render the chart
        fetchChartData();
    </script>
</body>
</html>
