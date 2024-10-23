<?php
    include_once('../functions/general.php');
    include('../functions/school_view.php');
    include('../functions/school_fx.php');
    include('../functions/page.php');
    $sourceFile = 'ad_school.php';

    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : (isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : null);

    if ($user_role == "1") {
    } elseif ($user_role == "2") {
        header("Location: dashboard.php");
    } elseif ($user_role == "3") {
        header("Location: eval_dashboard.php");
    } else {
        header("Location: front_page.php");
    }

    $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'school_id';
    $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'asc';
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $total_records = getTotalRecords();

    $records_per_page = 15;
    $total_page = ceil($total_records / $records_per_page);

    if (isset($_GET['ajax'])) {
        if ($_GET['ajax'] === 'table') {
            schoolList($current_page, $sort_column, $sort_order);
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
    <link rel="stylesheet" href="css/ad_scholar.css"> <!-- REPLACE -->
    <link rel="stylesheet" href="css/page.css">
    <script src="https://kit.fontawesome.com/3d9c1c4bc8.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- SIDEBAR - ad_nav.php -->
    <?php include 'ad_navbar.php'; ?>

    <!-- TOP BAR -->
    <div class="main">
        <div class="topBar">
            <div class="headerName">
                <h1>Schools and Universities</h1>
            </div>

            <div class="headerRight">
                <a class="user" href="ad_profile.php">
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

            <div class="sorts">
                <h4> Filter by:</h4>

                <select id="filter">
                    <option value="" disabled selected>SEMESTER</option>
                    <option value="all">All</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>

            <button type="button" class="btnAdd" style="margin-right: 1vh;" onclick="openAdd()"> Add School</button>
        </div> <br>

        <div class="tables">
            <table>
            <tr style="font-weight: bold;">
                    <th style="width:35%">
                        <div class="school-header" id="sortSchool" style="cursor: pointer;">
                            School Name
                            <i id="schoolSortIcon" class="fa fa-sort"></i>
                        </div>
                    </th>
                    <th style="width:45%">
                        <div class="school-header" id="sortAddress" style="cursor: pointer;">
                            Address
                            <i id="addressSortIcon" class="fa fa-sort"></i>
                        </div>
                    </th>
                    <th style="width:10%; justify-content: center; cursor: pointer;"> Academic Year </th>
                    <th style="width:10%; justify-content: center; cursor: pointer;"> Semester </th>
                    <th style="width:5%"> Action </th>
                </tr>
                <tbody id="schoolTableBody">
                </tbody>
            </table>
        </div>

        <?php renderPagination($current_page, $records_per_page, $total_records, $total_page, $sourceFile); ?>

    </div>
    

    <!-- ADD SCHOLAR MODAL -->    
    <div id="addModal" class="addOverlay">
        <form id="addSchoolForm" method="post" action="">
            <div class="add-content">
                <h2>Add School/University</h2>
                <span class="closeOverlay" onclick="closeAdd()">&times;</span>
                <br> <br>
                
                <table>
                    <tr>
                        <td class="details">SCHOOL/UNIVERSITY NAME</td>
                        <td>
                            <input list="school" class="input" name="school" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="details">ADDRESS</td>
                        <td>
                            <input class="input" name="address" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="details">SEMESTERS PER ACADEMIC YEAR</td>
                        <td>
                            <input type="radio" id="sem_2" name="semester" value="2" required/> <label for="sem_2">2 SEMESTERS</label>
                            <input type="radio" id="sem_3" name="semester"  value="3"/> <label for="sem_3">3 SEMESTERS</label>
                        </td>
                    </tr>
                </table>
                
                <br>
                <center> <div class="button-container">
                    <button class="discard" onclick="closeAdd()">Discard</button>
                    <button name="add" type="submit" class="save">Save</button>
                </div> <center>
            </div>
        </form>
    </div>

    <!-- EDIT SCHOOL MODAL -->    
    <div id="editModal" class="addOverlay">
        <form id="editSchoolForm" method="post" action="">
            <div class="add-content">
                <h2>Edit School/University</h2>
                <span class="closeOverlay" onclick="closeEdit()">&times;</span>
                <br> <br>

                <input type="hidden" id="edit-id" name="id">
                <table>
                    <tr>
                        <td class="details">SCHOOL/UNIVERSITY NAME</td>
                        <td>
                            <input id="edit-name" list="school" class="input" name="school" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="details">ADDRESS</td>
                        <td>
                            <input id="edit-address" class="input" name="address" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="details">SEMESTERS PER ACADEMIC YEAR</td>
                        <td>
                            <input type="radio" id="sem_2" name="semester" value="2" required/> <label for="sem_2">2 SEMESTERS</label>
                            <input type="radio" id="sem_3" name="semester"  value="3"/> <label for="sem_3">3 SEMESTERS</label>
                        </td>
                    </tr>
                </table>
                
                <br>
                <center> <div class="button-container">
                    <button class="discard" onclick="closeEdit()">Discard</button>
                    <button name="edit" type="submit" class="save">Save</button>
                </div> <center>
            </div>
        </form>
    </div>

    <!-- DELETE MODAL - confirm.php -->
    <?php include 'confirm.php'; ?>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // FETCH API SEARCH/SORT/FILTER AND PAGINATION
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.querySelector('input[name="search"]');
            const filter = document.getElementById('filter');
            const tableBody = document.getElementById('schoolTableBody');
            const pagination = document.getElementById('pagination');

            let sortStates = {
                'school_name': 'neutral',
                'address': 'neutral'
            };

            const updateSortIcons = () => {
                const icons = {
                    'school_name': document.getElementById('schoolSortIcon'),
                    'address': document.getElementById('addressSortIcon')
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

            handleSort('sortSchool', 'school_name');
            handleSort('sortAddress', 'address');
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
                navigatePage(page, 'ad_school.php');
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

        //ADD SCHOLAR
        function openAdd() {
            document.getElementById("addModal").style.display = "block";
        }
        function closeAdd() {
            document.getElementById("addSchoolForm").reset();  // Reset the form fields
            document.getElementById("addModal").style.display = "none";
        }
        function submitForm() {
            closeAdd();
        }

        //EDIT
        function openEdit(elem) {
            document.getElementById("edit-id").value = elem.getAttribute("data-id");
            document.getElementById("edit-name").value = elem.getAttribute("data-name");
            document.getElementById("edit-address").value = elem.getAttribute("data-address");

            const semesterValue = elem.getAttribute("data-sem");
            if (semesterValue === "2") {
                document.getElementById("sem_2").checked = true;
            } else if (semesterValue === "3") {
                document.getElementById("sem_3").checked = true;
            }

            document.getElementById("editModal").style.display = "block";
        }

        function closeEdit() {
            document.getElementById("editSchoolForm").reset();  // Reset the form fields
            document.getElementById("editModal").style.display = "none";
        }
    </script>
</body>
</html>
