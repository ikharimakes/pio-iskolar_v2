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
</head>

<body>
    <!-- SIDEBAR - eval_navbar.php -->
    <?php include 'eval_navbar.php'; ?>
    

    <!-- TOP BAR -->
    <div class="main">
        <div class="topBar">
            <div class="headerName">
                <h1>Reports</h1>
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

            <div class="actions" style="display: none;">
                <button id="downloadBtn" class="action-btn" onclick="downloadSelected()">
                    <ion-icon name="download-outline"></ion-icon>
                </button>
            </div>

            <div class="sort">
                <select id="statusSort">
                    <option value="" disabled selected>Status</option>
                    <option value="all">All</option>
                    <option value="resolved">Completed</option>
                    <option value="progress">Reviewed</option>
                    <option value="pending">Closed</option>
                </select>
            </div>
        </div>


        <!-- TABLE -->
        <div class="tables">
            <table>
                <tr style="font-weight: bold;">
                    <th> <input type="checkbox" id="selectAll" name="selected_rows[]"> </th>
                    <th style="width:10%"> 
                        <div class="batch-header" style="justify-content: center">
                            Batch No.
                            <div class="sort-icons">
                                <a href="#" id="scholarAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="scholarDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div> 
                    </th>
                    <th style="width:60%"> 
                        <div class="name-header">
                            Report Name
                            <div class="sort-icons">
                                <a href="#" id="scholarAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="scholarDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div> 
                    </th>
                    <th style="width:15%">
                        <div class="date-header" style="justify-content: center">
                            Date
                            <div class="sort-icons">
                                <a href="#" id="scholarAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="scholarDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div> 
                    </th>
                    <th style="width:10%"> Status </th>
                    <th style="width:5%"> Actions </th>
                </tr>
                <tr> 
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:10%; text-align: center;"> 29 </td>
                    <td style="width:60%"> Scholar Profile and Requirements Report for Batch 29 - 2 Semester of S.Y. 2024-2025 </td>
                    <td style="width:15%; text-align: center;"> 07/29/2024 </td>
                    <td style="width:10%; text-align: center;" class="statusColor"> REVIEWED </td>
                    <td style="width:100%; justify-content:center" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span onclick="openProfile(this)"> <ion-icon name="eye-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download </div>
                            <span> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
                <tr> 
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:10%; text-align: center;"> 28 </td>
                    <td style="width:60%"> 	Scholar Status Report for Batch 28 - S.Y. 2024-2025 </td>
                    <td style="width:15%; text-align: center;"> 05/30/2024 </td>
                    <td style="width:10%; text-align: center;" class="statusColor"> CLOSED </td>
                    <td style="width:100%; justify-content:center" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span onclick="openProfile(this)"> <ion-icon name="eye-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download </div>
                            <span> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
                <tr> 
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:10%; text-align: center;"> 22 </td>
                    <td style="width:60%"> Scholar Profile and Requirements Report for Batch 22 - 2 Semester of S.Y. 2024-2025 </td>
                    <td style="width:15%; text-align: center;"> 03/26/2024 </td>
                    <td style="width:10%; text-align: center;" class="statusColor"> COMPLETED </td>
                    <td style="width:100%; justify-content:center" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span onclick="openStatus(this)"> <ion-icon name="eye-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download </div>
                            <span> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>


        <!-- PAGINATION -->
        <?php include 'page.php';?>
    </div>


    <!-- SCHOLAR STATUS MODAL -->
    <div id="statusModal" class="statusReport">
        <div class="statusReport-content">
            <span class="close">&times;</span>
            <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>
            SCHOLAR STATUS REPORT <br>
            S.Y. [SCHOOL YEAR]</h3> <br>
            
            Batch Number: <strong>[Batch Number]</strong>

            <p> This report provides an overview of the current status of scholars under the Dr. Pio Valenzuela Scholarship Program for the school year <strong>[School Year]</strong>. As of <strong>[Date]</strong>, there are a total of <strong>[Total Number of Scholars]</strong> scholars enrolled in the program for Batch Number <strong>[Batch Number]</strong>. The table below presents the current status of scholars under the Dr. Pio Valenzuela Scholarship Program, along with the total number of scholars based on their status: </p>
            <br>
            Total Active Scholars: <strong>1</strong> <br>
            Total Dropped Scholars: <strong>1</strong> <br>
            Total Scholars on Leave of Absence: <strong>1</strong> <br>
            Total Graduated Scholars: <strong>1</strong> <br> <br>

            <table>
                <tr>
                    <th class="status-header">Batch ID</th>
                    <th class="status-header">Last Name</th> 
                    <th class="status-header">First Name</th> 
                    <th class="status-header">Middle Inital</th> 
                    <th class="status-header">Status</th> 
                </tr>
                <tr>
                    <td class="status-details">21-0001</td>
                    <td class="status-details">Marcos</td>
                    <td class="status-details">Dannah Lei</td>
                    <td class="status-details">R</td>
                    <td class="status-details">Active</td>
                </tr>
                <tr>
                    <td class="status-details">21-0002</td>
                    <td class="status-details">Jacinto</td>
                    <td class="status-details">Alexis John Rovic</td>
                    <td class="status-details"></td>
                    <td class="status-details">Leave of Absence</td>
                </tr>
                <tr>
                    <td class="status-details">21-0003</td>
                    <td class="status-details">Hidalgo</td>
                    <td class="status-details">Maika Jasmine</td>
                    <td class="status-details">A</td>
                    <td class="status-details">Graduated</td>
                </tr>
                <tr>
                    <td class="status-details">21-0004</td>
                    <td class="status-details">Adriano</td>
                    <td class="status-details">Jessica Raye</td>
                    <td class="status-details"></td>
                    <td class="status-details">Dropped</td>
                </tr>
            </table>
            <div class="nothing-follows">-----Nothing Follows-----</div>

            <br> <br>
            <button onclick="downloadForm()" class="button">DOWNLOAD</button>
        </div>
    </div>
        
    <div id="statusOverlay" class="statusReport">
        <div class="statusReport-content">
        <span class="closeEdit" onclick="closeStatus()">&times;</span>
            <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>
            SCHOLAR STATUS REPORT<br>
            S.Y. [SCHOOL YEAR]</h3> <br>
                
            Batch Number: <strong>[Batch Number]</strong>

            <p> This report provides an overview of the current status of scholars under the Dr. Pio Valenzuela Scholarship Program for the school year <strong>[School Year]</strong>. As of <strong>[Date]</strong>, there are a total of <strong>[Total Number of Scholars]</strong> scholars enrolled in the program for Batch Number <strong>[Batch Number]</strong>. The table below presents the current status of scholars under the Dr. Pio Valenzuela Scholarship Program, along with the total number of scholars based on their status: </p>
            <br>
            Total Active Scholars: <strong>1</strong> <br>
            Total Dropped Scholars: <strong>1</strong> <br>
            Total Scholars on Leave of Absence: <strong>1</strong> <br>
            Total Graduated Scholars: <strong>1</strong> <br>
            <br>

            <table>
                <tr>
                    <th class="status-header">Batch ID</th>
                    <th class="status-header">Last Name</th> 
                    <th class="status-header">First Name</th> 
                    <th class="status-header">Middle Inital</th> 
                    <th class="status-header">Status</th> 
                </tr>
                <tr>
                    <td class="status-details">21-0001</td>
                    <td class="status-details">Marcos</td>
                    <td class="status-details">Dannah Lei</td>
                    <td class="status-details">R</td>
                    <td class="status-details">Active</td>
                </tr>
                <tr>
                    <td class="status-details">21-0002</td>
                    <td class="status-details">Jacinto</td>
                    <td class="status-details">Alexis John Rovic</td>
                    <td class="status-details"></td>
                    <td class="status-details">Leave of Absence</td>
                </tr>
                <tr>
                    <td class="status-details">21-0003</td>
                    <td class="status-details">Hidalgo</td>
                    <td class="status-details">Maika Jasmine</td>
                    <td class="status-details">A</td>
                    <td class="status-details">Graduated</td>
                </tr>
                <tr>
                    <td class="status-details">21-0004</td>
                    <td class="status-details">Adriano</td>
                    <td class="status-details">Jessica Raye</td>
                    <td class="status-details"></td>
                    <td class="status-details">Dropped</td>
                </tr>
            </table>
            <div class="nothing-follows">-----Nothing Follows-----</div>

            <br> <br>
            <button onclick="downloadForm()" class="button">DOWNLOAD</button>
        </div>
    </div>

    <!-- SCHOLAR PROFILE MODAL -->
    <div id="profileModal" class="profileReport">
        <div class="profileReport-content">
            <span class="close">&times;</span>
            <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>
            SCHOLAR PROFILE AND REQUIREMENTS REPORT<br>
            [SEMESTER] Semester of S.Y. [SCHOOL YEAR]</h3><br>

            Batch Number: <strong>[Batch Number]</strong>

            <p> This report provides a comprehensive overview of the profile and current requirement status of scholars under the Dr. Pio Valenzuela Scholarship Program for the <strong>[Semester]</strong> Semester of S.Y. <strong>[School Year]</strong>. As of <strong>[Date]</strong>, there are a total of <strong>[Total Number of Scholars]</strong> scholars enrolled in the program for Batch Number <strong>[Batch Number]</strong>. The table below presents the profile of scholars and the current status of their requirements, along with the total the number of scholars who have completed their requirements, and the number of scholars with missing requirements. This report is crucial for monitoring the progress of scholars and ensuring that they meet the program's criteria and obligation. </p>
            <br>
                
            Total Number of Scholars: <strong>1</strong> <br>
            Total Number of Scholars with Complete Requirements: <strong>1</strong> <br>
            Total Number of Scholars Scholars with Missing Requirements: <strong>1</strong> <br> <br>

            <table>
                <tr>
                    <td colspan="2" class="profile-header">SCHOLAR PROFILE</th>
                    <td colspan="2" class="profile-header">S.Y. [School Year]<br>[Sem] SEMESTER REQUIREMENTS</th> 
                </tr>
                <tr>
                    <td class="profile-profile">CONTROL NUMBER</td>
                    <td class="profile-input"></td>
                    <td class="profile-profile2">COR</td>
                    <td class="profile-details"></td>
                </tr>
                <tr>
                    <td class="profile-profile">NAME</td>
                    <td class="profile-input"></td>
                    <td class="profile-profile2">GRADES</td>
                    <td class="profile-details"></td>
                </tr>
                <tr>
                    <td class="profile-profile">SCHOOL</td>
                    <td class="profile-input"></td>
                    <td class="profile-profile2" style="border-bottom: 2px solid black">SOCIAL CONTRACT</td>
                    <td class="profile-details"></td>
                </tr>
                <tr>
                    <td class="profile-profile">COURSE</td>
                    <td class="profile-input"></td>
                    <td colspan="2" class="profile-profile2" style="border:2px solid black">REMARKS</td>
                </tr>
                <tr>
                    <td class="profile-profile">ADDRESS</td>
                    <td class="profile-input"></td>
                    <td rowspan="3" colspan="3" class="profile-details"></td>
                </tr>
                <tr>
                    <td class="profile-profile">CONTACT NUMBER</td>
                    <td class="profile-input"></td>
                </tr>
                <tr>
                    <td class="profile-profile">EMAIL</td>
                    <td class="profile-input"></td>
                </tr>
            </table>
            <div class="nothing-follows">-----Nothing Follows-----</div>

            <br> <br>
            <button onclick="downloadForm()" class="button">DOWNLOAD</button>
        </div>
    </div>

    <div id="profileOverlay" class="profileReport">
        <div class="profileReport-content">
        <span class="closeEdit" onclick="closeProfile()">&times;</span>
            <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>
            SCHOLAR PROFILE AND REQUIREMENTS REPORT<br>
            [SEMESTER] Semester of S.Y. [SCHOOL YEAR]</h3><br>

            Batch Number: <strong>[Batch Number]</strong>

            <p> This report provides a comprehensive overview of the profile and current requirement status of scholars under the Dr. Pio Valenzuela Scholarship Program for the <strong>[Semester]</strong> Semester of S.Y. <strong>[School Year]</strong>. As of <strong>[Date]</strong>, there are a total of <strong>[Total Number of Scholars]</strong> scholars enrolled in the program for Batch Number <strong>[Batch Number]</strong>. The table below presents the profile of scholars and the current status of their requirements, along with the total the number of scholars who have completed their requirements, and the number of scholars with missing requirements. This report is crucial for monitoring the progress of scholars and ensuring that they meet the program's criteria and obligation. </p>
            <br>
                
            Total Number of Scholars: <strong>1</strong> <br>
            Total Number of Scholars with Complete Requirements: <strong>1</strong> <br>
            Total Number of Scholars Scholars with Missing Requirements: <strong>1</strong> <br> <br>

            <table>
                <tr>
                    <td colspan="2" class="profile-header">SCHOLAR PROFILE</th>
                    <td colspan="2" class="profile-header">S.Y. [School Year]<br>[Sem] SEMESTER REQUIREMENTS</th> 
                </tr>
                <tr>
                    <td class="profile-profile">CONTROL NUMBER</td>
                    <td class="profile-input"></td>
                    <td class="profile-profile2">COR</td>
                    <td class="profile-details"></td>
                </tr>
                <tr>
                    <td class="profile-profile">NAME</td>
                    <td class="profile-input"></td>
                    <td class="profile-profile2">GRADES</td>
                    <td class="profile-details"></td>
                </tr>
                <tr>
                    <td class="profile-profile">SCHOOL</td>
                    <td class="profile-input"></td>
                    <td class="profile-profile2" style="border-bottom: 2px solid black">SOCIAL CONTRACT</td>
                    <td class="profile-details"></td>
                </tr>
                <tr>
                    <td class="profile-profile">COURSE</td>
                    <td class="profile-input"></td>
                    <td colspan="2" class="profile-profile2" style="border:2px solid black">REMARKS</td>
                </tr>
                <tr>
                    <td class="profile-profile">ADDRESS</td>
                    <td class="profile-input"></td>
                    <td rowspan="3" colspan="3" class="profile-details"></td>
                </tr>
                <tr>
                    <td class="profile-profile">CONTACT NUMBER</td>
                    <td class="profile-input"></td>
                </tr>
                <tr>
                    <td class="profile-profile">EMAIL</td>
                    <td class="profile-input"></td>
                </tr>
            </table>
            <div class="nothing-follows">-----Nothing Follows-----</div>

            <br> <br>
            <button onclick="downloadForm()" class="button">DOWNLOAD</button>
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


    <!-- NOTIFICATION - notif.php -->
    <?php include 'notif.php'; ?>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
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

            // Sort functionality
            const sortTable = (columnIndex, order) => {
                const sortedRows = Array.from(tableRows).sort((a, b) => {
                    const aText = a.querySelector(`td:nth-child(${columnIndex})`).textContent.toLowerCase();
                    const bText = b.querySelector(`td:nth-child(${columnIndex})`).textContent.toLowerCase();
                    if (columnIndex === 4) {
                        return order === 'asc' ? new Date(aText) - new Date(bText) : new Date(bText) - new Date(aText);
                    }
                    return order === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
                });
                sortedRows.forEach(row => document.querySelector('.tables table').appendChild(row));
            };

            document.querySelectorAll('.sort-icons a').forEach(sortIcon => {
                sortIcon.addEventListener('click', (e) => {
                    e.preventDefault();
                    const order = sortIcon.getAttribute('data-order');
                    const columnIndex = sortIcon.closest('th').cellIndex + 1;
                    sortTable(columnIndex, order);
                });
            });

            // Status sort functionality
            statusSort.addEventListener('change', () => {
                const selectedStatus = statusSort.value.toLowerCase();
                tableRows.forEach(row => {
                    const status = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                    if (selectedStatus === 'all' || status === selectedStatus) {
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

            // Delete selected rows
            window.deleteSelected = () => {
                individualCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        checkbox.closest('tr').remove();
                    }
                });
                toggleActionButtons();
            };

            // Download selected rows
            window.downloadSelected = () => {
                individualCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const docName = checkbox.closest('tr').querySelector('td:nth-child(3)').textContent;
                        console.log(`Download document: ${docName}`);
                    }
                });
            };

            // STATUS COLOR CODED
            const statusCells = document.querySelectorAll('.statusColor');
            statusCells.forEach(cell => {
                switch (cell.textContent.trim()) {
                    case 'COMPLETED':
                        cell.style.color = 'green';
                        break;
                    case 'REVIEWED':
                        cell.style.color = 'purple';
                        break;
                    case 'CLOSED':
                        cell.style.color = 'gray';
                        break;
                }
            });
        });
    
    
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
        </script>
</body>
</html>