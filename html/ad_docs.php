<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio Iskolar</title>
    <link rel="icon" type="image/x-icon" href="images/pio-logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/ad_docs.css">
    <link rel="stylesheet" href="css/confirm.css">
</head>
<body>
    <!-- SIDEBAR - ad_nav.php -->
    <?php include 'ad_navbar.php';?>
    

    <!-- TOP BAR -->
    <div class="main">
        <div class="topBar">
            <div class="headerName">
                <h1>Pending Documents</h1>
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


        <!-- DOCUMENTS -->
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
                    <th style="width:50%">
                        <div class="docName-header">
                            Document Name
                            <div class="sort-icons">
                                <a href="#" id="fNameAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="fNameDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div>
                    </th>
                    <th style="width:10%"> 
                        <div class="date-header" style="justify-content: center">
                            Date
                            <div class="sort-icons">
                                <a href="#" id="fNameAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="fNameDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div> 
                    </th>
                    <th style="width:10%"> 
                        <div class="type-header" style="justify-content: center">
                            Type
                            <div class="sort-icons">
                                <a href="#" id="fNameAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="fNameDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div>
                    </th>
                    <th style="width:10%"> Status </th>
                    <th style="width:12%"> Action </th>
                </tr>
                <tr> 
                    <td><input type='checkbox' name='selected_rows[]'></td>
					<td style="width:10%; text-align: center;"> 21-2321 </td>
                    <td style="width:50%"> Adriano,JessicaRaye_1stYear_COR.pdf </td>
                    <td style="width:10%; text-align: center;"> 07/29/2024 </td>
                    <td style="width:10%; text-align: center;"> COR </td>
                    <td style="width:10%; text-align: center;" class="statusColor"> PENDING</td>
                    <td style="text-align: right;" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span onclick="openPrev(this)"> <ion-icon name="eye-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download </div>
                                <span> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Approve</div>
                            <span onclick="openApprove(this)"> <ion-icon name="checkmark-circle-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Decline</div>
                            <span onclick="openDecline(this)" > <ion-icon name="close-circle-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip">Delete</div>
                            <span onclick="openDelete(this)"> <ion-icon name="trash-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
                <tr> 
                    <td><input type='checkbox' name='selected_rows[]'></td>
					<td style="width:10%; text-align: center;"> 21-2321 </td>
                    <td style="width:50%"> Adriano,JessicaRaye_1stYear_Grades.pdf </td>
                    <td style="width:10%; text-align: center;"> 08/26/2024 </td>
                    <td style="width:10%; text-align: center;"> GRADES </td>
                    <td style="width:10%; text-align: center;" class="statusColor"> PENDING</td>
                    <td style="text-align: right;" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span onclick="openPrev(this)"> <ion-icon name="eye-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download </div>
                                <span> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Approve</div>
                            <span onclick="openApprove(this)"> <ion-icon name="checkmark-circle-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Decline</div>
                            <span onclick="openDecline(this)" > <ion-icon name="close-circle-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip">Delete</div>
                            <span onclick="openDelete(this)"> <ion-icon name="trash-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
                <tr> 
                    <td><input type='checkbox' name='selected_rows[]'></td>
					<td style="width:10%; text-align: center;"> 21-2321 </td>
                    <td style="width:50%"> Adriano,JessicaRaye_1stYear_SC.pdf </td>
                    <td style="width:10%; text-align: center;"> 07/23/2024 </td>
                    <td style="width:10%; text-align: center;"> SC </td>
                    <td style="width:10%; text-align: center;" class="statusColor"> PENDING</td>
                    <td style="text-align: right;" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span onclick="openPrev(this)"> <ion-icon name="eye-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Download </div>
                                <span> <ion-icon name="download-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Approve</div>
                            <span onclick="openApprove(this)"> <ion-icon name="checkmark-circle-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Decline</div>
                            <span onclick="openDecline(this)" > <ion-icon name="close-circle-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip">Delete</div>
                            <span onclick="openDelete(this)"> <ion-icon name="trash-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        

        <!-- PAGINATION - page.php -->
        <?php include 'page.php';?>
    </div>


    <!-- VIEW MODAL -->
    <div id="viewOverlay" class="view">
        <div class="view-content">
            <h2>Document Name</h2>
            <span class="closeView" onclick="closePrev()">&times;</span>
            
            <br><br>
            <form id="updateForm" method="post" action="">
                <input type="hidden" id="update-doc_id" name="doc_id">

                <div class="status">
                    <h4>Status:</h4>
                    <label>
                        <input type="radio" name="status" value="APPROVED" id="approveRadio"> APPROVE
                    </label>
                    <label>
                        <input type="radio" name="status" value="DECLINED" id="declineRadio"> DECLINE
                    </label>
                </div>

                <div id="declineOptions" style="display: none;">
                    <div class="decline">
                        <h4>Reason for Declining:</h4>
                        <select name="declineReason" id="declineReasonSelect">
                            <option value="" disabled selected>Select a reason</option>
                            <option value="CORRUPTED FILE">CORRUPTED FILE</option>
                            <option value="NOT LEGIBLE/READABLE">NOT LEGIBLE/READABLE</option>
                            <option value="WRONG DOCUMENT">WRONG DOCUMENT</option>
                            <option value="OTHER">OTHER</option>
                        </select>
                    </div>

                    <div id="otherReason" style="display: none;" class="others">
                        <h4>Enter other reasons:</h4>
                        <textarea name="reason" id="denialReasonText" placeholder="Type your reason here"></textarea>
                    </div>
                </div> <br>

                <center>
                    <button id="updateButton" type="submit" name="update" class="btnSave">Save</button>
                </center>
            </form>

             <br> <hr> <br>
            <center>
                <div class="pdfViewer" id="pdfViewer"></div>
            </center>
        </div>
    </div>

    <!-- APPROVE/DECLINE/DELETE MODAL - confirm.php -->
    <?php include('confirm.php');?>
    
    <!-- NOTIFICATION -->
    <?php include('notiF.php');?>


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

            // Sort functionality
            const sortByColumn = (columnIndex, order) => {
                const sortedRows = Array.from(tableRows).sort((a, b) => {
                    let aText = a.querySelector(`td:nth-child(${columnIndex})`).textContent.trim();
                    let bText = b.querySelector(`td:nth-child(${columnIndex})`).textContent.trim();

                    // Parse dates if the column is the Date column
                    if (columnIndex === 4) {
                        aText = new Date(aText);
                        bText = new Date(bText);
                    }

                    return order === 'asc' ? aText > bText ? 1 : -1 : aText < bText ? 1 : -1;
                });

                sortedRows.forEach(row => document.querySelector('.tables table').appendChild(row));
            };

            // Toggle sort icons
            const toggleSortIcons = (iconAsc, iconDesc, isAscending) => {
                document.querySelectorAll('.sort-icon').forEach(icon => {
                    icon.classList.remove('active');
                });

                if (isAscending) {
                    iconAsc.classList.add('active');
                } else {
                    iconDesc.classList.add('active');
                }
            };

            // Date sort event listeners
            document.getElementById('fNameAsc').addEventListener('click', function () {
                sortByColumn(4, 'asc');
                toggleSortIcons(this, document.getElementById('fNameDesc'), true);
            });

            document.getElementById('fNameDesc').addEventListener('click', function () {
                sortByColumn(4, 'desc');
                toggleSortIcons(this, document.getElementById('fNameAsc'), false);
            });

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

        //STATUS COLOR CODED
        document.addEventListener('DOMContentLoaded', () => {
            const statusCells = document.querySelectorAll('.statusColor');
            statusCells.forEach(cell => {
                switch (cell.textContent.trim()) {
                    case 'APPROVED':
                        cell.style.color = 'green';
                        break;
                    case 'DECLINED':
                        cell.style.color = 'red';
                        break;
                    case 'PENDING':
                        cell.style.color = 'orange';
                        break;
                }
            });
        });

        // VIEW MODAL
        function openPrev() {
            document.getElementById('viewOverlay').style.display = 'block';
            const docName = event.target.closest('tr').querySelector('td').innerText;
            document.getElementById('view-doc_name').innerText = docName;
        }

        function closePrev() {
            document.getElementById('viewOverlay').style.display = 'none';
        }

        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('viewOverlay')) {
                closePrev();
            }
        });
    </script>
</body>
</html>