<?php
    // The navigation menu was created and modified by following this tutorial
    // https://www.w3schools.com/howto/howto_js_sidenav.asp
?>

<script src="static/js/navigation.js"></script>
<link rel="stylesheet" href="static/css/navigation.css">
<div id="navigation" class="side_nav">
    <a href="javascript:void(0)" class="close_nav" onclick="close_navigation()">&times;</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="welcome.php">Welcome</a>
    <a href="logs.php">Logs</a>
    <a href="emojis.php">Emojis 😘</a>
    <a href="change_password.php">Change Password</a>
    <a href="logout.php">Logout</a>
</div>

<div id="hamburger_menu" onclick="open_navigation()">
    <div class="hamburger_row"></div>
    <div class="hamburger_row"></div>
    <div class="hamburger_row"></div>
</div>