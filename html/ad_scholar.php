<?php
    include_once('../functions/general.php');
    include('../functions/scholar_view.php');
    include('../functions/scholar_fx.php');
    include('../functions/page.php');
    $sourceFile = 'ad_scholar.php';

    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : (isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : null);

    if ($user_role == "1") {
    } elseif ($user_role == "2") {
        header("Location: dashboard.php");
    } elseif ($user_role == "3") {
        header("Location: eval_dashboard.php");
    } else {
        header("Location: index.php");
    }

    $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'scholar_id';
    $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'desc';
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $total_records = getTotalRecords();

    $records_per_page = 15;
    $total_page = ceil($total_records / $records_per_page);

    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $values = getUniqueFilterValues($category);

    // Handle AJAX requests
    if (isset($_GET['ajax'])) {
        if ($_GET['ajax'] === 'getInitialFilters') {
            $htmlResponse = '';
    
            if (isset($_SESSION['scholar_filter'])) {
                $filterData = $_SESSION['scholar_filter'];
                $htmlResponse .= '<input type="hidden" id="category" value="' . htmlspecialchars($filterData['category']) . '">';
                $htmlResponse .= '<input type="hidden" id="filter" value="' . htmlspecialchars($filterData['filter']) . '">';
    
                // Clear the session data after using it
                unset($_SESSION['scholar_filter']);
            }
    
            echo $htmlResponse;
            exit;
        } else if ($_GET['ajax'] === 'table') {
            scholarList($current_page, $sort_column, $sort_order);
        } elseif ($_GET['ajax'] === 'pagination') {
            renderPagination($current_page, $records_per_page, $total_records, $total_page, $sourceFile);
        }
        elseif ($_GET['ajax'] === 'getFilterValues') {
            if (!empty($values)) {
                echo '<option value="all">All</option>';
                foreach ($values as $value) {
                    echo '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($value) . '</option>';
                }
            } else {
                echo '<option value="all">ALL</option>';
            }
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
    <link rel="stylesheet" href="css/page.css">
    <script src="https://kit.fontawesome.com/3d9c1c4bc8.js" crossorigin="anonymous"></script>
    <style>
        .required-error {
            border: 2px solid red !important;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR - ad_nav.php -->
    <?php include 'ad_navbar.php'; ?>

    <!-- TOP BAR -->
    <div class="main">
        <div class="topBar">
            <div class="headerName">
                <h1>Scholar</h1>
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

            <div class="sorts">
                <h4> Filter by:</h4>

                <div class="sort">
                    <select id="category">
                        <option value="all" selected>NONE</option>
                        <option value="batch_no">Batch Number</option>
                        <option value="status">Scholar Status</option>
                        <option value="school">School</option>
                    </select>
                </div>

                <div class="sort">
                    <select id="filter" style="width:150px;">
                        <option value="all" disabled selected>NONE</option>
                    </select>
                </div>
            </div>


            <button type="button" class="btnAdd" style="margin-right: 1vh;" onclick="openAdd()"> Add Scholar </button>
            <button type="button" class="btnAdd" style="margin-right: 1vh;" onclick="openBatch()"> Batch Creation </button>
            <button type="button" class="btnAdd" id="exportBtn">Export Table</button>
        </div> <br>

        <div class="tables">
            <table>
                <tr style="font-weight: bold;">
                    <th style="width:10%">
                        <div class="scholar-header" id="sortScholar" style="justify-content: center; cursor: pointer;">
                            Scholar No.
                            <i id="scholarSortIcon" class="fa fa-sort"></i>
                        </div>
                    </th>
                    <th style="width:12%">  
                        <div class="lName-header" id="sortLastName" style="cursor: pointer;">
                            Last Name
                            <i id="lastSortIcon" class="fa fa-sort"></i>
                        </div>
                    </th>
                    <th style="width:20%"> 
                        <div class="fName-header" id="sortFirstName" style="cursor: pointer;">
                            First Name
                            <i id="firstSortIcon" class="fa fa-sort"></i>
                        </div>
                    </th>
                    <th style="width:30%">
                        <div class="school-header" id="sortSchool" style="cursor: pointer;">
                            School
                            <i id="schoolSortIcon" class="fa fa-sort"></i>
                        </div>
                    </th>
                    <th style="justify-content: center; width:12%"> Doc Status </th>
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
    <div id="addModal" class="addOverlay">
        <form id="addScholarForm" method="post" action="">
            <div class="add-content">
                <h2>Add Individual Scholar</h2>
                <span class="closeOverlay" onclick="closeAdd()">&times;</span>
                <br> <br>
                
                <table style="border:none;">
                    <tr>
                        <td class="details">SCHOLAR ID</td>
                        <td><input type="text" class="input" name="scholar_id" maxlength="5" pattern="\d{5}" placeholder="29001" required></td>
                    </tr>
                    <tr>
                        <td class="details">LAST NAME</td>
                        <td><input type="text" class="input" name="last_name" placeholder="Last Name" required></td>
                    </tr>
                    <tr>
                        <td class="details">FIRST NAME</td>
                        <td><input type="text" class="input" name="first_name" placeholder="First Name" required></td>
                    </tr>
                    <tr>
                        <td class="details">MIDDLE NAME</td>
                        <td><input type="text" class="input" name="middle_name" placeholder="Middle Name"></td>
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
                
                <br>
                <center> <div class="button-container">
                    <button type="button" class="discard" onclick="closeAdd()">Discard</button>
                    <button name="individual" type="submit" class="save">Save</button>
                </div> </center>
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

            <form id="batchForm" method="post" enctype="multipart/form-data">
                <div class="step">
                    <h4>Step 3: Batch Number</h4>
                    <input type="number" id="textInput" name="batch_id" required>
                </div> <br>

                <div class="step">
                    <h4>Step 4: Upload here </h4>
                        <label type="button" class="lblAdd" for="upload">
                            <ion-icon name="share-outline"> </ion-icon>
                            Batch Creation
                            <input type="file" name="csv" accept=".csv" id="upload" hidden/>
                        </label>
                    <!-- WAG AUTO-SUBMIT -->
                </div>
            </form>
            <br> <br>
        </div>
    </div>

    <?php include 'confirm.php'; ?>
    <?php include 'toast.php'; ?>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // FETCH API SEARCH/SORT/FILTER AND PAGINATION
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.querySelector('input[name="search"]');
            const filter = document.getElementById('filter');
            const categorySelect = document.getElementById('category');
            const tableBody = document.getElementById('scholarTableBody');
            const pagination = document.getElementById('pagination');
            
            const checkInitialFilters = () => {
                fetch('ad_scholar.php?ajax=getInitialFilters')
                    .then(response => response.text())
                    .then(html => {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;

                        const categoryValue = tempDiv.querySelector('#category')?.value;
                        const filterValue = tempDiv.querySelector('#filter')?.value;

                        if (categoryValue) {
                            categorySelect.value = categoryValue;

                            // Fetch filter values for this category
                            const params = new URLSearchParams();
                            params.set('ajax', 'getFilterValues');
                            params.set('category', categoryValue);

                            fetch(`ad_scholar.php?${params.toString()}`)
                                .then(response => response.text())
                                .then(html => {
                                    filter.innerHTML = html;
                                    if (filterValue) {
                                        filter.value = filterValue;
                                    }
                                    fetchData(1);
                                });
                        } else {
                            fetchData(1);
                        }
                    })
                    .catch(error => {
                        console.error('Error checking initial filters:', error);
                        fetchData(1);
                    });
            };

            // Call this instead of fetchData() on initial load
            checkInitialFilters();

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

            // Fetch unique filter values for the selected category
            const fetchFilterValues = (category) => {
                if (category === 'all') {
                    filter.innerHTML = '<option value="all" disabled selected>NONE</option>';
                    return;
                }

                const params = new URLSearchParams();
                params.set('ajax', 'getFilterValues');
                params.set('category', category);

                fetch(`ad_scholar.php?${params.toString()}`)
                    .then(response => response.text()) // Use .text() since we're expecting raw HTML
                    .then(html => {
                        filter.innerHTML = html; // Directly set the HTML options
                    })
                    .catch(error => console.error('Error fetching filter values:', error));
            };

            categorySelect.addEventListener('change', () => {
                const selectedCategory = categorySelect.value;
                fetchFilterValues(selectedCategory);
            });

            // In ad_scholar.php, replace the existing fetch data implementation with this:
            const fetchData = (page = 1) => {
                const params = new URLSearchParams();
                params.set('page', page);

                // Add sort parameters
                for (const [column, state] of Object.entries(sortStates)) {
                    if (state !== 'neutral') {
                        params.set('sort_column', column);
                        params.set('sort_order', state);
                    }
                }

                // Add search and filter parameters
                const searchText = searchInput.value.trim();
                const selectedCategory = categorySelect.value;
                const selectedFilter = filter.value;

                if (searchText) {
                    params.set('search', searchText);
                }
                if (selectedCategory) {
                    params.set('category', selectedCategory);
                    if (selectedFilter) {
                        params.set('filter', selectedFilter);
                    }
                }

                // Update URL without refreshing page (optional)
                // window.history.replaceState({}, '', `?${params.toString()}`);

                // Fetch table data
                const tableParams = new URLSearchParams(params);
                tableParams.set('ajax', 'table');
                fetch(`ad_scholar.php?${tableParams.toString()}`)
                    .then(response => response.text())
                    .then(html => {
                        tableBody.innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching table data:', error));

                // Fetch pagination data
                const paginationParams = new URLSearchParams(params);
                console.log(paginationParams);
                paginationParams.set('ajax', 'pagination');
                fetch(`ad_scholar.php?${paginationParams.toString()}`)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newPagination = doc.querySelector('#pagination');
                        if (newPagination) {
                            pagination.innerHTML = newPagination.innerHTML;
                        }
                    })
                    .catch(error => console.error('Error fetching pagination:', error));
            };

            // Add event listeners to search input and filter
            searchInput.addEventListener('input', () => fetchData(1));
            categorySelect.addEventListener('change', () => {
                const selectedCategory = categorySelect.value;
                fetchFilterValues(selectedCategory);
                fetchData(1); // Reset to page 1 when category changes
            });
            filter.addEventListener('change', () => fetchData(1));

            // fetchData(); // Initial fetch on page load
        });

        //ADD SCHOLAR
        function openAdd() {
            document.getElementById("addModal").style.display = "block";
        }
        function closeAdd() {
            document.getElementById("addScholarForm").reset();  // Reset the form fields
            document.getElementById("addModal").style.display = "none";
        }

        document.getElementById('addScholarForm').addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevent the form from being submitted

            const formData = new FormData(); // Manually create FormData object
            formData.append('individual', 'true'); // Flag for form submission
            // Manually append each field
            formData.append('scholar_id', document.querySelector('input[name="scholar_id"]').value);
            formData.append('last_name', document.querySelector('input[name="last_name"]').value);
            formData.append('first_name', document.querySelector('input[name="first_name"]').value);
            formData.append('middle_name', document.querySelector('input[name="middle_name"]').value);
            formData.append('school', document.querySelector('input[name="school"]').value);
            formData.append('course', document.querySelector('input[name="course"]').value);
            formData.append('address', document.querySelector('input[name="address"]').value);
            formData.append('contact', document.querySelector('input[name="contact"]').value);
            formData.append('email', document.querySelector('input[name="email"]').value);

            try {
                const response = await fetch('../functions/scholar_fx.php', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const result = await response.json();

                if (result.exists) {
                    showToast('Scholar ID already exists!', 'Duplicate Entry');
                } else if (result.success) {
                    showToast('Scholar added successfully! Email will be sent in the background.', 'Success');
                    // Reload immediately after showing toast
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast('An error occurred during submission.', 'Error');
                }
            } catch (error) {
                console.error('Error occurred:', error);
                showToast('Unexpected response from the server.', 'Error');
            }
        });

        //BATCH UPLOAD
        function openBatch() {
            document.getElementById("batchModal").style.display = "block";
        }
        function closeBatch() {
            document.getElementById("batchForm").reset();  // Reset the 
            document.getElementById("batchModal").style.display = "none";
        }

        document.getElementById('upload').addEventListener('change', function(e) {
            e.preventDefault();
            const fileInput = this; // Store reference to file input
            const formData = new FormData(document.getElementById('batchForm'));
            
            fetch('../functions/scholar_fx.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showToast(data.message, data.title);
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                } else if (data.status === 'error') {
                    showToast(data.message, data.title);
                    // Clear the file input
                    fileInput.value = '';
                    // If you're using jQuery, alternatively you could use:
                    // $(fileInput).val('');
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                showToast('An unexpected error occurred.', 'Error');
                // Also clear the file input on unexpected errors
                fileInput.value = '';
            });
        });
        
        document.getElementById('exportBtn').addEventListener('click', function() {
            let sortStates = {
                'scholar_id': 'neutral',
                'last_name': 'neutral',
                'first_name': 'neutral',
                'school': 'neutral'
            };

            // Get current sort state
            const sortColumn = Object.entries(sortStates)
                .find(([_, state]) => state !== 'neutral')?.[0] || 'scholar_id';
            const sortOrder = sortStates[sortColumn] || 'asc';

            // Get current search and filter parameters
            const searchValue = document.querySelector('input[name="search"]').value.trim();
            const categoryValue = document.getElementById('category').value;
            const filterValue = document.getElementById('filter').value;

            // Build the query parameters
            const params = new URLSearchParams();
            params.set('export_csv', '1');
            params.set('sort_column', sortColumn);
            params.set('sort_order', sortOrder);
            
            if (searchValue) {
                params.set('search', searchValue);
            }
            if (categoryValue && categoryValue !== 'all') {
                params.set('category', categoryValue);
            }
            if (filterValue && filterValue !== 'all') {
                params.set('filter', filterValue);
            }

            // Make the fetch request with the parameters
            fetch(`${window.location.pathname}?${params.toString()}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: params.toString()
            })
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = 'scholar_list.csv';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
    
</body>
</html>
