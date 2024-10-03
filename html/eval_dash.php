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
    <!-- SIDEBAR - eval_nav.php -->
    <?php include 'eval_navbar.php'; ?>
    

    <!-- TOP BAR -->
    <d class="main1">
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


        <!-- DASHBOARD 
         <div class="info">  
            <div class="welcome-box">
                <h1>Welcome Back, Coordinator</h1>
                <ion-icon name="school"></ion-icon>
            </div>
        </div>-->


        <div class="box-container">
            <div class="box-row">
                <div class="box box-large">
                    <h1>Pending (# of pending)</h1>

                    <div class="box-pending">
                        <table>
                            <?php pendingFiles();?>
                        </table>
                    </div>
                </div>

                <div class="box box-large">
                    <h1>Files (per batch)</h1>

                    <div class="box-batch">
                        <ul>
                            <?php existingFiles();?>
                        </ul>
                    </div>
                </div>

                <div class="box box-large">
                    <h1>Calendar</h1>

                    <div class="box-calendar">
                        <div class="nav-btn">
                            <button id="prevBtn"><ion-icon name="chevron-back-outline"></ion-icon></button>
                            <div class="month-year" id="monthYear"></div>
                            <button id="nextBtn"><ion-icon name="chevron-forward-outline"></ion-icon></button>
                        </div>

                        <div class="weekdays" id="weekdays"></div>
                    </div>

                    <div class="event">
                        <h3>Events</h3>
                        <ul>
                            <!-- <li> <a href="">Application for Batch 23</a> </li> -->
                            <?php activeEvents(); ?>
                        </ul>
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
                
                <div class="box-small">
                    <h1>Summary</h1>

                    <div class="box-summary">
                        <?php summaryScholars(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- NOTIFICATION - notif.php -->
    <?php include 'notif.php'; ?>

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
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");

            const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

            let currentDate = new Date();

            function renderWeek(date) {
                weekdaysElement.innerHTML = "";

                const firstDayOfWeek = new Date(date.setDate(date.getDate() - date.getDay()));
                const month = firstDayOfWeek.toLocaleString('default', { month: 'long' });
                const year = firstDayOfWeek.getFullYear();

                monthYearElement.textContent = `${month} ${year}`;

                for (let i = 0; i < 7; i++) {
                    const dayDate = new Date(firstDayOfWeek);
                    dayDate.setDate(firstDayOfWeek.getDate() + i);
                    const dayName = daysOfWeek[dayDate.getDay()];
                    const dayNumber = dayDate.getDate();

                    const dayElement = document.createElement("div");
                    dayElement.classList.add("weekday");

                    const dayNameElement = document.createElement("div");
                    dayNameElement.classList.add("day-name");
                    dayNameElement.textContent = dayName;

                    const dayNumberElement = document.createElement("div");
                    dayNumberElement.classList.add("day-number");
                    dayNumberElement.textContent = dayNumber;

                    dayElement.appendChild(dayNameElement);
                    dayElement.appendChild(dayNumberElement);
                    weekdaysElement.appendChild(dayElement);
                }
            }

            prevBtn.addEventListener("click", function() {
                currentDate.setDate(currentDate.getDate() - 7);
                renderWeek(currentDate);
            });

            nextBtn.addEventListener("click", function() {
                currentDate.setDate(currentDate.getDate() + 7);
                renderWeek(currentDate);
            });

            renderWeek(new Date());
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
