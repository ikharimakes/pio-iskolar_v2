
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio Iskolar</title>
    <link rel="icon" type="image/x-icon" href="images/pio-logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/ad_inbox.css">
    <link rel="stylesheet" href="css/confirm.css">
</head>

<body>
    <!-- SIDEBAR - ad_navbar.php -->
    <?php include 'ad_navbar.php';?>
    

    <!-- TOP BAR -->
    <div class="main4">
        <div class="topBar">
            <div class="headerName">
                <h1>Inbox</h1>
            </div>

            <div class="headerRight">
                <div class="notif">
                    <ion-icon name="notifications-outline" onclick="openNotif()"></ion-icon>
                </div>

                <a class="user" href="profile.php">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <div class="line"></div>


        <!-- NAMES -->
        <div class="messenger">
            <div class="name-list">
                <div class="name-item">
                    <img src="images/profile.png" alt="Profile Picture">
                    <div class="name-info">
                        <h4>John Doe</h4>
                        <p>Last message preview...</p>
                    </div>
                </div>
                
                <div class="name-item">
                    <img src="images/profile.png" alt="Profile Picture">
                    <div class="name-info">
                        <h4>Jane Smith</h4>
                        <p>Last message preview...</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- CONVO -->
        <div class="convo">
            <div class="chat-messages">
                <div class="message admin">Hello! How can I assist you today?</div>
                <div class="message scholar">I need have a question about my scholarship.</div>
                <div class="message admin">Sure, can you please provide your scholar number?</div>
                <div class="message scholar">It's 12345.</div>
                <div class="message admin">Thank you! Let me check that for you.</div>
                <div class="message admin">Hello! How can I assist you today?</div>
                <div class="message scholar">I need have a question about my scholarship.</div>
                <div class="message admin">Sure, can you please provide your scholar number?</div>
                <div class="message scholar">It's 12345.</div>
                <div class="message admin">Thank you! Let me check that for you.</div>
                <div class="message admin">Hello! How can I assist you today?</div>
                <div class="message scholar">I need have a question about my scholarship.</div>
                <div class="message admin">Sure, can you please provide your scholar number?</div>
                <div class="message scholar">It's 12345.</div>
                <div class="message admin">Thank you! Let me check that for you.</div>
                <div class="message admin">Hello! How can I assist you today?</div>
                <div class="message scholar">I need have a question about my scholarship.</div>
                <div class="message admin">Sure, can you please provide your scholar number?</div>
                <div class="message scholar">It's 12345.</div>
                <div class="message admin">Thank you! Let me check that for you.</div>
                <div class="message admin">Hello! How can I assist you today?</div>
                <div class="message scholar">I need have a question about my scholarship.</div>
                <div class="message admin">Sure, can you please provide your scholar number?</div>
                <div class="message scholar">It's 12345.</div>
                <div class="message admin">Thank you! Let me check that for you.</div>
                <div class="message admin">Hello! How can I assist you today?</div>
                <div class="message scholar">I need have a question about my scholarship.</div>
                <div class="message admin">Sure, can you please provide your scholar number?</div>
                <div class="message scholar">It's 12345.</div>
                <div class="message admin">Thank you! Let me check that for you.</div>
            </div>

            <center><div class="chat-input">
                <input type="text" placeholder="Type your message...">
                <button><ion-icon name="send"></ion-icon></button>
            </div></center>
        </div>

        <div class="info">
            
        </div>
    </div>


    <!-- NOTIFICATION - notif.php -->
    <?php include 'notif.php'; ?>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>