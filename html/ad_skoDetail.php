<?php 
    include_once('../functions/general.php'); 
    include('../functions/scholar_view.php');
    include('../functions/scholar_fx.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio Iskolar</title>
    <link rel="icon" type="image/x-icon" href="images/pio-logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/ad_skoDetail.css">
    <link rel="stylesheet" href="css/confirm.css">
</head>

<body>
    <!-- SIDEBAR - ad_navbar.php -->
    <?php include 'ad_navbar.php'; ?>


    <!-- TOP BAR -->
    <br class="main2">
        <div class="topBar">
            <a href="./ad_scholar.php" style="text-decoration:none">
            <button class="headerBack" id="clickableIcon">
                <ion-icon name="chevron-back-outline"></ion-icon>
                <h1>Back</h1>
            </button>
            </a>

            <div class="headerRight">
                <a class="user" href="ad_settings.php">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <!-- TOP NAV -->
        <div class="details"><center> 
            <?php scholarFull(); ?>
        </center></div>

        <?php scholarDetail();?>
        
        <div></div>

        <div class="accordion">
            <div class="table">
                <button class="tblTitle active">
                    <span>
                        PLV 2024-2025 1ST SEMESTER
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>

                <div class="tblContent" style="display:block;">
                    <table>
                        <tr style="font-weight: bold;">
                            <th> <input type="checkbox" id="selectAll" name="selected_rows[]"> </th>
                            <th style="width:10%"> Type </th>
                            <th style="width:65%">
                                <div class="docName-header" id="sortDocName" style="cursor: pointer;">
                                    Document Name
                                    <i id="docNameSortIcon" class="fa fa-sort"></i>
                                </div>
                            </th>
                            <th style="width:10%"> Status </th>
                            <th style="width:10%">
                                <div class="date-header" id="sortDate" style="justify-content: center; cursor: pointer;">
                                    Date
                                    <i id="dateSortIcon" class="fa fa-sort"></i>
                                </div>
                            </th>
                            <th style="width:5%"> Action </th>
                        </tr>
                        <tbody id="docTableBody">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table">
                <button class="tblTitle active">
                    <span>
                        PLV 2024-2025 2ND SEMESTER
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>

                <div class="tblContent" style="display:block;">
                    <table>
                        <tr style="font-weight: bold;">
                            <th> <input type="checkbox" id="selectAll" name="selected_rows[]"> </th>
                            <th style="width:10%"> Type </th>
                            <th style="width:65%">
                                <div class="docName-header" id="sortDocName" style="cursor: pointer;">
                                    Document Name
                                    <i id="docNameSortIcon" class="fa fa-sort"></i>
                                </div>
                            </th>
                            <th style="width:10%"> Status </th>
                            <th style="width:10%">
                                <div class="date-header" id="sortDate" style="justify-content: center; cursor: pointer;">
                                    Date
                                    <i id="dateSortIcon" class="fa fa-sort"></i>
                                </div>
                            </th>
                            <th style="width:5%"> Action </th>
                        </tr>
                        <tbody id="docTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--
            <br> <br>
            <table id="remarksTable" class="table-container">
                <tr>
                    <th class="details2">REMARKS 
                        <ion-icon name="pencil-outline" onclick="toggleEdit('remarksTable')"></ion-icon>
                    </th>
                </tr>
                <tr>
                    <td><input type="text" class="input3"></td>
                </tr>
            </table>  
        </div> <br>  
        -->
    </br>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        //ACCORDION
        var acc = document.getElementsByClassName("tblTitle active");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                /* Toggle between adding and removing the "active" class,
                to highlight the button that controls the panel */
                this.classList.toggle("active");

                /* Toggle between hiding and showing the active panel */
                var tblContent = this.nextElementSibling;
                if (tblContent.style.display === "block") {
                    tblContent.style.display = "none";
                } else {
                    tblContent.style.display = "block";
                }
            });
        }


        // UPLOAD
        function openUpload() {
            document.getElementById("uploadOverlay").style.display = "block";
        }
        function closeUpload() {
            document.getElementById("uploadOverlay").style.display = "none";
        }


        // EDIT TABLE
        function toggleEdit(tableId) {
            const table = document.getElementById(tableId);
            const inputs = table.querySelectorAll('input[type="text"], textarea');
            const icon = table.querySelector('ion-icon');

            inputs.forEach(input => {
                input.disabled = !input.disabled;
            });

            if (icon.name === 'create-outline') {
                icon.name = 'close-outline';
            } else {
                icon.name = 'create-outline';
            }

            let saveButton = table.querySelector('.save-button');
            if (!saveButton) {
                saveButton = document.createElement('button');
                saveButton.textContent = 'Save';
                saveButton.classList.add('save-button');
                saveButton.onclick = () => {
                    inputs.forEach(input => input.disabled = true);
                    icon.name = 'create-outline';
                    saveButton.remove();
                    openSave();
                };
                table.appendChild(saveButton);
            } else {
                saveButton.remove();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.getElementById('editButton');
            const cancelButton = document.getElementById('cancelButton');
            const saveButton = document.getElementById('saveButton');
            const inputs = document.querySelectorAll('input[readonly], select[disabled]');

            editButton.addEventListener('click', function() {
                inputs.forEach(input => {
                    input.removeAttribute('readonly');
                    input.removeAttribute('disabled');
                });
                editButton.style.display = 'none';
                cancelButton.style.display = 'block';
                saveButton.style.display = 'block';
            });

            cancelButton.addEventListener('click', function() {
                inputs.forEach(input => {
                    input.setAttribute('readonly', 'readonly');
                    input.setAttribute('disabled', 'disabled');
                });
                editButton.style.display = 'inline';
                cancelButton.style.display = 'none';
                saveButton.style.display = 'none';
                // Optionally, reload the page to revert changes
                location.reload();
            });

            saveButton.addEventListener('click', function() {
                document.getElementById('profileForm').submit();
            });
        });
    </script>
</body>
</html>
