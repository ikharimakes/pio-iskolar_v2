<?php
    session_unset();
    session_destroy();

    header('Location: ../html/front_page.php');
    exit();
?>