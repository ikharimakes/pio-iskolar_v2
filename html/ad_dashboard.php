<?php 
    include_once('../functions/general.php');
    include_once('../functions/dashboard_view.php');
    include_once('../functions/announce_view.php');
    updateStatus();

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
    <link rel="stylesheet" href="css/ad_dashboard.css">
    <link rel="stylesheet" href="css/confirm.css">
    <script src="https://kit.fontawesome.com/3d9c1c4bc8.js" crossorigin="anonymous"></script>
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-button {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 10px;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            border: 1px solid #ccc;
            z-index: 1;
            padding: 10px;
        }

        .dropdown-content label {
            display: block;
            padding: 5px;
        }

        .dropdown-content label:hover {
            background-color: #f1f1f1;
        }

        .dropdown-content input[type="checkbox"] {
            margin-right: 5px;
        }

        .dropdown.show .dropdown-content {
            display: block;
        }
        .line {
            z-index: 2;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR - ad_nav.php -->
    <?php include 'ad_navbar.php'; ?>
    
    <div class="main1" style="grid-template-rows: 70px 5% 42.5% 42.5%;">
        <div class="topBar">
            <div class="headerName">
                <h1>Dashboard</h1>
            </div>
            <div class="headerRight">
                <a class="user" href="ad_profile.php">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <div class="line" style="z-index:1"></div>

        <div class="box-container">
            <?php summaryScholars(); ?>

            <div class="box-row">
                <div class="box-small-big">
                    <h1>No. of Scholars per Batch</h1>
                    
                    <div class="sorts">
                    <h4> Filter by:</h4>

                    <div class="dropdown">
                        <div class="dropdown-button" onclick="toggleDropdown()">Select Batches</div>
                        <div class="dropdown-content">
                            <label><input type="checkbox" id="all-batches" value="ALL" onclick="selectAllBatches()"> All Batches</label>
                            <?php
                            $query = "SELECT DISTINCT batch_no FROM scholar ORDER BY batch_no DESC";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<label><input type='checkbox' name='batch' value='" . $row['batch_no'] . "' onclick='updateBatchSelection()'> Batch " . $row['batch_no'] . "</label>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
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

    <?php include 'toast.php'; ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- FOR GRAPH-->
    <script>
        function toggleDropdown() {
            document.querySelector(".dropdown").classList.toggle("show");
        }
        
        window.onclick = function(event) {
            const dropdown = document.querySelector(".dropdown");
            if (!dropdown.contains(event.target) && !event.target.matches('.dropdown-button')) {
                dropdown.classList.remove("show");
            }
        }

        function selectAllBatches() {
            const isChecked = document.getElementById("all-batches").checked;
            const batchCheckboxes = document.querySelectorAll("input[name='batch']");

            batchCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });

            fetchChartData();
        }

        function updateBatchSelection() {
            const allBatchesCheckbox = document.getElementById("all-batches");
            const batchCheckboxes = document.querySelectorAll("input[name='batch']");

            // Check if all checkboxes are selected
            const allChecked = Array.from(batchCheckboxes).every(checkbox => checkbox.checked);

            // Update the "All" checkbox state
            allBatchesCheckbox.checked = allChecked;

            fetchChartData();
        }

        //GRAPH
        let myBarChart;  // Declare the chart instance variable outside of the function

        async function fetchChartData() {
            try {
                const selectedBatches = Array.from(document.querySelectorAll("input[name='batch']:checked")).map(checkbox => checkbox.value);

                // If "All" is selected, send all batches, otherwise send selected ones
                const batches = (selectedBatches.includes('ALL') || selectedBatches.length === 0) ? 'ALL' : selectedBatches.join(',');

                const response = await fetch(`../functions/dashboard_graph.php?batches=${batches}`);
                const data = await response.json();

                if (!data || !data.labels) {
                    console.error("Invalid data received.");
                    return;
                }

                const ctx = document.getElementById('myBarChart').getContext('2d');

                // Destroy the previous chart if it exists
                if (myBarChart) {
                    myBarChart.destroy();
                }

                // Create a new chart instance
                myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [
                            { label: 'Total Scholars', data: data.total_scholars, backgroundColor: 'rgb(47, 55, 135)' },
                            { label: 'Active Scholars', data: data.active_scholars, backgroundColor: 'rgb(0, 200, 83)' },
                            { label: 'Probation Scholars', data: data.probation_scholars, backgroundColor: 'rgb(255, 159, 64)' },
                            { label: 'LOA Scholars', data: data.loa_scholars, backgroundColor: 'rgb(255, 205, 86)' },
                            { label: 'Dropped Scholars', data: data.dropped_scholars, backgroundColor: 'rgb(255, 99, 132)' },
                            { label: 'Graduated Scholars', data: data.graduated_scholars, backgroundColor: 'rgb(75, 192, 192)' }
                        ]
                    },
                    options: {
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            } catch (error) {
                console.error("Error fetching chart data:", error);
            }
        }

        fetchChartData();  // Initial call to load the chart

        // Dropdown event listeners
        document.getElementById("all-batches").addEventListener("change", selectAllBatches);
        document.querySelectorAll("input[name='batch']").forEach(checkbox => {
            checkbox.addEventListener("change", updateBatchSelection);
        });
                
        fetchChartData();
        
        function redirectScholar(category = '', filter = '') {
            const form = document.createElement('form');
            form.method = 'GET';  // Keep as GET since we want the parameters in URL
            form.action = 'ad_scholar.php';

            // Always create a 'page' input to reset to page 1
            const pageInput = document.createElement('input');
            pageInput.type = 'hidden';
            pageInput.name = 'page';
            pageInput.value = '1';
            form.appendChild(pageInput);

            // Add category if provided
            if (category) {
                const categoryInput = document.createElement('input');
                categoryInput.type = 'hidden';
                categoryInput.name = 'category';
                categoryInput.value = category;
                form.appendChild(categoryInput);

                // Only add filter if category exists
                if (filter) {
                    const filterInput = document.createElement('input');
                    filterInput.type = 'hidden';
                    filterInput.name = 'filter';
                    filterInput.value = filter;
                    form.appendChild(filterInput);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
