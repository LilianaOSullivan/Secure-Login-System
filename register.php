<?php
    require_once('_pages/_register.php');
?>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="static/css/main.css">
    <link rel="stylesheet" href="static/css/register.css">
    <script src="static/js/register.js"></script>
</head>

<body onload="password_strength()">
    <?php include("static/components/navigation.php"); ?>

    <div>
        <div class="form_outline">
            <div style="margin:30px">
                <form action="register.php" method="POST" onsubmit='return validate_password()'>
                    <p class="form_title">Register</p>
                    <div class="input_wrapper">
                        <label>Username 👩‍💼</label><br>
                        <input type="text" id ="username" name="username" placeholder="Username"/>
                    </div><br /><br />
                    <label>Password 🤐</label><br>
                    <div class="input_wrapper">
                        <input type="password" id="password" name="password" placeholder="Password"/>
                    </div><br /><br />
                    <label>Confirm Password 🧐</label><br>
                    <div class="input_wrapper">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password"/>
                    </div>
                    <br /><br />
                    <div class="submit_wrapper">
                        <input type="submit" value="Submit" class="submit_button"/><br />
                    </div>
                </form>
            </div>
        </div>
        <div class="password_div_invalid" id="password_div">
            <h4 style="padding-top:4px;">A password should be</h4>
            <p id='lowercase' class='invalid'><b>1</b> lowercase letter</p>
            <p id='uppercase' class='invalid'><b>1</b> uppercase letter</p>
            <p id='numbers' class='invalid'><b>1</b> number</p>
            <p id='special_char' class='invalid'><b>1</b> special character</p>
            <p id='length' class='invalid'><b>8</b> characters minimum</p>
            <hr class="hr_invalid" id="hr">
            <p id='password_match' class='invalid'>Confirmed</p>
            <p id='username_empty' style='padding-bottom:13px;' class='invalid'>Entered username</p>
        </div>
    </div>
</body>
</html>