<?php
    session_start();
    require_once("helpers/session.php");
    must_be_logged_in();
    check_activity_expiration();
?>