    <!-- CSS FILE -->
    <link rel="stylesheet" href="css/navbar.css">   
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
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
                <li class="navLink"> <a href="ad_dashboard.php" onclick="activateLink(this)"> 
                    <span class="icon">
                        <ion-icon name="grid-outline"></ion-icon>
                    </span>
                    <span class="text"> Dashboard </span>
                </a> </li>

                <li class="navLink"> <a href="ad_scholar.php" onclick="activateLink(this)">
                    <span class="icon">
                        <ion-icon name="school-outline"></ion-icon>
                    </span>
                    <span class="text"> Scholars </span> 
                </a> </li>

                <!-- <li class="navLink"> <a href="ad_docs.php" onclick="activateLink(this)">
                    <span class="icon">
                        <ion-icon name="document-outline"></ion-icon>
                    </span>
                    <span class="text"> Pending Documents</span> 
                </a> </li> -->

                <li class="navLink"> <a href="ad_school.php" onclick="activateLink(this)">
                    <span class="icon">
                        <img src="images/school.png">
                    </span>
                    <span class="text"> School </span> 
                </a> </li>

                <li class="navLink"> <a href="ad_announce.php" onclick="activateLink(this)">
                    <span class="icon">
                        <ion-icon name="megaphone-outline"></ion-icon>
                    </span>
                    <span class="text"> Announcement </span>
                </a> </li>
                
                <li class="navLink"> <a href="ad_reports.php" onclick="activateLink(this)">
                    <span class="icon">
                        <ion-icon name="stats-chart-outline"></ion-icon>
                    </span>
                    <span class="text"> Reports </span>
                </a> </li>

                <li class="navLink"> <a href="ad_profile.php" onclick="activateLink(this)">
                    <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                    </span>
                    <span class="text"> My Profile </span>
                </a> </li>

                <!-- <li class="navLink"> <a href="ad_inbox.php" onclick="activateLink(this)">
                    <span class="icon">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </span>
                    <span class="text"> Inbox </span> 
                </a> </li> -->

                <!-- <li class="navLink"><a href="ad_faq.php">
                    <span class="icon">
                        <ion-icon name="help-circle-outline"></ion-icon>
                    </span>
                    <span class="text"> FAQ PLACEHOLDER</span>
                </a></li> -->
            </ul>
        </div> 

        <div class="bottom-content">
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
        // SIDEBAR
        function activateLink(link) {
            var navLinks = document.querySelectorAll('.navLink');
            navLinks.forEach(function(navLink) {
                if (navLink !== link.parentNode) {
                    navLink.classList.remove('active');
                }
            });

            link.parentNode.classList.add('active');
        }

        // Automatically add 'active' class to matching link
        document.addEventListener("DOMContentLoaded", function() {
            var currentPath = window.location.pathname.split('/').pop(); // Get the current URL path
            var navLinks = document.querySelectorAll('.navLink a'); // Get all <a> inside .navLink

            navLinks.forEach(function(link) {
                var linkPath = link.getAttribute('href').split('/').pop(); // Get href path

                // If the current URL path matches the link's href path, add 'active' to the parent <li>
                if (currentPath === linkPath) {
                    link.parentNode.classList.add('active');
                }
            });
        });
    </script>