<?php
@session_start();
$errors = array();
$success = array();
$warning = array();
$sweetAlert = array();
$warnAlert = array();

require '../vendor/autoload.php';
use Symfony\Component\Process\Process;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to output JavaScript console.log messages
function js_debug_log($message) {
    echo '<script>console.log(' . json_encode($message) . ');</script>';
}


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
    function sendEmailsAsync(array $recipients, string $subject, string $message, string $from)
    {
        foreach ($recipients as $recipient) {
            // Prepare the email parameters to be passed to the background process
            $command = [
                'php', // The PHP binary
                __DIR__ . '/mailing_fx.php', // The separate PHP script file for sending the email
                $recipient,
                $subject,
                $message,
                $from
            ];

            // Create and start the process for sending the email in the background
            $process = new Process($command);
            $process->setTimeout(null);
            $process->start();

            // // Optionally, you can check the output or status of the process
            // $process->wait(function ($type, $buffer) {
            //     if (Process::ERR === $type) {
            //         echo 'Error: ' . $buffer;
            //     } else {
            //         echo 'Output: ' . $buffer;
            //     }
            // });
    
            // Detach the process so it doesn't block the main thread
            if (Process::STATUS_TERMINATED !== $process->getStatus()) {
                return; // Simply return immediately without waiting for the process to complete
            }
        }
    }

    function tempMail(array $email, string $subject, string $body) {
        $mail = new PHPMailer(true);
        foreach ($email as $to) {
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'raisseille@gmail.com';   //pio.iskolar@gmail.com
                $mail->Password = 'odaq gskz keoh vnwu';    //hadj fkxn jxjj kmdr
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
        
                // Recipients
                $mail->setFrom('pio.iskolar@gmail.com', 'Pio Iskolar Team');
                $mail->addAddress($to); // Add a recipient
        
                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $body;
        
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
    }

    function inquiriesMail(string $email, string $name, string $body) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'raisseille@gmail.com';   //pio.iskolar@gmail.com
            $mail->Password = 'odaq gskz keoh vnwu';    //hadj fkxn jxjj kmdr
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
    
            // Recipients
            $mail->setFrom('pio.iskolar@gmail.com', 'Pio Iskolar Team');
            $mail->AddAddress($email, $name);
            $mail->AddAddress('raisseille@gmail.com', 'Coordinator');
    
            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = "Scholar Inquiry";
            $mail->Body    = $body;
    
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
    }

    if (isset($_POST['inquire'])) {
        inquiriesMail($_POST['email'], $_POST['name'], $_POST['message']);
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
        if(isset($_POST['scholar_id'])) {$_SESSION['sid'] = $_POST['scholar_id'];}
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
