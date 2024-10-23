<?php 
    include('../functions/general.php');
    include('../functions/document_upload.php');
    
    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : (isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : null);

    if ($user_role == "2") {
    } elseif ($user_role == "1") {
        header("Location: ad_dashboard.php");
    } elseif ($user_role == "3") {
        header("Location: eval_dashboard.php");
    } else {
        header("Location: front_page.php");
    }

    $scholar_id = $_SESSION['sid'];
    global $year, $sem;

    function getUploadButtonHtml($scholar_id, $doc_type, $year, $sem) {
        $docDetails = getDocumentDetails($scholar_id, $doc_type, $year, $sem);
        if ($docDetails) {
            if ($docDetails['doc_status'] === 'DECLINED') {
                $buttonLabel = 'REPLACE DOCUMENT';
                $buttonStyle = 'style=""';
            } else {
                $buttonLabel = '';
                $buttonStyle = 'style="display:none;"';
            }
            return "
                <label type='button' class='lblAdd' for='choose-file-$doc_type' $buttonStyle>
                    <ion-icon name='share-outline'></ion-icon> <b> $buttonLabel </b>
                </label>
                <input name='$doc_type' type='file' id='choose-file-$doc_type' accept='.pdf' style='display: none;' $buttonStyle /> <p>{$docDetails['doc_name']} - <b>{$docDetails['doc_status']}</b></p>
            ";
        } else {
            return "
                <label type='button' class='lblAdd' for='choose-file-$doc_type'>
                    <ion-icon name='share-outline'></ion-icon> UPLOAD FILE
                </label>
                <input name='$doc_type' type='file' id='choose-file-$doc_type' accept='.pdf' style='display: none;' />
            ";
        }
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
    <link rel="stylesheet" href="css/docs.css">
    <link rel="stylesheet" href="css/confirm.css">
    <style>
        .required-error {
            border: 2px solid red;
        }
    </style>
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
                            <h5> <?php echo 'A.Y. '.$year.', Semester '.$sem?> </h5>
                        </div>
                        
                        <div class="formats">
                            <p class="file"> Maximum File Size: </p>
                            <p class="files"> 5MB </p>
                        </div>

                        <div class="formats">
                            <p class="file"> File Type:</p>
                            <p class="files"> PDF File </p>
                        </div> <br> 

                        <?php echo getUploadButtonHtml($scholar_id, 'COR', $year, $sem); ?> 
                    </div>
                </div> <br>

                <div class="card"> 
                    <div class="container">
                        <div class="reqs">
                            <h2> Photocopy of Grades/Transcript of Records </h2>
                            <h5> <?php echo 'A.Y. '.$year.', Semester '.$sem?> </h5>
                        </div>
                        
                        <div class="formats">
                            <p class="file"> Maximum File Size: </p>
                            <p class="files"> 5MB </p>
                        </div>

                        <div class="formats">
                            <p class="file"> File Type:</p>
                            <p class="files"> PDF File </p>
                        </div> <br> 

                        <?php echo getUploadButtonHtml($scholar_id, 'GRADES', $year, $sem); ?> 
                    </div>
                </div> <br>

                <div class="card"> 
                    <div class="container">
                        <div class="reqs">
                            <h2> Social Service Monitoring Record with complete 40 hours </h2>
                            <h5> <?php echo 'A.Y. '.$year.', Semester '.$sem?> </h5>
                        </div>
                        
                        <div class="formats">
                            <p class="file"> Maximum File Size: </p>
                            <p class="files"> 5MB </p>
                        </div>

                        <div class="formats">
                            <p class="file"> File Type:</p>
                            <p class="files"> PDF File </p>
                        </div> <br> 

                        <?php echo getUploadButtonHtml($scholar_id, 'SOCIAL', $year, $sem); ?> 
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

                        <?php echo getUploadButtonHtml($scholar_id, 'DIPLOMA', $year, $sem); ?> 
                    </div>
                </div> <br>

                <div class="submit">
                    <button type="submit" name="submission" class="btnSubmit"> Submit </button> 
                </div>
            </form>
        </div> <br> <br>
    </div>

    <?php include 'notif.php'; ?>
    <?php include 'toast.php'; ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
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