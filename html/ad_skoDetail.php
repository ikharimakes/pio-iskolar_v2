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
    <div class="main2">
        <div class="topBar">
            <a href="./ad_scholar.php" style="text-decoration:none">
            <button class="headerBack" id="clickableIcon">
                <ion-icon name="chevron-back-outline"></ion-icon>
                <h1>Back</h1>
            </button>
            </a>

            <div class="headerRight">
                <div class="notif">
                    <ion-icon name="notifications-outline" onclick="openOverlay()"></ion-icon>
                </div>

                <a class="user" href="#">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <!-- TOP NAV -->
        <div class="details"><center> 
            <h1> ADRIANO, JESSICA RAYE </h1> 

            <div class="topnav">
                <a href="ad_skoDetail.php">Scholar Details</a>
                <a href="ad_skoDocs.php">Documents</a>
            </div> 
        </center></div>


        <!-- SCHOLAR DETAILS -->
        <div class="profile">
            <div class="profile_name">
                <img src="images/profile.png" alt="Profile Picture"> <br>
            </div>

            <div class="profile-info">
                <table>
                    <tr>
                        <th>Scholar No.</th>
                        <td>01-2321</td>
                    </tr>
                    <tr>
                        <th>School</th>
                        <td>PAMANTASAN NG LUNGSOD NG VALENZUELA</td>
                    </tr>
                    <tr>
                        <th>Course</th>
                        <td>BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY</td>
                    </tr>
                    <tr>
                         <th>Scholar Status</th>
                        <td>ACTIVE</td>
                    </tr> 
                    <tr>
                        <th style="padding: 20px 0px"> </th>
                        <td style="padding: 20px 0px"> </td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>123 SAMPAGUITA STREET, MALINTA, VALENZUELA CITY</td>
                    </tr>
                    <tr>
                        <th>Contact</th>
                        <td>+63963821954</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>j**********@gmail.com</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <br> 
        <div class="table">
            <table id="documentsTable" class="table-container">
                <tr>
                    <th colspan="10" class="details2">DOCUMENTS 
                    <ion-icon name="create-outline" onclick="openUpload()"></ion-icon>
                    </th>
                </tr> 
                <tr>
                    <th rowspan="2" class="details2">ACADEMIC YEAR</th>
                    <th colspan="3" class="details2">1ST SEMESTER</th>
                    <th colspan="3" class="details2">2ND SEMESTER</th>
                    <th colspan="3" class="details2">3RD SEMESTER</th>
                </tr>
                <tr>
                    <th class="details2">COR</th>
                    <th class="details2">GRADES</th>
                    <th class="details2">CONTRACT</th>
                    <th class="details2">COR</th>
                    <th class="details2">GRADES</th>
                    <th class="details2">CONTRACT</th>
                    <th class="details2">COR</th>
                    <th class="details2">GRADES</th>
                    <th class="details2">CONTRACT</th>
                </tr>
                <tr>
                    <th class="details2">2023-2024</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                </tr>
                <tr>
                    <th class="details2">2024-2025</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                </tr>
                <tr>
                    <th class="details2">2025-2026</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                </tr>
                <tr>
                    <th class="details2">2026-2027</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                </tr>
                <tr>
                    <th class="details2">2027-2028</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                </tr>
            </table>
            
            <br> <br>
            <table id="scholarshipTable" class="table-container">
                <tr>
                    <th colspan="4" class="details2">SCHOLARSHIP 
                        <ion-icon name="pencil-outline" onclick="toggleEdit('scholarshipTable')"></ion-icon>
                    </th>
                </tr> 
                <tr>
                    <th class="details2">ACADEMIC YEAR</th>
                    <th class="details2">1ST SEMESTER</th>
                    <th class="details2">2ND SEMESTER</th>
                    <th class="details2">3RD SEMESTER</th>
                </tr>
                <tr>
                    <th class="details2">2023-2024</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                </tr> 
                <tr>
                    <th class="details2">2024-2025</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                </tr>
                <tr>
                    <th class="details2">2025-2026</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                </tr>
                <tr>
                    <th class="details2">2026-2027</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                </tr>
                <tr>
                    <th class="details2">2027-2028</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                </tr>
            </table>

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
    </div>
    

    <div id="uploadOverlay" class="uploadOverlay">
        <div class="upload-content">
            <form action="" method="post" enctype="multipart/form-data">   
                <div>
                    <span class="closeUpload" onclick="closeUpload()">&times;</span>
                </div>
                <div id="select" class="container">    
                    <label for="acad_year">Academic Year:</label>
                    <input id="acad-year" type="text" name="acad_year" pattern="\d{4}-\d{4}" required>
                    
                    <label for="sem" style="margin-left:5vh;">Semester:</label>
                    <select id="sem" name="sem" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div> <br> <hr>

                <div class="container">
                    <div class="reqs">
                        <h2> Photocopy of Certificate of Registration </h2>
                        <h5> A.Y. 2024-2025, Semester 1 </h5>
                    </div>
                        
                    <div class="formats">
                        <p class="file"> Maximum File Size: </p>
                        <p class="files"> 5MB </p>
                    </div>

                    <div class="formats">
                        <p class="file"> File Type:</p>
                        <p class="files"> PDF File </p>
                    </div> <br> 

                    <label type="button" class="lblAdd" for="choose-file1"> 
                        <ion-icon name="share-outline"> </ion-icon> Upload File
                    </label>
                    <input name="COR" type="file" id="choose-file1" accept=".pdf" style="display: none;" /> 
                </div> <hr> 

                <div class="container">
                    <div class="reqs">
                        <h2> Photocopy of Grades/Transcript of Records </h2>
                        <h5> A.Y. 2024-2025, Semester 1 </h5>
                    </div>
                        
                    <div class="formats">
                        <p class="file"> Maximum File Size: </p>
                        <p class="files"> 5MB </p>
                    </div>

                    <div class="formats">
                        <p class="file"> File Type:</p>
                        <p class="files"> PDF File </p>
                    </div> <br> 

                    <label type="button" class="lblAdd" for="choose-file1"> 
                        <ion-icon name="share-outline"> </ion-icon> Upload File
                    </label>
                    <input name="GRADES" type="file" id="choose-file1" accept=".pdf" style="display: none;" /> 
                </div> <hr> 

                <div class="container">
                    <div class="reqs">
                        <h2> Social Service Monitoring Record with complete 40 hours </h2>
                        <h5> A.Y. 2024-2025 </h5>
                    </div>
                        
                    <div class="formats">
                        <p class="file"> Maximum File Size: </p>
                        <p class="files"> 5MB </p>
                    </div>

                    <div class="formats">
                        <p class="file"> File Type:</p>
                        <p class="files"> PDF File </p>
                    </div> <br> 

                    <label type="button" class="lblAdd" for="choose-file1"> 
                        <ion-icon name="share-outline"> </ion-icon> Upload File
                    </label>
                    <input name="SC" type="file" id="choose-file1" accept=".pdf" style="display: none;" /> 
                </div> <br> <hr> <br>

                <div class="submit">
                    <button type="submit" name="submission" class="btnSubmit"> Submit </button> 
                </div> <br>
            </form>
        </div> <br> <br>
    </div>


    <!-- NOTIFICATION -->
    <?php include 'notif.php'; ?>

    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
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

        // SAVE MODAL
        var modal = document.getElementById("saveOverlay");
        var span = document.getElementsByClassName("closeSave")[0];

        function openSave() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.getElementById('editButton');
            const cancelButton = document.getElementById('cancelButton');
            const saveButton = document.querySelector('button[name="save"]');
            const inputs = document.querySelectorAll('input[readonly], select[disabled]');

            editButton.addEventListener('click', function() {
                inputs.forEach(input => {
                    input.removeAttribute('readonly');
                    input.removeAttribute('disabled');
                });
                editButton.style.display = 'none';
                cancelButton.style.display = 'inline';
                saveButton.style.display = 'inline';
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
