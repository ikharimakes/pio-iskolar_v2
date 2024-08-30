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
                <div class="notif">
                    <ion-icon name="notifications-outline" onclick="openOverlay()"></ion-icon>
                </div>

                <a class="user" href="ad_settings.php">
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
                <select id="statusSort">
                    <option value="" disabled selected>Status</option>
                    <option value="all">All</option>
                    <option value="resolved">Approved</option>
                    <option value="progress">Pending</option>
                    <option value="pending">Declined</option>
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
                        <div class="scholar-header" style="justify-content: center">
                            Scholar No.
                            <div class="sort-icons">
                                <a href="#" id="scholarAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="scholarDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div>
                    </th>
                    <th style="width:12%">  
                        <div class="lName-header">
                            Last Name
                            <div class="sort-icons">
                                <a href="#" id="lNameAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="lNameDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div>
                    </th>
                    <th style="width:25%"> 
                        <div class="fName-header">
                            First Name
                            <div class="sort-icons">
                                <a href="#" id="fNameAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="fNameDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div>
                    </th>
                    <th style="width:37%">
                        <div class="school-header">
                            School
                            <div class="sort-icons">
                                <a href="#" id="schoolAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="schoolDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div>
                    </th>
                    <th style="width:12%"> Status </th>
                    <th style="width:5%"> Actions </th>
                </tr>
                <tr>
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:10%; text-align: center;"> 21-2321 </td>
                    <td style="width:12%"> ADRIANO </td>
                    <td style="width:25%"> JESSICA RAYE </td>
                    <td style="width:37%">PAMANTASAN NG LUNGSOD NG VALENZUELA </td>
                    <td style="width:12%; text-align: center;" class="statusColor"> ACTIVE </td>
                    <td style="text-align: right;" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View</div>
                            <span> <a href="ad_skoDetail.php"><ion-icon name="eye-outline"></ion-icon> </a> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download</div>
                            <span onclick="openDelete(this)"> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Delete</div>
                            <span onclick="openDelete(this)"> <ion-icon name="trash-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:10%; text-align: center;"> 21-0601 </td>
                    <td style="width:12%"> HIDALGO </td>
                    <td style="width:25%"> MAIKA JASMINE </td>
                    <td style="width:37%"> PAMANTASAN NG LUNGSOD NG MAYNILA </td>
                    <td style="width:12%; text-align: center;" class="statusColor"> GRADUATED </td>
                    <td style="text-align: right;" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View</div>
                            <span> <a href="ad_skoDetail.php"><ion-icon name="eye-outline"></ion-icon> </a> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download</div>
                            <span onclick="openDelete(this)"> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Delete</div>
                            <span onclick="openDelete(this)"> <ion-icon name="trash-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:10%; text-align: center;"> 21-2021 </td>
                    <td style="width:12%"> MARCOS </td>
                    <td style="width:25%"> DANNAH LEI </td>
                    <td style="width:37%"> 	UNIVERSITY OF THE PHILIPPINES DILIMAN </td>
                    <td style="width:12%; text-align: center;" class="statusColor"> PROBATION </td>
                    <td style="text-align: right;" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View</div>
                            <span> <a href="ad_detail.php"><ion-icon name="eye-outline"></ion-icon> </a> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download</div>
                            <span onclick="openDelete(this)"> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Delete</div>
                            <span onclick="openDelete(this)"> <ion-icon name="trash-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        
        <!-- PAGINATION - page.php -->
        <?php include 'page.php'; ?>
    </div>
    

    <!-- ADD SCHOLAR MODAL -->    
    <div id="addOverlay" class="overlay">
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
                        <td><input type="text" class="input" name="contact" pattern="\+63\d{10}" placeholder="+639XXXXXXXXX" value="+63" required></td>
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
    <div id="batchOverlay" class="batchOverlay">
        <div class="batch-content">
            <div class="infos">
                <h2>Batch Creation</h2>
                <span class="closeBatch" onclick="closeBatch()">&times;</span>
            </div>
            <br><br>

            <div class="step">
                <h4>Step 1: Download CSV Template</h4>
                <a href="" class="dl-button"> 
                    <ion-icon name="download-outline"></ion-icon>CSV Template
                </a>
            </div> <br>

            <div class="step">
                <h4>Step 2: Fill out the Template</h4>
            </div> <br>

            <div class="step">
                <h4>Step 3: Batch Number</h4>
                <input type="text" id="textInput" name="batch_id" required>
            </div> <br>

            <div class="step">
                <h4>Step 4: Upload here </h4>
                <form action="" method="post" enctype="multipart/form-data">
                    <label type="button" class="lblAdd" for="upload"> 
                        <ion-icon name="share-outline"> </ion-icon>
                        Batch Creation
                        <input type="file" name="csv" accept=".csv" id="upload" onchange="form.submit()" hidden/>
                    </label>
                </form>
            </div>
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
        //SORT ICON
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.querySelector('input[name="search"]');
            const statusSort = document.getElementById('statusSort');
            const selectAllCheckbox = document.getElementById('selectAll');
            const individualCheckboxes = document.querySelectorAll('input[name="selected_rows[]"]');
            const tableRows = document.querySelectorAll('.tables table tr:not(:first-child)');
            const actionButtons = document.querySelector('.actions');

            // Search functionality
            searchInput.addEventListener('input', () => {
                const searchText = searchInput.value.toLowerCase();
                tableRows.forEach(row => {
                    const docName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    if (docName.includes(searchText)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Generalized sort function for text and numbers
            const sortTable = (columnIndex, order) => {
                const sortedRows = Array.from(tableRows).sort((a, b) => {
                    const cellA = a.querySelector(`td:nth-child(${columnIndex})`).textContent.trim().toLowerCase();
                    const cellB = b.querySelector(`td:nth-child(${columnIndex})`).textContent.trim().toLowerCase();
                    if (!isNaN(cellA) && !isNaN(cellB)) {
                        // Sort numerically if both are numbers
                        return order === 'asc' ? cellA - cellB : cellB - cellA;
                    }
                    // Sort alphabetically
                    return order === 'asc' ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
                });
                sortedRows.forEach(row => document.querySelector('.tables table').appendChild(row));
            };

            // Attach sort functionality to each sort icon
            document.getElementById('scholarAsc').addEventListener('click', () => sortTable(2, 'asc'));
            document.getElementById('scholarDesc').addEventListener('click', () => sortTable(2, 'desc'));

            document.getElementById('lNameAsc').addEventListener('click', () => sortTable(3, 'asc'));
            document.getElementById('lNameDesc').addEventListener('click', () => sortTable(3, 'desc'));

            document.getElementById('fNameAsc').addEventListener('click', () => sortTable(4, 'asc'));
            document.getElementById('fNameDesc').addEventListener('click', () => sortTable(4, 'desc'));

            document.getElementById('schoolAsc').addEventListener('click', () => sortTable(5, 'asc'));
            document.getElementById('schoolDesc').addEventListener('click', () => sortTable(5, 'desc'));

            // Status sort functionality
            statusSort.addEventListener('change', () => {
                const selectedStatus = statusSort.value.toLowerCase();
                tableRows.forEach(row => {
                    const status = row.querySelector('td:nth-child(6)').textContent.toLowerCase();
                    if (selectedStatus === 'default' || status === selectedStatus || selectedStatus === 'all') {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Toggle action buttons visibility based on checkbox selection
            const toggleActionButtons = () => {
                const anyChecked = Array.from(individualCheckboxes).some(checkbox => checkbox.checked);
                actionButtons.style.display = anyChecked ? 'block' : 'none';
            };

            // Select all functionality
            selectAllCheckbox.addEventListener('change', () => {
                const isChecked = selectAllCheckbox.checked;
                individualCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                toggleActionButtons();
            });

            // Individual checkbox select functionality
            individualCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    if (!checkbox.checked) {
                        selectAllCheckbox.checked = false;
                    }
                    toggleActionButtons();
                });
            });

            // Delete selected rows (you can add your own logic here)
            window.deleteSelected = () => {
                individualCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        checkbox.closest('tr').remove();
                    }
                });
                toggleActionButtons();
            };

            // Download selected rows (you can add your own logic here)
            window.downloadSelected = () => {
                individualCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const docName = checkbox.closest('tr').querySelector('td:nth-child(3)').textContent;
                        console.log(`Download document: ${docName}`);
                    }
                });
            };
        });

        
        //STATUS COLOR CODE
        document.addEventListener('DOMContentLoaded', () => {
            const statusCells = document.querySelectorAll('.statusColor');
            statusCells.forEach(cell => {
                switch (cell.textContent.trim()) {
                    case 'ACTIVE':
                        cell.style.color = 'green';
                        break;
                    case 'PROBATION':
                        cell.style.color = 'orange';
                        break;
                    case 'DROPPED':
                        cell.style.color = 'red';
                        break;
                    case 'LOA':
                        cell.style.color = 'yellow';
                        break;
                    case 'GRADUATED':
                        cell.style.color = 'blue';
                        break;
                    default:
                        cell.style.color = 'black';
                        break;
                }
            });
        });

        //ADD SCHOLAR
        function openAdd() {
            document.getElementById("addOverlay").style.display = "block";
        }
        function closeAdd() {
            document.getElementById("addOverlay").style.display = "none";
        }
        function submitForm() {
            closeAdd();
        }

        //BATCH UPLOAD
        function openBatch() {
            document.getElementById("batchOverlay").style.display = "block";
        }
        function closeBatch() {
            document.getElementById("batchOverlay").style.display = "none";
        }
        function submitForm() {
            closeBatch();
        }

        //VIEW MODAL
        function openPrev() {
            document.getElementById("viewOverlay").style.display = "block";
        }
        function closePrev() {
            document.getElementById("viewOverlay").style.display = "none";
        }
        function submitForm() {
            closeAdd();
        }
    </script>
</body>
</html>
