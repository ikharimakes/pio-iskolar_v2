<?php 
    include_once('../functions/general.php');
    include_once('../functions/announce_view.php');
    updateStatus();
    clearExpiredResetCodes();

    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : (isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : null);

    if ($user_role == "1") {
        header("Location: ad_dashboard.php");
        exit();
    } elseif ($user_role == "2") {
        header("Location: dashboard.php");
        exit();
    } elseif ($user_role == "3") {
        header("Location: eval_dashboard.php");
        exit();
    } else {
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
    <link rel="stylesheet" href="css/front.css">
    <style>
        .required-error {
            border: 2px solid red;
        }
    </style>
</head>

<body>
    
    <div class="container">
        <!-- HEADER -->
        <header>
            <div class="topBar">
                <span class="headerLogo">
                    <img src="images/pio-logo.png" alt="logo"> 
                    <div class="headerText">
                        <h1>Pio Iskolar</h1>
                    </div>
                </span>
            </div>
        </header> <br> <br>
        
                
        <!-- ANNOUNCEMENT -->
        <div class="cards">
            <div class="card">
                <div class="slideshow">
                        <?php annFront();?>
                    
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>  
                    <br>

                <div style="text-align:center">
                    <?php slideshowButtons();?>
                </div>
            </div>
        </div>


        <!-- LOG IN -->
        <div class="logIn">
            <div class="logIn-content"> 
                <div class="infos1">
                    <h2>Log In</h2>
                </div>
                <br> <br> <br> <br>

                <div class="content">
                    <form id="loginForm" method="post" novalidate>
                        <center> <div class="inner-content1">
                            <label class="texts1" for="user">Enter Username/Email:</label> <br>
                            <input class="inputs1" type="text" id="user" name="user" placeholder="Username" required>
                        </div>
                        
                        <div class="inner-content2">
                            <label class="texts1" for="pass">Enter Password:</label> <br>
                            <input class="inputs1" type="password" id="pass" name="pass" placeholder="Password" required>
                        </div>

                        <div class="rem-container">
                            <div class="remember">
                                <input type="checkbox" id="rememberMe" name="remember">
                                <label for="rememberMe">Stay logged in</label>
                            </div>
                            <span class="forgotPass" onclick="openModal('forgotModal')"> Forgot Password?</span>
                        </div> 
                    
                        <div id="loginError" style="color: red; display: none; text-align: center;">Invalid Credentials!</div>
                        
                        <br>

                        <div class="btn1">
                            <button type="submit" class="logInBtn"> Log In </button>
                        </div></center> <br>
                    </form> 
                </div>

                <div class="about">
                    <p>Visit our website at 
                        <a href="https://valenzuela.gov.ph/drpioscholarship">Dr. Pio Valenzuela Scholarship Program</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- PASSWORD RESET MODAL -->
    <div id="forgotModal" class="forgot">
        <div class="forgot-content">
            <div class="infos">
                <img src="images/pio-logo.png" alt="pio">
                <h1>Forgot Password</h1>
                <span class="close" onclick="closeModal('forgotModal')">&times;</span>
            </div>
            <br><br>

            <form id="emailForm" method="post" novalidate>
                <div class="inner-content">
                    <label class="texts" for="email">Enter Email Address:</label> <br>
                    <input class="inputs1" type="email" id="email" name="email" placeholder="Email Address" required>
                </div>

                <div class="btn">
                    <button type="submit" class="logIn-button">Continue</button>
                </div>
            </form>
            <br>
        </div> 
    </div>

    <div id="passModal" class="pass">
        <div class="pass-content">
            <div class="infos">
                <img src="images/pio-logo.png" alt="pio">
                <h1>Reset Password</h1>
                <span class="close" onclick="closeModal('passModal')">&times;</span>
            </div>
            <br><br>
            
            <form id="resetForm" method="POST" novalidate>
                <input type="hidden" id="resetEmail" name="email">
                <div class="inner-content">
                    <label class="texts" for="reset_code">Enter Reset Code:</label> <br>
                    <input class="inputs1" type="text" id="reset_code" name="reset_code" placeholder="Enter code sent to your email" required>
                </div>
                <div class="inner-content">
                    <label class="texts" for="newPassword">Enter New Password:</label> <br>
                    <input class="inputs1" type="password" id="newPassword" name="newPassword" placeholder="New Password" required>
                </div>
                <div class="inner-content">
                    <label class="texts" for="confirmPassword">Confirm Password:</label> <br>
                    <input class="inputs1" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                </div>

                <div class="btn">
                    <button class="logIn-button" type="submit">Reset Password</button>
                </div> 
            </form>
            <br>
        </div>
    </div>

    <?php include 'toast.php'; ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // ANNOUNCEMENT
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }
        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const form = e.target;
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;
            
            const loginError = document.getElementById('loginError');
            loginError.style.display = 'none';

            requiredFields.forEach(field => {
                if (!field.value) {
                field.classList.add('required-error');
                valid = false;
                } else {
                field.classList.remove('required-error');
                }
            });

            if (!valid) {
                e.preventDefault(); // Prevent form submission if required fields are empty
            } else {
                e.preventDefault();
                const formData = new FormData(this);
                const data = new URLSearchParams();

                for (const pair of formData) {
                    data.append(pair[0], pair[1]);
                }

                fetch('../functions/login.php', {
                    method: 'POST',
                    body: data,
                })
                .then(response => response.text())
                .then(response => {
                    console.log('Response:', response);
                    if (response === 'admin') {
                        console.log("admin");
                        window.location.href = 'ad_dashboard.php';
                    } else if (response === 'scholar') {
                        console.log("scholar");
                        window.location.href = 'dashboard.php';
                    } else if (response === 'evaluator') {
                        console.log("evaluator");
                        window.location.href = 'eval_dashboard.php';
                    } else {
                        console.log("invalid");
                        // Show the login error if the response is invalid
                        loginError.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                })
            }
        });

        document.getElementById('emailForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;
            
            requiredFields.forEach(field => {
                if (!field.value) {
                    field.classList.add('required-error');
                    valid = false;
                } else {
                    field.classList.remove('required-error');
                }
            });

            if (valid) {
                const formData = new FormData(this);
                formData.append('check_email', '1');

                fetch('../functions/password_fx.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('resetEmail').value = document.getElementById('email').value;
                        openModal('passModal');
                        showToast("Reset code has been sent to your email", "Check Your Email");
                    } else {
                        openModal('passModal');
                        showToast("If email exists, you will receive a reset code", "Check Your Email");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast("An error occurred", "Error");
                });
            }
        });

        document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;
            
            requiredFields.forEach(field => {
                if (!field.value) {
                    field.classList.add('required-error');
                    valid = false;
                } else {
                    field.classList.remove('required-error');
                }
            });

            if (valid) {
                const formData = new FormData(this);
                formData.append('reset_password', '1');

                fetch('../functions/password_fx.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast("Password has been reset successfully", "Success");
                        closeModal('passModal');
                    } else {
                        const field = document.getElementById(data.message === 'password_mismatch' ? 'confirmPassword' : 'reset_code');
                        field.classList.add('required-error');
                        
                        let message = "An error occurred";
                        if (data.message === 'password_mismatch') {
                            message = "Passwords do not match";
                        } else if (data.message === 'empty_fields') {
                            message = "Please fill in all fields";
                        } else if (data.message === 'invalid_code') {
                            message = "Invalid or expired reset code";
                        }
                        showToast(message, "Error");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast("An error occurred", "Error");
                });
            }
        });

        // Add this to the existing input event listeners
        document.querySelectorAll('.inputs1').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value) {
                    this.classList.remove('required-error');
                }
            });
        });

        //FORGOT PASSWORD
        function openModal(forgotModal) {
            var modal = document.getElementById(forgotModal);
            modal.style.display = "block";
        }
        function closeModal(forgotModal) {
            var modal = document.getElementById(forgotModal);
            modal.style.display = "none";
        }
        function openModal(passModal) {
            closeModal('forgotModal');
            var modal = document.getElementById(passModal);
            modal.style.display = "block";
        }
        function closeModal(passModal) {
            var modal = document.getElementById(passModal);
            modal.style.display = "none";
        }
    </script>
</body>
</html>