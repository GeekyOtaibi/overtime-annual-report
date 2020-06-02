<?php

    session_start();
    if(isset($_SESSION['username']))
    { 
        unset($_SESSION['username']);
        unset($_SESSION['admin']);
        session_destroy();
        header('location:login.php');
    }

?>