<?php
    require_once("helpers/resources.php");
    session_start();
    if(isset($_SESSION[SESSION_USERNAME]))
    {
        session_unset();
        session_destroy();
    }
    header("Location: login.php");
?>