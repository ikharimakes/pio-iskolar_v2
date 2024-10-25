<?php 
    include_once('../functions/general.php');
    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : (isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : null);

    if ($user_role == "2") {
    } elseif ($user_role == "1") {
        header("Location: ad_dashboard.php");
        exit();
    } elseif ($user_role == "3") {
        header("Location: eval_dashboard.php");
        exit();
    } else {
        header("Location: front_page.php");
        exit();
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
    <link rel="stylesheet" href="css/faq.css">
    <link rel="stylesheet" href="css/confirm.css">
    <style>
        .required-error {
            border: 2px solid red !important;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR - navbar.php -->
    <?php include 'navbar.php';?>
    

    <!-- TOP BAR -->
    <div class="main4">
        <div class="topBar">
            <div class="headerName">
                <h1> Frequently Asked Questions </h1>
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


        <!-- FAQ-->
        <div class="info">
            <div class="help">
                <p> How can we help? </p>
            </div> <br>

            <!-- <div class="search">
                <form action="" method="get">
                    <label>
                        <input type="text" name="search" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </form>
            </div> -->
        </div>


        <!-- QUESTIONS -->
        <div class="accordion">
            <div class="questions">
                <button class="question">
                    <span>
                        <ion-icon name="help-circle-outline"></ion-icon>
                        What are the main obligations of a Dr. Pio Valenzuela scholarship grantee?
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>

                <div class="panel">
                    <p>
                        Grantees must report to the Scholarship Coordinator each enrollment period, 
                        enroll the minimum required number of units, be full-time students, secure 
                        permission for leaves of absence, and participate in civic activities like 
                        blood donation and summer camps.
                    </p>
                </div>
            </div>
            
            <div class="questions">
                <button class="question">
                    <span>
                        <ion-icon name="help-circle-outline"></ion-icon>
                        What are the grounds for forfeiture of the Dr. Pio Valenzuela scholarship?
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>
                <div class="panel">
                    <p>
                        The scholarship may be forfeited if the grantee fails to meet the required General 
                        Weighted Average (GWA), fails subjects, drops out, or fails to finish even one 
                        semester. Other grounds include receiving another scholarship, disciplinary actions, 
                        and failure to report every semester.
                    </p>
                </div>
            </div>

            <div class="questions">
                <button class="question">
                    <span>
                        <ion-icon name="help-circle-outline"></ion-icon>
                        How many social service hours are required for scholarship grantees?
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>
                <div class="panel">
                    <p>
                        Grantees must complete 160 points worth of activities, including blood donation, 
                        summer reading camps, and other city-wide activities, or attend school seminars 
                        and workshops, as outlined in the Social Service Monitoring Record.
                    </p>
                </div>
            </div>

            <div class="questions">
                <button class="question">
                    <span>
                        <ion-icon name="help-circle-outline"></ion-icon>
                        What is the required General Weighted Average (GWA) to maintain the scholarship?
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>
                <div class="panel">
                    <p>
                        Grantees must maintain a GWA of 2.0 and no less than 2.25 in any subject.
                    </p>
                </div>
            </div>

            <div class="questions">
                <button class="question">
                    <span>
                        <ion-icon name="help-circle-outline"></ion-icon>
                        What documents must be submitted every semester?
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>
                <div class="panel">
                    <p>
                        Grantees must submit a photocopy of their Certificate of Registration, their 
                        Grade Report Card, and a completed Social Service Monitoring Record with 40 
                        hours of service each semester.
                    </p>
                </div>
            </div>

            <div class="questions">
                <button class="question">
                    <span>
                        <ion-icon name="help-circle-outline"></ion-icon>
                        Can a grantee waive the Dr. Pio Valenzuela scholarship?
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>
                <div class="panel">
                    <p>
                        Yes, but they must inform the DVPSP Advisory Committee in writing, stating 
                        their reasons and obtaining signatures from both the grantee and a parent.
                    </p>
                </div>
            </div>

            <div class="questions">
                <button class="question">
                    <span>
                        <ion-icon name="help-circle-outline"></ion-icon>
                        What happens if a grantee fails to complete the required social service hours?
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>
                <div class="panel">
                    <p>
                        If the grantee fails to fulfill the required hours, they may not meet the scholarship 
                        obligations, which could lead to warnings, probation, or forfeiture of the grant.
                    </p>
                </div>
            </div>

            <div class="questions">
                <button class="question">
                    <span>
                        <ion-icon name="help-circle-outline"></ion-icon>
                        What types of activities count toward the social service requirement?
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>
                <div class="panel">
                    <p>
                        Activities include blood donation, participation in the Summer Reading Camp, 
                        city-wide activities, and attending school seminars and workshops.
                    </p>
                </div>
            </div>

            <div class="questions">
                <button class="question">
                    <span>
                        <ion-icon name="help-circle-outline"></ion-icon>
                        What should a grantee do if they lose their Social Service Monitoring Record?
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>
                <div class="panel">
                    <p>
                        The grantee should report the loss immediately, execute an Affidavit of Loss, 
                        and have it approved by the Scholarship Office.
                    </p>
                </div>
            </div>

            <div class="questions">
                <button class="question">
                    <span>
                        <ion-icon name="help-circle-outline"></ion-icon>
                        Who comprises the Dr. Pio Valenzuela Scholarship Program Advisory Committee?
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>
                <div class="panel">
                    <p>
                        The committee is chaired by Hon. Weslie T. Gatchalian, with members from 
                        the city government, education sector, and other key city officials.
                    </p>
                </div>
            </div>
        </div>


        <!-- MESSAGE -->
        <div class="inquiry-box">
            <h3>Inquiry Form</h3>
            <form id="inquiryForm" novalidate>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" placeholder="Enter your inquiry" required></textarea>

                <button type="submit" name="inquire">Send Inquiry</button>
            </form>

            <div class="note-wrapper">
                <p class="note">Note:</p>
                <p class="note1">This email is for inquiry about scholarship only.</p>
            </div>
        </div>


        <!-- CONVO 
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
        </div>-->
    </div>

    <?php include 'notif.php'; ?>
    <?php include 'toast.php'; ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        var acc = document.getElementsByClassName("question");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                /* Toggle between adding and removing the "active" class,
                to highlight the button that controls the panel */
                this.classList.toggle("active");

                /* Toggle between hiding and showing the active panel */
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
        function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    document.getElementById('inquiryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const requiredFields = form.querySelectorAll('[required]');
        let valid = true;

        // Reset all error states
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('required-error');
                valid = false;
            }
            
            if (field.type === 'email' && !isValidEmail(field.value.trim())) {
                field.classList.add('required-error');
                valid = false;
                showToast('Please enter a valid email address', 'Invalid Address');
                return;
            }

            // Add input event listeners to remove error class when user types
            field.addEventListener('input', function() {
                if (field.value.trim()) {
                    field.classList.remove('required-error');
                    if (field.type === 'email' && !isValidEmail(field.value.trim())) {
                        field.classList.add('required-error');
                    }
                }
            });
        });

        if (!valid) {
            return;
        }

        const formData = new FormData(form);
        const data = new URLSearchParams();

        for (const pair of formData) {
            data.append(pair[0], pair[1]);
        }

        fetch('../functions/inquiry_fx.php', {
            method: 'POST',
            body: data,
        })
        .then(response => response.text())
        .then(response => {
            if (response === 'success') {
                showToast('Inquiry sent successfully!', 'Success');
                form.reset();
                requiredFields.forEach(field => {
                    field.classList.remove('required-error');
                });
            } else {
                showToast('Failed to send inquiry. Please try again.', 'Mail Error');
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            showToast('An unexpected error occurred.', 'Error');
        });
    });

    // Email validation helper function
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    </script>
</body>
</html>