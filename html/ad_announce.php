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
                <div class="notif">
                    <ion-icon name="notifications-outline" onclick="openOverlay()"></ion-icon>
                </div>

                <a class="user" href="ad_settings.php">
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

            <div class="actions" style="display: none;">
                <button id="deleteBtn" class="action-btn" onclick="deleteSelected()">
                    <ion-icon name="trash-outline"></ion-icon>
                </button>
            </div>

            <div class="sort">
                <select id="statusSort">
                    <option value="" disabled selected>Status</option>
                    <option value="all">All</option>
                    <option value="resolved">Active</option>
                    <option value="progress">Inactive</option>
                </select>
            </div>
            
            <form>
                <button type="button" class="btnAdd" onclick="openModal('announceModal')"> Add Announcement </button>
            </form> 
        </div> <br>

        <div class="tables">
            <table>
                <tr style="font-weight: bold;">
                    <th> <input type="checkbox" id="selectAll" name="selected_rows[]"> </th>
                    <th style="width:59%"> 
                        <div class="title-header">
                            Title
                            <div class="sort-icons">
                                <a href="#" id="scholarAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="scholarDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div> 
                    </th>
                    <th style="width:12%"> 
                        <div class="startDate-header" style="justify-content: center">
                            Start Date
                            <div class="sort-icons">
                                <a href="#" id="scholarAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="scholarDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div> 
                    </th>
                    <th style="width:12%"> 
                        <div class="endDate-header" style="justify-content: center">
                            End Date
                            <div class="sort-icons">
                                <a href="#" id="scholarAsc" class="sort-icon" data-order="asc"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                <a href="#" id="scholarDesc" class="sort-icon" data-order="desc"><ion-icon name="chevron-down-outline"></ion-icon></a>
                            </div>
                        </div>
                    </th>
                    <th style="width:12%"> Status </th>
                    <th style="width:5%"> Action </th>
                </tr>
                <tr> 
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:59%"> Application for Batch 23 </td>
                    <td style="width:12%; text-align: center"> 2024-08-18 </td>
                    <td style="width:12%; text-align: center"> 2024-06-23 </td>
                    <td style="width:12%; text-align: center" class="statusColor"> ACTIVE </td>
                    <td style="width:100%; justify-content:center" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span onclick="openPrev(this)"> <ion-icon name="eye-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Edit </div>
                            <span onclick="openEdit(this)"> <ion-icon name="create-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip">Delete</div>
                            <span onclick="openDelete(this)"> <ion-icon name="trash-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
                <tr> 
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:59%"> Contract Signing </td>
                    <td style="width:12%; text-align: center"> 2024-06-02 </td>
                    <td style="width:12%; text-align: center"> 2024-06-07 </td>
                    <td style="width:12%; text-align: center" class="statusColor"> ACTIVE </td>
                    <td style="width:100%; justify-content:center" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span onclick="openPrev(this)"> <ion-icon name="eye-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Edit </div>
                            <span onclick="openEdit(this)"> <ion-icon name="create-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip">Delete</div>
                            <span onclick="openDelete(this)"> <ion-icon name="trash-outline"></ion-icon> </span>
                        </div>
                    </td>
                </tr>
                <tr> 
                    <td><input type='checkbox' name='selected_rows[]'></td>
                    <td style="width:59%"> Results for Batch 27 </td>
                    <td style="width:12%; text-align: center"> 2024-05-21 </td>
                    <td style="width:12%; text-align: center"> 2024-06-01 </td>
                    <td style="width:12%; text-align: center" class="statusColor"> INACTIVE </td>
                    <td style="width:100%; justify-content:center" class="wrap"> 
                        <div class="icon">
                            <div class="tooltip"> View </div>
                            <span onclick="openPrev(this)"> <ion-icon name="eye-outline"></ion-icon> </span>
                        </div>
                        <div class="icon">
                            <div class="tooltip"> Edit </div>
                            <span onclick="openEdit(this)"> <ion-icon name="create-outline"></ion-icon> </span>
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
        <?php include 'page.php'; ?>
    </div>


    <!-- ADD ANNOUNCEMENTS MODAL -->
    <div id="announceModal" class="announce">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="announce-content">
                <div class="infos">
                    <h1>Publish Announcement</h1>
                    <span class="close" onclick="closeModal('announceModal')">&times;</span>
                </div>
                <br><br>

                <div class="announceTitle">
                    <h3>Announcement Title</h3>
                    <input type="text" name="title"> 
                </div> <br>

                <div class="announceImg">
                    <h3>Upload an Image</h3>
                    <label for="choose-file1" class="custom-file-upload">
                        <ion-icon name="share-outline"> </ion-icon> Upload Image
                    </label>
                    <input name="cover" type="file" id="choose-file1" accept="image/png, image/gif, image/jpeg" style="display: none;" /> 
                </div> <br>

                <div class="announceDetail">
                    <h3>Announcement Details</h3>
                    <textarea name="content" rows="2" cols="50"> </textarea>
                </div> <br>

                <div class="announceDate">
                    <h3>Start Date</h3>
                    <input type="date" name="startDate" required> <br> <br> 

                    <h3>End Date</h3>
                    <input type="date" name="endDate" required>
                </div> <br>

                <div class="batch"> 
                    <h3>Batch</h3>
                    <form>
                        <input type="radio" id="all" name="batches" value="all">
                        <label for="all">All Batches</label> <br>
                            
                        <input type="radio" id="batch" name="batches" value="batch">
                        <label for="batch" onclick="showInput('batch')">By Batch</label>
                        <br> <br>
                        <div id="inputField" class="hideText" style="display: none;">
                            <label for="textInput" style="font-weight: bold;">Enter Batch ID:</label>
                            <input type="text" id="textInput">
                        </div>
                    </form>
                </div>

                <div class="btn">
                    <button type="submit" name="add_ann" class="publish-button"> Publish </button>
                </div> <br>
            </div>
        </form>
    </div>

    <!-- VIEW MODAL -->
    <div id="viewOverlay" class="overlay">
        <div class="overlay-content">
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
    <div id="EditModal" class="announce">
        <div class="announce-content">
            <div class="infos">
                <h1>Edit Announcement</h1>
                <span class="closeOverlay" onclick="closeEdit()">&times;</span>
            </div>
            <br><br>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" id="edit-id" name="id">
                <div class="announceTitle">
                    <h3>Announcement Title</h3>
                    <input type="text" id="edit-title" name="title">
                </div> <br>

                <div class="announceImg">
                    <h3>Upload an Image</h3>

                    <label for="choose-file1" class="custom-file-upload">
                        <ion-icon name="share-outline"> </ion-icon> Upload Image
                    </label>
                    <input name="cover" type="file" id="choose-file2" accept="image/png, image/gif, image/jpeg" style="display: none;" /> 
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
        // SORT ICON
        document.addEventListener('DOMContentLoaded', function () {
            // Function to sort table rows
            function sortTable(table, column, order) {
                const tbody = table.tBodies[0];
                const rows = Array.from(tbody.rows); // Include all rows including the header row
                const compare = (rowA, rowB) => {
                    const cellA = rowA.cells[column].innerText.trim();
                    const cellB = rowB.cells[column].innerText.trim();
                    
                    if (!isNaN(Date.parse(cellA)) && !isNaN(Date.parse(cellB))) {
                        return order === 'asc' ? new Date(cellA) - new Date(cellB) : new Date(cellB) - new Date(cellA);
                    } else if (!isNaN(cellA) && !isNaN(cellB)) {
                        return order === 'asc' ? cellA - cellB : cellB - cellA;
                    } else {
                        return order === 'asc' ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
                    }
                };

                rows.slice(1).sort(compare).forEach(row => tbody.appendChild(row)); // Exclude header row
            }

            // Add event listeners to sort icons
            document.querySelectorAll('.sort-icon').forEach(icon => {
                icon.addEventListener('click', function (e) {
                    e.preventDefault();
                    const table = icon.closest('table');
                    const column = Array.from(icon.closest('tr').children).indexOf(icon.closest('th'));
                    const order = icon.getAttribute('data-order');

                    // Toggle order for the next click
                    const newOrder = order === 'asc' ? 'desc' : 'asc';
                    icon.setAttribute('data-order', newOrder);

                    // Sort the table
                    sortTable(table, column, order);
                });
            });
        });

        // SHOW/HIDE ICONS BASED ON CHECKBOX SELECTION
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('input[name="selected_rows[]"]');
            const selectAllCheckbox = document.getElementById('selectAll');
            const actionButtons = document.querySelector('.actions');
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleActionButtons);
            });

            selectAllCheckbox.addEventListener('change', function() {
                checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
                toggleActionButtons();
            });

            function toggleActionButtons() {
                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                actionButtons.style.display = anyChecked ? 'block' : 'none';
            }
        });

        // STATUS COLOR CODE
        document.addEventListener('DOMContentLoaded', () => {
            const statusCells = document.querySelectorAll('.statusColor');
            statusCells.forEach(cell => {
                switch (cell.textContent.trim()) {
                    case 'ACTIVE':
                        cell.style.color = 'green';
                        break;
                    case 'INACTIVE':
                        cell.style.color = 'red';
                        break;
                    default:
                        cell.style.color = 'black';
                        break;
                }
            });
        });
    

        //ADD 
        function openModal(announceModal) {
            var modal = document.getElementById(announceModal);
            modal.style.display = "block";
        }
        function closeModal(announceModal) {
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
    
        // VIEW
        function openPrev(elem) {
            document.getElementById("view-title").innerText = elem.getAttribute("data-title");
            document.getElementById("view-img").src = '../assets/' + elem.getAttribute("data-img");
            document.getElementById("view-content").innerText = elem.getAttribute("data-content");
            document.getElementById("viewOverlay").style.display = "block";
        }
        function closePrev() {
            document.getElementById("viewOverlay").style.display = "none";
        }

        //EDIT
        function openEdit(elem) {
            document.getElementById("edit-id").value = elem.getAttribute("data-id");
            document.getElementById("edit-title").value = elem.getAttribute("data-title");
            document.getElementById("edit-content").value = elem.getAttribute("data-content");
            document.getElementById("edit-startDate").value = elem.getAttribute("data-st_date");
            document.getElementById("edit-endDate").value = elem.getAttribute("data-end_date");
            document.getElementById("EditModal").style.display = "block";
        }
        function closeEdit() {
            document.getElementById("EditModal").style.display = "none";
        }
    </script>
</body>
</html>