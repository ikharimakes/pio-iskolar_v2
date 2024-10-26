<?php
@session_start();
$errors = array();
$success = array();
$warning = array();
$sweetAlert = array();
$warnAlert = array();

require_once '../vendor/autoload.php';
require 'mailer.php';

// $dsn = 'gmail://raisseille@gmail.com:odaqgskzkeohvnwu@default';
// $dsn = 'gmail://pio.iskolar.team@gmail.com:pogvqxmkzfyxnqt@default';

//* DATABASE CONNECTION *//
    // Credentials
    $serv = "localhost";  
    $host = "root";   
    $keys = "";   
    $dbnm = "pio_iskolar"; 
    $ports = [3308, 3307, 3306];  // List of ports to try

    $connection_successful = false; // Initialize connection status
    $successful_port = null; // To store the port that was successful

    // Initialize $conn
    $conn = new mysqli($serv, $host, $keys, $dbnm, $ports[0]);

    // Check if the initial connection is successful
    if ($conn->connect_error) {
        //js_debug_log("Initial connection failed on port $ports[0]: " . $conn->connect_error);

        // Attempt to connect using other ports
        foreach (array_slice($ports, 1) as $port) {
            // Close any existing connection
            $conn->close();
            $conn = new mysqli($serv, $host, $keys, $dbnm, $port);

            if ($conn->connect_error) {
                // Log the connection error and try the next port
                //js_debug_log("Connection failed on port $port: " . $conn->connect_error);
                continue;
            } else {
                // Log successful connection and break out of the loop
                //js_debug_log("Connection successful on port $port");
                $connection_successful = true;
                $successful_port = $port; // Store the successful port
                break;
            }
        }
    } else {
        // If initial connection was successful
        //js_debug_log("Initial connection successful on port $ports[0]");
        $connection_successful = true;
        $successful_port = $ports[0]; // Store the successful port
    }

    // Check if connection was successful
    if ($connection_successful) {
        //js_debug_log("Final connection successful on port " . $successful_port);
    } else {
        die("Final connection failed: " . $conn->connect_error);
    }

//* MAILING *//
    function sendEmailAsync(string $email, string $subject, string $content) {
        $cmd = buildEmailCommand('processor.php', $email, $subject, $content);
        executeCommand($cmd);
    }

    function sendBulkEmailAsync(array $recipients) {
        foreach ($recipients as $recipient) {
            sendEmailAsync($recipient['email'], $recipient['subject'], $recipient['content']);
        }
    }

    function buildEmailCommand($script, string $email, string $subject, string $content) {
        $scriptPath = __DIR__ . '/' . $script;
        
        // Base64 encode subject and content to preserve spaces and special characters
        $encodedSubject = base64_encode($subject);
        $encodedContent = base64_encode($content);
        
        $command = sprintf(
            'php "%s" "%s" "%s" "%s"',
            $scriptPath,
            escapeshellarg($email),
            escapeshellarg($encodedSubject),
            escapeshellarg($encodedContent)
        );

        return PHP_OS === 'WINNT'
            ? 'start /B ' . $command
            : $command . ' > /dev/null 2>&1 &';
    }

    function executeCommand($command) {
        if (PHP_OS === 'WINNT') {
            pclose(popen($command, 'r'));
        } else {
            exec($command);
        }
    }
    
    function clearExpiredResetCodes() {
        global $conn;
        
        // Clear reset codes and expiry dates that have passed
        $sql = "UPDATE user 
                SET reset_code = NULL, 
                    reset_expiry = NULL 
                WHERE reset_expiry IS NOT NULL 
                AND reset_expiry < NOW()";
                
        $stmt = $conn->prepare($sql);
        
        try {
            $stmt->execute();
            error_log("[CLEANUP] Cleared " . $stmt->affected_rows . " expired reset codes");
            return true;
        } catch (Exception $e) {
            error_log("[CLEANUP] Error clearing expired reset codes: " . $e->getMessage());
            return false;
        } finally {
            $stmt->close();
        }
    }

//* PARAMETER PULL *//
    function academic() {
        global $conn;
        $query = "SELECT acad_year AS acad FROM batch_year ORDER BY batch_no DESC LIMIT 1";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc()['acad'];
        }
    }

    function batch() {
        global $conn;
        $query = "SELECT batch_no AS batch FROM batch_year ORDER BY batch_no DESC LIMIT 1";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc()['batch'];
        }
    }

    function semester() {
        $current_month = date('m'); 
        if ($current_month >= 7 && $current_month <= 12) {
            return 1;
        } else {
            return 2;
        }
    }

    function scholarName() {
        global $conn;
        $query = $conn->prepare("SELECT last_name, first_name FROM scholar WHERE scholar_id = ? AND batch_no = ?");
        $query->bind_param("ss", $_SESSION['sid'], $_SESSION['bid']);
        $query->execute();
        $result = $query->get_result();
        $data = $result->fetch_assoc();
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];
        print 'Welcome Back, ' . $data['first_name'] . '!';
    }
    
    function scholarFull() {
        global $conn;
        if(isset($_POST['scholar'])) {$_SESSION['sid'] = $_POST['scholar'];}
        $id = $_SESSION['sid'];
        // SCHOLAR DETAILS
        $display = "SELECT * FROM scholar WHERE scholar_id = '$id'";
        $result = $conn->query($display);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                print '
                    <h1>'.$row['last_name'].', '.$row['first_name'].' '.$row['middle_name'].'</h1> 
                ';
            }
        }
    }

    $year = academic();
    $sem = semester();
    $batch = batch();

//* DATA LISTS *//
    function datalisting($column, $table, $id) {
        global $conn;
        if($id == "sem"){ 
            echo '    
                <datalist id="sem">
                    <option value="1">
                    <option value="2">
                    <option value="3"> 
                </datalist>
            ';
        } else {
            $query = $conn->prepare("SELECT DISTINCT $column AS a FROM $table");
            $query->execute();
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                echo '<datalist id="'.$id.'">';
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="'.$row['a'].'">';
                }
                echo '</datalist>';
            }
        }
        // SCHOLAR STATUS   datalisting("status_name", "status", "status");
        // SCHOOLS          datalisting("school", "scholar", "school");
        // COURSES          datalisting("course", "scholar", "course");
        // BATCH NUMBER     datalisting("batch_no", "batch_year", "batch");
        // ACADEMIC YEAR    datalisting("acad_year", "batch_year", "year");
        // SEMESTER         datalisting("", "", "sem");
    }
?>
