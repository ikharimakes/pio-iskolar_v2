<?php 
    include_once('../functions/general.php'); 
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
    <!-- SIDEBAR - eval_navbar.php -->
    <?php include 'eval_navbar.php'; ?>


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
                    <ion-icon name="notifications-outline" onclick="openNotif()"></ion-icon>
                </div>

                <a class="user">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <!-- TOP NAV -->
        <div class="details"><center> 
            <h1> ADRIANO, JESSICA RAYE </h1> 

            <div class="topnav">
                <a href="eval_skoDetail.php">Scholar Details</a>
                <a href="eval_skoDocs.php">Documents</a>
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
                    <th colspan="11" class="details2">DOCUMENTS </th>
                </tr>
                <tr>
                    <th rowspan="2" class="details2">ACADEMIC YEAR</th>
                    <th colspan="3" class="details2">1ST SEMESTER</th>
                    <th colspan="3" class="details2">2ND SEMESTER</th>
                    <th colspan="3" class="details2">3RD SEMESTER</th>
                </tr>
                <tr>
                    <td class="details2">COR</td>
                    <td class="details2">GRADES</td>
                    <td class="details2">RELEASE</td>
                    <td class="details2">COR</td>
                    <td class="details2">GRADES</td>
                    <td class="details2">RELEASE</td>
                    <td class="details2">COR</td>
                    <td class="details2">GRADES</td>
                    <td class="details2">RELEASE</td>
                </tr>
                <tr>
                    <td class="details2">2023-2024</td>
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
                    <td class="details2">2024-2025</td>
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
                    <td class="details2">2025-2026</td>
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
                    <td class="details2">2026-2027</td>
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
                    <td class="details2">2027-2028</td>
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
                    <th colspan="4" class="details2">SCHOLARSHIP </th>
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
                    <th class="details2">2023-2024</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></th>
                </tr>
                <tr>
                    <th class="details2">2023-2024</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></th>
                </tr>
                <tr>
                    <th class="details2">2023-2024</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></th>
                </tr>
                <tr>
                    <th class="details2">2023-2024</th>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></td>
                    <td><input type="text" class="input2"></th>
                </tr>
            </table>
            <br> <br>
            
            <table id="remarksTable" class="table-container">
                <tr>
                    <th class="details2">REMARKS </th>
                </tr>
                <tr>
                    <td> <input type="text" class="input3"> </td>
                </tr>
            </table>
        </div>  
    </div>
    

    <!-- NOTIFICATION -->
    <?php include 'notif.php'; ?>

    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
