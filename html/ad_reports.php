<?php
    include_once('../functions/general.php');
    include('../functions/reports_view.php');
    include('../functions/reports_fx.php');
    include('../functions/page.php');
    $sourceFile = 'ad_reports.php';

    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : (isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : null);

    if ($user_role == "1") {
    } elseif ($user_role == "2") {
        header("Location: dashboard.php");
    } elseif ($user_role == "3") {
        header("Location: eval_dashboard.php");
    } else {
        header("Location: front_page.php");
    }

    $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'title';
    $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'asc';
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $total_records = getTotalRecords();

    $records_per_page = 15;
    $total_page = ceil($total_records / $records_per_page);

    if (isset($_GET['ajax'])) {
        if ($_GET['ajax'] === 'table') {
            reportDisplay($current_page, $sort_column, $sort_order);
        } elseif ($_GET['ajax'] === 'pagination') {
            renderPagination($current_page, $records_per_page, $total_records, $total_page, $sourceFile);
        }
        exit;
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
    <link rel="stylesheet" href="css/ad_reports.css">
    <link rel="stylesheet" href="css/confirm.css">
    <link rel="stylesheet" href="css/page.css">
    <script src="https://kit.fontawesome.com/3d9c1c4bc8.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- SIDEBAR - ad_navbar.php -->
    <?php include 'ad_navbar.php'; ?>
    

    <!-- TOP BAR -->
    <div class="main">
        <div class="topBar">
            <div class="headerName">
                <h1>Reports</h1>
            </div>

            <div class="headerRight">
                <a class="user">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <div class="line"></div>


        <!-- REPORTS -->
        <div class="info">
            <div class="search">
                <form>
                    <label>
                        <input type="text" name="search" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </form>
            </div>

            <div class="sorts">
                <h4> Filter by:</h4>

                <select id="filter">
                    <option value="" disabled selected>Status</option>
                    <option value="all">All</option>
                    <option value="Completed">Completed</option>
                    <option value="Reviewed">Reviewed</option>
                    <option value="Pending">Closed</option>
                </select>
            </div>

            <form>
                <button type="button" class="btnAdd" onclick="openCreate()"> Generate Reports </button>
            </form>
        </div>


        <!-- TABLE -->
        <div class="tables">
            <table>
                <tr style="font-weight: bold;">
                    <th style="width:10%"> 
                        <div class="batch-header" id="sortBatch" style="justify-content: center; cursor: pointer;">
                            Batch No.
                            <i id="batchSortIcon" class="fa fa-sort"></i>
                        </div> 
                    </th>
                    <th style="width:70%"> 
                        <div class="name-header" id="sortReport" style="cursor: pointer;">
                            Report Name
                            <i id="reportSortIcon" class="fa fa-sort"></i>
                        </div> 
                    </th>
                    <th style="width:15%">
                        <div class="date-header" id="sortDate" style="justify-content: center; cursor: pointer;">
                            Date
                            <i id="dateSortIcon" class="fa fa-sort"></i>
                        </div> 
                    </th>
                    <!-- <th style="width:10%"> Status </th> -->
                    <th style="width:5%"> Actions </th>
                </tr>
                <tbody id="reportTableBody">
                </tbody>
            </table>
        </div>

        <?php renderPagination($current_page, $records_per_page, $total_records, $total_page, $sourceFile); ?>

    </div>


    <!-- GENERATE MODAL -->
    <div id="createModal" class="report">
        <div class="report-content">
            <div class="infos">
                <h1>Generate Reports</h1>
                <span class="closeEdit" onclick="closeCreate()">&times;</span>
            </div>
            <form id="createReport" action="" method="post">
                <div class="scholar">
                    <label for="report">Choose Report Type:</label> <br>
                    <select id="reportScholar" name="report">
                        <option value="status">Scholar Status Report</option>
                        <option value="requirement">Scholar Profile and Requirement Report</option>
                    </select>
                </div> <br>
                <div class="batch"> 
                    <h3>Batch Number</h3>
                        <div id="inputField" class="hideText" style="display: block;">
                            <label for="textInput" style="font-weight: bold;">Enter Batch Number:</label>
                            <input type="number" name="batch_id" required>
                        </div>
                </div>
                <div class="btn">
                    <button class="discard" onclick="closeCreate()">Discard</button>
                    <button id="submitBtn" type="submit" name="generate" class="generate-button"> Generate </button>
                </div> 
            </form> <br>
        </div> 
    </div>

    <div id="viewModal" class="profileReport">
        <div class="profileReport-content">
            <span class="closeEdit" onclick="closeView()">&times;</span>
            <div id="reportContent">content</div>
        </div>
    </div>

    <!-- STATISTIC MODAL -->
    <div id="statsModal" class="modal">
        <!-- Modal content for option 3 -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>This is the modal content for option 3.</p>
        </div>
    </div>

    <!-- DELETE MODAL - confirm.php -->
    <?php include 'confirm.php'; ?>

    <!-- NOTIFICATION - notif.php -->
    <?php include 'notif.php'; ?>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // FETCH API SEARCH/SORT/FILTER AND PAGINATION
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.querySelector('input[name="search"]');
            const filter = document.getElementById('filter');
            const actionButtons = document.querySelector('.actions');
            const tableBody = document.getElementById('reportTableBody');
            const pagination = document.getElementById('pagination');

            let sortStates = {
                'batch_no': 'neutral',
                'title': 'neutral',
                'creation_date': 'neutral'
            };

            const updateSortIcons = () => {
                const icons = {
                    'batch_no': document.getElementById('batchSortIcon'),
                    'title': document.getElementById('reportSortIcon'),
                    'creation_date': document.getElementById('dateSortIcon')
                };

                for (const [column, icon] of Object.entries(icons)) {
                    const state = sortStates[column];
                    if (state === 'neutral') {
                        icon.className = 'fa fa-sort';
                    } else if (state === 'asc') {
                        icon.className = 'fa fa-sort-up';
                    } else if (state === 'desc') {
                        icon.className = 'fa fa-sort-down';
                    }
                }
            };

            const handleSort = (headerId, sortKey) => {
                const header = document.getElementById(headerId);
                header.addEventListener('click', () => {
                    const currentState = sortStates[sortKey];
                    let nextState;
                    if (currentState === 'neutral') {
                        nextState = 'asc';
                    } else if (currentState === 'asc') {
                        nextState = 'desc';
                    } else {
                        nextState = 'neutral';
                    }
                    sortStates[sortKey] = nextState;

                    for (const key in sortStates) {
                        if (key !== sortKey) {
                            sortStates[key] = 'neutral';
                        }
                    }

                    updateSortIcons();
                    fetchData();
                });
            };

            handleSort('sortBatch', 'batch_no');
            handleSort('sortReport', 'title');
            handleSort('sortDate', 'creation_date');
            updateSortIcons();

            const fetchData = (page = 1) => {
                const params = new URLSearchParams(window.location.search);
                params.set('page', page);
                for (const [column, state] of Object.entries(sortStates)) {
                    if (state !== 'neutral') {
                        params.set('sort_column', column);
                        params.set('sort_order', state);
                    }
                }

                const searchText = searchInput.value.trim();
                if (searchText) {
                    params.set('search', searchText);
                }

                const selectedFilter = filter.value;
                if (selectedFilter && selectedFilter !== 'default') {
                    params.set('filter', selectedFilter);
                }

                // Use 'history.php' as the source file
                navigatePage(page, 'ad_reports.php');
            };

            const navigatePage = (page, sourceFile) => {
                const params = new URLSearchParams(window.location.search);
                params.set('page', page);
                const searchText = searchInput.value.trim();
                const selectedFilter = filter.value;

                if (searchText) {
                    params.set('search', searchText);
                }

                if (selectedFilter && selectedFilter !== 'default') {
                    params.set('filter', selectedFilter);
                }

                const sortColumn = Object.keys(sortStates).find(column => sortStates[column] !== 'neutral');
                if (sortColumn) {
                    params.set('sort_column', sortColumn);
                    params.set('sort_order', sortStates[sortColumn]);
                }

                // Fetch table data
                params.set('ajax', 'table');
                fetch(`${sourceFile}?${params.toString()}`)
                    .then(response => response.text())
                    .then(html => {
                        tableBody.innerHTML = html;
                        attachRowCheckboxEvents();
                    })
                    .catch(error => console.error('Error fetching table data:', error));

                // Fetch pagination data
                params.set('ajax', 'pagination');
                fetch(`${sourceFile}?${params.toString()}`)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newPagination = doc.querySelector('#pagination');
                        if (newPagination) {
                            document.getElementById('pagination').innerHTML = newPagination.innerHTML;
                        }
                    })
                    .catch(error => console.error('Error fetching pagination data:', error));
            };

            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    fetchData();
                }
            });

            searchInput.addEventListener('input', () => {
                fetchData();
            });

            filter.addEventListener('change', () => {
                fetchData();
            });

            fetchData(); // Initial fetch on page load
        });
    

        //GENERATE REPORTS
        function openCreate() {
            document.getElementById("createModal").style.display = "block";
        }
        function closeCreate() {
            document.getElementById("createReport").reset();  // Reset the form fields
            document.getElementById("createModal").style.display = "none";
        }

        // Existing functions
        function openView() {
            document.getElementById("viewModal").style.display = "block";
        }
        function closeView() {
            document.getElementById("viewModal").style.display = "none";
        }

        function openReport(element) {
            const content = element.getAttribute("data-content");
            document.getElementById("reportContent").innerHTML = content.replace(/\n/g, "<br>");
            openView();
        }
{
        var modalOption1 = document.getElementById("statusModal");
        var modalOption2 = document.getElementById("profileModal");
        var modalOption3 = document.getElementById("statsModal");

        var btn = document.getElementById("submitBtn");

        var spans = document.querySelectorAll(".close");

        btn.onclick = function() {
            var selectValue = document.getElementById("reportScholar").value;
            var radioValue = document.querySelector('input[name="batches"]:checked');
            
            if (selectValue && radioValue) {
                switch (selectValue) {
                    case "status":
                        modalOption1.style.display = "block";
                        break;
                    case "profile":
                        modalOption2.style.display = "block";
                        break;
                    case "stats":
                        modalOption3.style.display = "block";
                        break;
                }
            }
        }

        spans.forEach(function(span) {
            span.onclick = function() {
                modalOption1.style.display = "none";
                modalOption2.style.display = "none";
                modalOption3.style.display = "none";
            }
        });

        window.onclick = function(event) {
            if (event.target == modalOption1 || event.target == modalOption2 || event.target == modalOption3) {
                modalOption1.style.display = "none";
                modalOption2.style.display = "none";
                modalOption3.style.display = "none";
            }
        }
    
        //STATUS MODAL
        function openStatus() {
            document.getElementById("statusOverlay").style.display = "block";
        }
        function closeStatus() {
            document.getElementById("statusOverlay").style.display = "none";
        }
        function downloadForm() {
            closeStatus();
        }

        //PROFILE MODAL
        function openProfile() {
            document.getElementById("profileOverlay").style.display = "block";
        }
        function closeProfile() {
            document.getElementById("profileOverlay").style.display = "none";
        }
        function downloadForm() {
            closeProfile();
        }
}
    </script>
</body>
</html>