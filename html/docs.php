<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio Iskolar</title>
    <link rel="icon" type="image/x-icon" href="images/pio-logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/docs.css">
    <link rel="stylesheet" href="css/confirm.css">
</head>

<body>
    <!-- SIDEBAR - navbar.php -->
    <?php include 'navbar.php';?>
    

    <!-- TOP BAR -->
    <div class="main">
        <div class="topBar">
            <div class="headerName">
                <h1>Requirements</h1>
            </div>

            <div class="headerRight">
                <div class="notif">
                    <ion-icon name="notifications-outline" onclick="openOverlay()"></ion-icon>
                </div>

                <a class="user" href="profile.php">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <div class="line"></div>


        <!-- NOTE -->
        <div class="info">
            <p> Note: These requirements must be submitted after every enrollment. </p>
        </div>


        <!-- REQUIREMENTS -->
        <div class="cards">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="card"> 
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
                    </div>
                </div> <br>

                <div class="card"> 
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
                    </div>
                </div> <br>

                <div class="card"> 
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
                    </div>
                </div> <br>

                <!-- FOR GRADUATES SCHOLARS -->
                <div class="card"> 
                    <div class="container">
                        <div class="reqs">
                            <h2> Diploma </h2>
                            <h5> Batch 2025, A.Y. 2021-2025 </h5>
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
                        <input name="DIPLOMA" type="file" id="choose-file1" accept=".pdf" style="display: none;" /> 
                    </div>
                </div> <br>

                <div class="submit">
                    <button type="submit" name="submission" class="btnSubmit"> Submit </button> 
                </div>
            </form>
        </div> <br> <br>
    </div>


    <!-- NOTIFICATION - notif.php -->
    <?php include 'notif.php'; ?>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>