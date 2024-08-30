<?php
    include_once('../functions/general.php');
    global $conn;

//* SCHOLAR PROFILE DISPLAY *//
    function scholarDisplay($id) {
        global $conn;
        $display = "SELECT * FROM scholar WHERE scholar_id = '$id'";
        $result = $conn->query($display);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sch_id = substr($row["scholar_id"], 0, 2) . '-' . substr($row["scholar_id"], 2, 3);
                print '
                <div class="profile_name">
                    <img src="images/profile.png" alt="Profile Picture"> <br>
                    <h2>'.$row['last_name'].', '.$row['first_name'].' '.$row['middle_name'].'</h2>
                </div>

                <div class="profile-info">
                    <table>
                        <tr>
                            <th>Scholar ID:</th>
                            <td>'.$sch_id.'</td>
                        </tr>
                        <tr>
                            <th>School:</th>
                            <td>'.$row['school'].'</td>
                        </tr>
                        <tr>
                            <th>Course:</th>
                            <td>'.$row['course'].'</td>
                        </tr>
                        <tr>
                            <th>Scholar Status:</th>
                            <td>'.$row['status'].'</td>
                        </tr>
                        <tr style="height: 40px;">
                            <th> </th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>'.$row['_address'].'</td>
                        </tr>
                        <tr>
                            <th>Contact:</th>
                            <td>'.$row['contact'].'</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>'.$row['email'].'</td>
                        </tr>
                        <tr style="height: 10px;">
                            <th> </th>
                            <td> </td>
                        </tr>
                        <tr style="height: 40px;">
                            <th> <a href="#" onclick="openPass()"> Change Password </a></th>
                            <td></td>
                        </tr>
                    </table>
                </div>
                ';
            }
        }
    }

    //* TOP NAV DISPLAY *//
    function navDisplay() {
        global $conn;
        if(isset($_POST['scholar_id'])) {$_SESSION['id'] = $_POST['scholar_id'];}
        $id = $_SESSION['id'];
        // SCHOLAR DETAILS
        $display = "SELECT * FROM scholar WHERE scholar_id = '$id'";
        $result = $conn->query($display);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                print '
                    <div class="details"><center> 
                        <h1>'.$row['last_name'].', '.$row['first_name'].' '.$row['middle_name'].'</h1> 

                        <div class="topnav">
                            <a href="ad_detail.php">Scholar Details</a>
                            <a href="ad_skoDocs.php">Documents</a>
                        </div> 
                    </center></div>
                ';
            }
        }
    }

    //* ADMIN PROFILE DISPLAY *//
function adminDisplay() {
    global $conn;
    if(isset($_POST['scholar_id'])) {$_SESSION['id'] = $_POST['scholar_id'];}
    $id = $_SESSION['id'];
    // SCHOLAR DETAILS
    $display = "SELECT * FROM scholar WHERE scholar_id = '$id'";
    $result = $conn->query($display);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sch_id = substr($row["scholar_id"], 0, 2) . '-' . substr($row["scholar_id"], 2, 3);
            $profile = [
                'Scholar No.' => $sch_id,
                'School' => $row['school'],
                'Course' => $row['course'],
                'Scholar Status' => $row['status'],
                '' => '',
                'Address' => $row['_address'],
                'Contact' => $row['contact'],
                'Email' => $row['email']
            ];
            echo '
                <form action="" method="post" id="profileForm">
                
                    <div class="profile">
                        
                        <div class="profile_name">
                            <img src="images/profile.png" alt="Profile Picture"> <br>
                        </div>
                        
                        

                        <div class="profile-info">
                            <div class="button-container">
                                <button type="button" class="edit-button" id="editButton">
                                    <h3> Edit </h3>
                                </button>
                                <button type="button" class="cancel-button" id="cancelButton" style="display:none;"> 
                                    <h3> Cancel </h3>
                                </button>
                            </div>
                            <table>
            ';
            foreach ($profile as $key => $value) {
                echo '
                    <tr>
                        <th style="width: 20%">'.$key.'</th>
                        <td>';
                if ($key == 'School') {
                    echo '<input type="text" list="school" name="school" value="'.$value.'" class="input2" style="text-align: left; width: 100%; font-size: 20px" readonly>';
                    datalisting("school", "scholar", "school");
                } elseif ($key == 'Course') {
                    echo '<input type="text" list="course" name="course" value="'.$value.'" class="input2" style="text-align: left; font-size: 20px" readonly>';
                    datalisting("course", "scholar", "course");
                } elseif ($key == 'Scholar Status') {
                    echo '<select name="scholar_status" id="scholarStatus" class="input2" style="text-align: left; font-size: 20px; border: 0px solid; outline: none;" disabled>
                            <option value="ACTIVE" '.($value == 'ACTIVE' ? 'selected' : '').' style="color: rgb(0, 136, 0);">ACTIVE</option>
                            <option value="PROBATION" '.($value == 'PROBATION' ? 'selected' : '').' style="color: rgb(255,148,0);">PROBATION</option>
                            <option value="DROPPED" '.($value == 'DROPPED' ? 'selected' : '').' style="color: rgb(189, 0, 0);">DROPPED</option>
                            <option value="LOA" '.($value == 'LOA' ? 'selected' : '').' style="color: rgb(255, 219, 88);">LOA</option>
                            <option value="GRADUATED" '.($value == 'GRADUATED' ? 'selected' : '').' style="color: rgb(0,68,255);">GRADUATED</option>
                          </select>';
                } elseif ($key == 'Batch ID') {
                    echo '<input type="text" name="batch_id" value="'.$value.'" class="input2" style="text-align: left; font-size: 20px" readonly>';
                } else {
                    echo '<input type="text" name="'.strtolower(str_replace(' ', '_', $key)).'" value="'.$value.'" class="input2" style="text-align: left; font-size: 20px" readonly>';
                }
                echo '</td>
                    </tr>
                ';
            }
            echo '
                            </table>
                            <button type="submit" name="save" class="save-button" style="display:none;">Save</button>
                        </div>
                    </div>
                </form>
            ';
        }
    }
}
?>