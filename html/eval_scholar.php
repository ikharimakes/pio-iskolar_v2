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
    <!-- SIDEBAR - eval_navbar.php -->
    <?php include 'eval_navbar.php'; ?>
    

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

                <a class="user">
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
            </div>

            <div class="sort">
                <select id="statusSort">
                    <option value="" disabled selected>Status</option>
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="probation">Probation</option>
                    <option value="dropped">Dropped</option>
                    <option value="loa">LOA</option>
                    <option value="graduated">Graduated</option>
                </select>
            </div>
        </div>


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
                    <th style="width:36%">
                        <div class="school-header">
                            School
                            <div class="sort-icons">
                                <a href="#" id="schoolAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="schoolDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div>
                    </th>
                    <th style="width:12%"> Status </th>
                    <th style="width:5%"> Action </th>
                </tr>
                <tr>
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:10%; text-align: center;"> 21-2321 </td>
                    <td style="width:12%"> ADRIANO </td>
                    <td style="width:25%"> JESSICA RAYE </td>
                    <td style="width:36%">PAMANTASAN NG LUNGSOD NG VALENZUELA </td>
                    <td style="width:12%; text-align: center;" class="statusColor"> ACTIVE </td>
                    <td style="width:100%; justify-content:center" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span> <a href="eval_skoDetail.php"> <ion-icon name="eye-outline"></ion-icon> </a> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download </div>
                                <span> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:10%; text-align: center;"> 21-0601 </td>
                    <td style="width:12%"> HIDALGO </td>
                    <td style="width:25%"> MAIKA JASMINE </td>
                    <td style="width:36%"> PAMANTASAN NG LUNGSOD NG MAYNILA </td>
                    <td style="width:12%; text-align: center;" class="statusColor"> GRADUATED </td>
                    <td style="width:100%; justify-content:center" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span> <a href="eval_skoDetail.php"> <ion-icon name="eye-outline"> </ion-icon> </a> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download </div>
                                <span> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:10%; text-align: center;"> 21-2021 </td>
                    <td style="width:12%"> MARCOS </td>
                    <td style="width:25%"> DANNAH LEI </td>
                    <td style="width:36%"> 	UNIVERSITY OF THE PHILIPPINES DILIMAN </td>
                    <td style="width:12%; text-align: center;" class="statusColor"> PROBATION </td>
                    <td style="width:100%; justify-content:center" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span> <a href="eval_skoDetail.php"> <ion-icon name="eye-outline"></ion-icon> </a> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download </div>
                                <span> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        
        <!-- PAGINATION - page.php -->
        <?php include 'page.php'; ?>
    </div>
    

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
    </script>
</body>
</html>
