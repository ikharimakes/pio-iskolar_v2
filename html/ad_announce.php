<?php
    include_once('../functions/general.php');
    include('../functions/announce_view.php');
    include('../functions/announce_fx.php');
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

    $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'announce_id';
    $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'desc';
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $total_records = getTotalRecords();

    $records_per_page = 15;
    $total_page = ceil($total_records / $records_per_page);

    if (isset($_GET['ajax'])) {
        if ($_GET['ajax'] === 'table') {
            annList($current_page, $sort_column, $sort_order);
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
    <link rel="stylesheet" href="css/ad_announce.css">
    <link rel="stylesheet" href="css/confirm.css">
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
                <h1>Announcement</h1>
            </div>

            <div class="headerRight">
                <a class="user" href="ad_profile.php">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <div class="line"></div>
        

        <!-- ANNOUNCEMENT -->
        <div class="info">
            <div class="search">
                <form action="" method="get">
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
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            
            <form>
                <button type="button" class="btnAdd" onclick="openModal('announceModal')"> Add Announcement </button>
            </form> 
        </div> <br>

        <div class="tables">
            <table>
                <tr style="font-weight: bold;">
                    <th style="width:46%"> 
                        <div class="title-header" id="sortTitle" style="cursor: pointer;">
                            Title
                            <i id="titleSortIcon" class="fa fa-sort"></i>
                        </div> 
                    </th>
                    <th style="width:10%"> 
                <!-- replace class with batchdate-header -->
                        <div class="startDate-header" id="sortBatch" style="justify-content: center; cursor: pointer;">
                            Recipient Batch
                            <i id="batchSortIcon" class="fa fa-sort"></i>
                        </div> 
                    </th>
                    <th style="width:12%"> 
                        <div class="startDate-header" id="sortStart" style="justify-content: center; cursor: pointer;">
                            Start Date
                            <i id="startSortIcon" class="fa fa-sort"></i>
                        </div> 
                    </th>
                    <th style="width:12%"> 
                        <div class="endDate-header" id="sortEnd" style="justify-content: center; cursor: pointer;">
                            End Date
                            <i id="endSortIcon" class="fa fa-sort"></i>
                        </div>
                    </th>
                    <th style="width:12%"> Status </th>
                    <th style="width:8%"> Action </th>
                <tbody id="announceTableBody">
                </tbody>
            </table>
        </div>

        <?php renderPagination($current_page, $records_per_page, $total_records, $total_page, $sourceFile); ?>

    </div>


    <!-- ADD ANNOUNCEMENTS MODAL -->
    <div id="announceModal" class="addOverlay">
        <form id="createAnnounce" action="" method="post" enctype="multipart/form-data">
            <div class="add-content">
                <div class="infos">
                    <h1>Publish Announcement</h1>
                    <span class="closeOverlay" onclick="closeModal('announceModal')">&times;</span>
                </div>
                <br><br>

                <div class="batch"> 
                    <h3>Recipient</h3>
                        <div class="dropdown">
                            <div class="dropdown-button" onclick="toggleDropdown()">Select Batches</div>
                            <div class="dropdown-content">
                                <label><input type="checkbox" name="batch" value="all"> All Batches</label>
                                <label><input type="checkbox" name="batch" value="26"> Batch 26</label>
                                <label><input type="checkbox" name="batch" value="27"> Batch 27</label>
                                <label><input type="checkbox" name="batch" value="28"> Batch 28</label>
                                <label><input type="checkbox" name="batch" value="29"> Batch 29</label>
                                <label><input type="checkbox" name="batch" value="30"> Batch 30</label>
                                <label><input type="checkbox" name="batch" value="31"> Batch 31</label>
                            </div>
                        </div>
                </div> <br>

                <div class="announceTitle">
                    <h3>Announcement Title</h3>
                    <input type="text" name="title"> 
                </div> <br>

                <div class="announceImg">
                    <h3>Upload an Image</h3>
                    <label for="add-file" class="custom-file-upload">
                        <ion-icon name="share-outline"> </ion-icon> Upload Image
                    </label>
                    <input name="cover" type="file" id="add-file" accept="image/png, image/gif, image/jpeg" style="display: none;" /> 
                </div> <br>

                <div class="announceDetail">
                    <h3>Announcement Details</h3>
                    <textarea name="content" rows="2" cols="50"> </textarea>
                </div> <br>

                <div class="announceDate">
                    <h3>End Date</h3>
                    <input type="date" name="endDate" required>
                </div> <br>

                <div class="btn">
                <button class="discard" onclick="closeModal('announceModal')">Discard</button>
                    <button type="submit" name="add_ann" class="publish-button"> Publish </button>
                </div> <br>
            </div>
        </form>
    </div>

    <!-- VIEW MODAL -->
    <div id="viewModal" class="viewOverlay">
        <div class="view-content">
            <h2 id="view-title"> Application for Batch 23 </h2>
            <span class="closeOverlay" onclick="closePrev()">&times;</span>

            <div class="card"> 
                <img id="view-img" class="pic" src="images/pic1.jpg" alt="click here">
                <div class="container">
                    <center> 
                        <p id="view-content" class="caption"></p> 
                    </center>
                </div> 
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" class="addOverlay">
        <div class="add-content">
            <div class="infos">
                <h1>Edit Announcement</h1>
                <span class="closeOverlay" onclick="closeEdit()">&times;</span>
            </div>
            <br><br>

            <form id="editAnnounce" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" id="edit-id" name="id">
                <div class="announceTitle">
                    <h3>Announcement Title</h3>
                    <input type="text" id="edit-title" name="title">
                </div> <br>

                <div class="announceImg">
                    <h3>Upload an Image</h3>

                    <label for="update-file" class="custom-file-upload">
                        <ion-icon name="share-outline"> </ion-icon> Upload Image
                    </label>
                    <input name="cover" type="file" id="update-file" accept="image/png, image/gif, image/jpeg" style="display: none;" /> 
                </div> <br>

                <div class="announceDetail">
                    <h3>Announcement Details</h3>
                    <textarea id="edit-content" name="content" rows="2" cols="50"> </textarea>
                </div> <br>

                <div class="announceDate">
                    <h3>Start Date</h3>
                    <input type="date" id="edit-startDate" name="startDate" required> <br> <br> 

                    <h3>End Date</h3>
                    <input type="date" id="edit-endDate" name="endDate" required>
                </div>

                <div class="btn">
                    <button class="discard" onclick="closeEdit()">Discard</button>
                    <button type="submit" name="update_ann" class="publish-button"> Save </button>
                </div> <br>
            </form>
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
            const tableBody = document.getElementById('announceTableBody');
            const pagination = document.getElementById('pagination');

            let sortStates = {
                'batch_no': 'neutral',
                'title': 'neutral',
                'st_date': 'neutral',
                'end_date': 'neutral'
            };

            const updateSortIcons = () => {
                const icons = {
                    'batch_no': document.getElementById('batchSortIcon'),
                    'title': document.getElementById('titleSortIcon'),
                    'st_date': document.getElementById('startSortIcon'),
                    'end_date': document.getElementById('endSortIcon')
                };

                for (const [column, icon] of Object.entries(icons)) {
                    const state = sortStates[column];
                    if (state === 'neutral') {
                        icon.className = 'fa fa-sort';
                    } else 
                    if (state === 'asc') {
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
            handleSort('sortTitle', 'title');
            handleSort('sortStart', 'st_date');
            handleSort('sortEnd', 'end_date');
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
                navigatePage(page, 'ad_announce.php');
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

            const datePicker = document.querySelectorAll('input[type="date"]').innerHTML;
            datePicker.min = new Date().toISOString().split("T")[0];
        });

        //ADD 
        function openModal(announceModal) {
            var modal = document.getElementById(announceModal);
            modal.style.display = "block";
        }
        function closeModal(announceModal) {
            document.getElementById("createAnnounce").reset();  // Reset the form fields
            var modal = document.getElementById(announceModal);
            modal.style.display = "none";
        }
        function showInput(language) {
            var inputField = document.getElementById("inputField");
            if (language === "batch") {
                inputField.style.display = "block";
            } else {
                inputField.style.display = "none";
            }
        }


        // DROPDOWN WITH CHECKBOX
        function toggleDropdown() {
            document.querySelector('.dropdown').classList.toggle('active');
        }
    
        
        // VIEW
        function openPrev(elem) {
            document.getElementById("view-title").innerText = elem.getAttribute("data-title");
            document.getElementById("view-img").src = '../assets/' + elem.getAttribute("data-img");
            document.getElementById("view-content").innerText = elem.getAttribute("data-content");
            document.getElementById("viewModal").style.display = "block";
        }
        function closePrev() {
            document.getElementById("viewModal").style.display = "none";
        }

        //EDIT
        function openEdit(elem) {
            document.getElementById("edit-id").value = elem.getAttribute("data-id");
            document.getElementById("edit-title").value = elem.getAttribute("data-title");
            document.getElementById("edit-content").value = elem.getAttribute("data-content");
            document.getElementById("edit-startDate").value = elem.getAttribute("data-st_date");
            document.getElementById("edit-endDate").value = elem.getAttribute("data-end_date");
            document.getElementById("editModal").style.display = "block";
        }
        function closeEdit() {
            document.getElementById("editAnnounce").reset();  // Reset the form fields
            document.getElementById("editModal").style.display = "none";
        }

        $(document).ready(function () {
            // Select all input elements with class 'custom-file-upload'
            $('input[type=file]').change(function () {
                var file = $(this)[0].files[0].name;
                // Find the corresponding label by its 'for' attribute
                var labelFor = $(this).attr('id');
                $('label[for=' + labelFor + ']').text(file);
            });
        });
    </script>
</body>
</html>