    <!-- CSS FILE -->
    <link rel="stylesheet" href="css/navbar.css">   
    
    <!-- HTML CODE -->
    <nav class="sidebar">
        <header>
            <div class="sideHeader">
                <span class="headerLogo">
                    <img src="images/pio-logo.png" alt="logo">
                </span>

                <div class="headerText">
                    <h1>Pio Iskolar</h1>
                </div>
            </div>
        </header> 

        <div class="navBar">
            <ul class="navLinks">
                <li class="navLink"> <a href="eval_dash.php" onclick="activateLink(this)"> 
                    <span class="icon">
                        <ion-icon name="grid-outline"></ion-icon>
                    </span>
                    <span class="text"> Dashboard </span>
                </a> </li>

                <li class="navLink"> <a href="eval_scholar.php" onclick="activateLink(this)">
                    <span class="icon">
                        <ion-icon name="school-outline"></ion-icon>
                    </span>
                    <span class="text"> Scholar </span> 
                </a> </li>

                <li class="navLink"> <a href="eval_reports.php" onclick="activateLink(this)">
                    <span class="icon">
                        <ion-icon name="stats-chart-outline"></ion-icon>
                    </span>
                    <span class="text"> Reports </span> 
                </a> </li>
            </ul>
        </div> 

        <div class="bottom-content">
            <li class="navLink"><a href="eval_faq.php">
                <span class="icon">
                    <ion-icon name="help-circle-outline"></ion-icon>
                </span>
                <span class="text"> FAQ </span>
            </a></li>

            <li class="navLink"><a href="../functions/logout.php">
                <span class="icon">
                    <ion-icon name="log-out-outline"></ion-icon>
                </span>
                <span class="text"> Log Out </span>
            </a></li>
        </div>
    </nav>

    <!-- JS CODE -->
    <script>
        //SIDEBAR
        function activateLink(link) {
            var navLinks = document.querySelectorAll('.navLink');
            navLinks.forEach(function(navLink) {
                if (navLink !== link.parentNode) {
                    navLink.classList.remove('active');
                }
            });
            
            link.parentNode.classList.add('active');
        }
    </script>