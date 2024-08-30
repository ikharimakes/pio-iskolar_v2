<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio Iskolar</title>
    <link rel="icon" type="image/x-icon" href="images/pio-logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/front.css">
</head>

<body>
    <!-- HEADER -->
    <header>
        <div class="topBar">
            <span class="headerLogo">
                <img src="images/pio-logo.png" alt="logo"> 
                <div class="headerText">
                    <h1>Pio Iskolar</h1>
                </div>
            </span>

            <div class="info">
                <h1>ANNOUNCEMENT</h1>
            </div>

            <a href="#" class="btnLogIn"> 
                <ion-icon name="log-in-outline"></ion-icon>
                <h5> Log In </h5>
            </a>
        </div>
    </header> <br> <br>
    
            
    <!-- ANNOUNCEMENT -->
    <center><div class="cards">
	    <div class="card">
            
            <div class="slideshow">
                <div class="mySlides fade">
                    <img src="images/pic1.jpg" style="width:100%">
                    <div class="text">
                        <h2> Application for Batch 23 </h2>
                        <hr>
                        <p> The City Government of Valenzuela 
                            will start accepting applicants for the Dr. Pio Valenzuela
                            Scholarship Program on December 13, 2023. Here are the 
                            qualifications and requirements for the scholarship program. 
                            <br> <br>
                            Get the downloadable scholarship application form here: 
                            https://www.valenzuela.gov.ph/drpioscholarship 
                            <br> <br>
                            For other concerns, you may send an email to 
                            drpioscholarshiphelpdesk@gmail.com. 
                        </p> 
                    </div>
                </div>

                <div class="mySlides fade">
                    <img src="images/pic2.jpg" style="width:100%">
                    <div class="text">
                    <h2> Contract Signing </h2>
                    <hr>
                        <p> City Mayor REX Gatchalian graces the 
                            orientation and contract signing of 212 recipients of the Dr. 
                            Pio Valenzuela Scholarship program at the Pamantasan ng Lungsod 
                            ng Valenzuela (#PLV).
                            <br> <br>
                            Qualified Grantees are required to report at 
                            the Scholarship Office at PLV Maysan Campus, 2nd floor on December 
                            10 to 16, 2023 (except Saturday and Sunday) 8:00 AM to 5:00 PM. 
                            Look for Ms. Miko Tongco regarding Contract Signing and Orientation. 
                            Thank you! 
                        </p> 
                    </div>
                </div>

                <div class="mySlides fade">
                    <img src="images/pic3.jpg" style="width:100%">
                    <div class="text">
                    <h2> Results for Batch 23 </h2>
                    <hr>
                        <p> The results of the Dr. Pio Valenzuela Scholarship 
                            Program will be released on Dr. Pio's 154th Birth Anniversary on 
                            December 11, 2023. 
                            <br> <br>
                            Rightfully deserving of the grant, they are currently getting to know 
                            more about their future college journeys as Dr. Pio Valenzuela scholars. 
                            <br> <br>
                            Congratulations and make us proud, dear students! 
                        </p> 
                    </div>
                </div>
            
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>  
            <br>

            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
        </div>
    </div></center>


    <!-- LOG IN MODAL -->
    <div id="logInModal" class="logIn">
        <div class="logIn-content"> 
            <div class="infos">
                <img src="images/pio-logo.png" alt="pio">
                <h1>Log In to Pio Iskolar</h1>
                <span id="closeModal" class="close">&times;</span>
            </div>
            <br><br>

            <div class="inner-content">
                <label class="texts" for="email">Enter Email Address:</label> <br>
                <input class="inputs" type="email" id="email" name="email" placeholder="Email Address">
            </div>
            <div class="inner-content">
                <label class="texts" for="confirmPassword">Enter Password:</label> <br>
                <input class="inputs" type="password" id="password" name="password" placeholder="Password">
            </div>
            <a href="#" onclick="openModal('forgotModal')">Forgot Password</a>

            <div class="btn">
                <button class="logIn-button"> Log In </button>
            </div> <br>
        </div>
    </div>

    <!-- FORGOT PASSWORD MODAL -->
    <div id="forgotModal" class="forgot">
        <div class="forgot-content">
            <div class="infos">
                <img src="images/pio-logo.png" alt="pio">
                <h1>Forgot Password</h1>
                <span class="close" onclick="closeModal('forgotModal')">&times;</span>
            </div>
            <br><br>

            <div class="inner-content">
                <label class="texts" for="email">Enter Email Address:</label> <br>
                <input class="inputs" type="email" id="email" name="email" placeholder="Email Address">
            </div>

            <div class="btn">
                <button onclick="openModal('passModal')" class="logIn-button"> Continue </button>
            </div> <br>
        </div> 
    </div>

    <div id="passModal" class="pass">
        <div class="pass-content">
            <div class="infos">
                <img src="images/pio-logo.png" alt="pio">
                <h1>Forgot Password</h1>
                <span class="close" onclick="closeModal('passModal')">&times;</span>
            </div>
            <br><br>

            <div class="inner-content">
                <label class="texts" for="newPassword">Enter New Password:</label> <br>
                <input class="inputs" type="password" id="newPassword" name="newPassword" placeholder="New Password">
            </div>
            <div class="inner-content">
                <label class="texts" for="confirmPassword">Confirm Password:</label> <br>
                <input class="inputs" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
            </div>

            <div class="btn">
                <button class="logIn-button"> Log In </button>
            </div> <br>
        </div>
    </div>


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


        //LOG IN
        var modal = document.getElementById("logInModal");
        var span = document.getElementsByClassName("close")[0];

        document.querySelector("a[href='#']").addEventListener("click", function() {
            modal.style.display = "block";
        });
        span.onclick = function() {
            modal.style.display = "none";
        };
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };


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