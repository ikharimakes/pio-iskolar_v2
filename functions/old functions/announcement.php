<?php
    include_once('../functions/general.php');
	global $conn;

//! NEEDS UPDATING !//
//* SCHOLAR DISPLAY *//
    function scholarDisplay(){
        global $conn;
        $display = "SELECT scholarID, batchID, lastName, firstName, middleName, scholarstatus_tbl.statusName FROM scholar_tbl 
        LEFT JOIN scholarstatus_tbl ON scholar_tbl.statusID = scholarstatus_tbl.statusID
        ORDER BY scholar_tbl.scholarID";
        $result = $conn->query($display);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                print '
                    <tr> 
                        <td> '.$row["scholarID"].' </td>
                        <td> '.$row["lastName"].' </td>
                        <td> '.$row["firstName"].' </td>
                        <td> '.$row["statusName"].' </td>
                        <td> 
                            <button><i class="btnPrev"></i> Preview </button> 
                        </td>
                        <td>
                            <button><i class="btnEdit"></i> Edit </button>
                        </td>
                        <td>
                            <img src="images/download.png" alt="Icon">
                        </td>
                    </tr>
                ';
            }
        }
    }

?>