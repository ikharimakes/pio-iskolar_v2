<?php
    include_once('../functions/general.php');
    include('../functions/scholar_view.php');
    include('../functions/scholar_fx.php');
    include('../functions/page.php');
    $sourceFile = 'eval_scholar.php';

    $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'scholar_id';
    $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'asc';
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $total_records = getTotalRecords();

    $records_per_page = 15;
    $total_page = ceil($total_records / $records_per_page);

    if (isset($_GET['ajax'])) {
        if ($_GET['ajax'] === 'table') {
            scholarDisplay($current_page, $sort_column, $sort_order);
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
    <link rel="stylesheet" href="css/ad_scholar.css">
    <link rel="stylesheet" href="css/confirm.css">
    <link rel="stylesheet" href="css/page.css">
    <script src="https://kit.fontawesome.com/3d9c1c4bc8.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- SIDEBAR - eval_nav.php -->
    <?php include 'eval_navbar.php'; ?>
    

    <!-- TOP BAR -->
    <div class="main">
        <div class="topBar">
            <div class="headerName">
                <h1>Scholar</h1>
            </div>

            <div class="headerRight">
                <div class="notif">
                    <ion-icon name="notifications-outline" onclick="openNotif()"></ion-icon>
                </div>

                <a class="user" href="eval_settings.php">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <div class="line"></div>


        <!-- SCHOLAR LIST -->
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

            <div class="sort">
                <select id="filter">
                    <option value="" disabled selected>Status</option>
                    <option value="all">All</option>
                    <option value="ACTIVE">ACTIVE</option>
                    <option value="PROBATION">PROBATION</option>
                    <option value="DROPPED">DROPPED</option>
                    <option value="LOA">LOA</option>
                    <option value="GRADUATE">GRADUATE</option>
                </select>
            </div>

            <button type="button" class="btnAdd" style="margin-right: 1vh;" onclick="openAdd()"> Add Scholar </button>
            <button type="button" class="btnAdd" onclick="openBatch()"> Batch Creation </button>
        </div> <br>

        <div class="tables">
            <table>
                <tr style="font-weight: bold;">
                    <th> <input type="checkbox" id="selectAll" name="selected_rows[]"> </th>
                    <th style="width:10%">
                        <div class="scholar-header" id="sortScholar" style="justify-content: center; cursor: pointer;">
                            Scholar No.
                            <i id="scholarSortIcon" class="fa fa-sort"></i>
                        </div>
                        </div>
                    </th>
                    <th style="width:12%">  
                        <div class="lName-header" id="sortLastName" style="cursor: pointer;">
                            Last Name
                            <i id="lastSortIcon" class="fa fa-sort"></i>
                        </div>
                        </div>
                    </th>
                    <th style="width:25%"> 
                        <div class="fName-header" id="sortFirstName" style="cursor: pointer;">
                            First Name
                            <i id="firstSortIcon" class="fa fa-sort"></i>
                        </div>
                    </th>
                    <th style="width:37%">
                        <div class="school-header" id="sortSchool" style="cursor: pointer;">
                            School
                            <i id="schoolSortIcon" class="fa fa-sort"></i>
                        </div>
                    </th>
                    <th style="justify-content: center; width:12%"> Status </th>
                    <th style="width:5%"> Actions </th>
                </tr>
                <tbody id="scholarTableBody">
                </tbody>
            </table>
        </div>

        <?php renderPagination($current_page, $records_per_page, $total_records, $total_page, $sourceFile); ?>

    </div>
    

    <!-- ADD SCHOLAR MODAL -->    
    <div id="addModal" class="overlay">
        <form id="addScholarForm" method="post" action="">
            <div class="overlay-content">
                <h2>Add Individual Scholar</h2>
                <span class="closeOverlay" onclick="closeAdd()">&times;</span>
                <br> <br>
                
                <table>
                    <tr>
                        <td class="details">SCHOLAR ID</td>
                        <td><input type="text" class="input" name="scholar_id" maxlength="5" pattern="\d{5}" placeholder="29001" required></td>
                    </tr>
                    <tr>
                        <td class="details">NAME</td>
                        <td>
                            <input type="text" class="input" name="last_name" placeholder="Last Name" required>
                            <input type="text" class="input" name="first_name" placeholder="First Name(s)" required>
                            <input type="text" class="input" name="middle_name" placeholder="Middle Name">
                        </td>
                    </tr>
                    <tr>
                        <td class="details">SCHOOL</td>
                        <td>
                            <input list="school" class="input" name="school" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="details">COURSE</td>
                        <td>
                            <input list="course" class="input" name="course" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="details">ADDRESS</td>
                        <td><input type="text" class="input" name="address" required></td>
                    </tr>
                    <tr>
                        <td class="details">CONTACT</td>
                        <td><input type="text" class="input" name="contact" pattern="\+63\d{10}" placeholder="+639012345678" value="+63" required></td>
                    </tr>
                    <tr>
                        <td class="details">EMAIL</td>
                        <td><input type="email" class="input" name="email" placeholder="example.email@gmail.com" required></td>
                    </tr>
                </table>
                
                <br><br>
                <button name="individual" type="submit" class="button">Save</button>
            </div>
        </form>
    </div>

    <!-- BATCH UPLOAD MODAL -->
    <div id="batchModal" class="batchOverlay">
        <div class="batch-content">
            <div class="infos">
                <h2>Batch Creation</h2>
                <span class="closeBatch" onclick="closeBatch()">&times;</span>
            </div>
            <br><br>

            <div class="step">
                <h4>Step 1: Download CSV Template</h4>
                <a href="../assets/SCHOLAR TEMPLATE.csv" download="SCHOLAR TEMPLATE" class="dl-button"> 
                    <ion-icon name="download-outline"></ion-icon>CSV Template
                </a>
            </div> <br>

            <div class="step">
                <h4>Step 2: Fill out the Template</h4>
            </div> <br>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="step">
                    <h4>Step 3: Batch Number</h4>
                    <input type="number" id="textInput" name="batch_id" required>
                </div> <br>

                <div class="step">
                    <h4>Step 4: Upload here </h4>
                    <label type="button" class="lblAdd" for="upload"> 
                        <ion-icon name="share-outline"> </ion-icon>
                        Batch Creation
                        <input type="file" name="csv" accept=".csv" id="upload" onchange="form.submit()" hidden/>
                    </label>
                </div>
            </form>
            <br> <br>
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
            const selectAllCheckbox = document.getElementById('selectAll');
            const individualCheckboxes = document.querySelectorAll('input[name="selected_rows[]"]');
            const actionButtons = document.querySelector('.actions');
            const tableBody = document.getElementById('scholarTableBody');
            const pagination = document.getElementById('pagination');

            let sortStates = {
                'scholar_id': 'neutral',
                'last_name': 'neutral',
                'first_name': 'neutral',
                'school': 'neutral'
            };

            const updateSortIcons = () => {
                const icons = {
                    'scholar_id': document.getElementById('scholarSortIcon'),
                    'last_name': document.getElementById('lastSortIcon'),
                    'first_name': document.getElementById('firstSortIcon'),
                    'school': document.getElementById('schoolSortIcon')
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

            handleSort('sortScholar', 'scholar_id');
            handleSort('sortLastName', 'last_name');
            handleSort('sortFirstName', 'first_name');
            handleSort('sortSchool', 'school');
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
                navigatePage(page, 'eval_scholar.php');
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

            const toggleActionButtons = () => {
                const anyChecked = Array.from(individualCheckboxes).some(checkbox => checkbox.checked);
                actionButtons.style.display = anyChecked ? 'block' : 'none';
            };

            selectAllCheckbox.addEventListener('change', () => {
                const isChecked = selectAllCheckbox.checked;
                individualCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                toggleActionButtons();
            });

            const attachRowCheckboxEvents = () => {
                const newCheckboxes = document.querySelectorAll('input[name="selected_rows[]"]');
                newCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        if (!checkbox.checked) {
                            selectAllCheckbox.checked = false;
                        }
                        toggleActionButtons();
                    });
                });
            };

            attachRowCheckboxEvents();
            fetchData(); // Initial fetch on page load
        });

        //ADD SCHOLAR
        function openAdd() {
            document.getElementById("addModal").style.display = "block";
        }
        function closeAdd() {
            document.getElementById("addModal").style.display = "none";
        }
        function submitForm() {
            closeAdd();
        }

        //BATCH UPLOAD
        function openBatch() {
            document.getElementById("batchModal").style.display = "block";
        }
        function closeBatch() {
            document.getElementById("batchModal").style.display = "none";
        }
        function submitForm() {
            closeBatch();
        }
    </script>
</body>
</html>
