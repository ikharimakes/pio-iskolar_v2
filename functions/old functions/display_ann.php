<?php
    include_once('../functions/general.php');
    global $conn;

//* FRONT PAGE ANNOUNCEMENTS *//
    function annFront() {
        global $conn;
        $display = "SELECT img_name, title, content, _status FROM announcements WHERE _status = 'ACTIVE' ORDER BY st_date";
        $result = $conn->query($display);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                print '
                    <div class="mySlides fade">
                        <img src="../assets/'.$row["img_name"].'" 
                        style="width:100%">
                        <div class="text">
                            <h2> '.$row["title"].' </h2> <hr>
                            <p>'.nl2br($row["content"]).' </p> 
                        </div>
                    </div>
                ';
            }
        }
    }
    
    function slideshowButtons() {
        global $conn;
        $display = "SELECT COUNT(_status) as count FROM announcements WHERE _status = 'ACTIVE'"; // Using alias to retrieve count as 'count'
        $result = $conn->query($display);
        if ($result->num_rows > 0) {
            $count = $result->fetch_assoc()['count']; // Fetching the count directly
            for ($i = 0; $i < $count; $i++) {
                print '<span class="dot" onclick="currentSlide('.($i+1).')"></span>';
            }
        }

    }

//* SCHOLAR PAGE ANNOUNCEMENTS *//
    function annDisplay() {
        global $conn;
        $display = "SELECT img_name, title, content, _status FROM announcements WHERE _status = 'ACTIVE' ORDER BY st_date";
        $result = $conn->query($display);

        if ($result->num_rows > 0) {
            $hr = false;
            while ($row = $result->fetch_assoc()) {
                if ($hr == true) {print'<hr>';}
                print '
                    <section class="announce">
                        <div class="announce-image">
                            <img src="../assets/'.$row["img_name"].'">
                        </div>
                        <div class="announce-content">
                            <h2> '.$row["title"].' </h2> 
                            <p>'.nl2br($row["content"]).' </p> 
                        </div>
                    </section>
                ';
                $hr = true;
            }
        }
    }
?>