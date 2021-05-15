<?php
    require_once('_pages/_change_password.php');
?>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="static/css/main.css">
    <link rel="stylesheet" href="static/css/register.css">
    <script src="static/js/change_password.js"></script>
</head>

<body onload="password_strength()">
    <?php include("static/components/navigation.php"); ?>

    <div>
        <div class="form_outline">
            <div style="margin:30px">
                <form action="change_password.php" method="GET" onsubmit='return validate_password()'>
                    <p class="form_title">Change Password</p>
                    <div class="input_wrapper">
                        <label>Current Password 🔐</label><br />
                        <input type="password" name="current_password" placeholder="Password"/>
                    </div><br /><br />
                    <label>New Password 🤐</label><br />
                    <div class="input_wrapper">
                        <input type="password" id="password" name="password" placeholder="Password"/>
                    </div><br /><br />
                    <label>Confirm New Password 🧐</label><br />
                    <div class="input_wrapper">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password"/>
                    </div>
                    <br /><br />
                    <div class="submit_wrapper">
                        <input type="submit" value="Submit" class="submit_button"/><br />
                    </div>

                    <input type="hidden" name="token" value="<?= $_SESSION[CSRF_TOKEN]; ?>"/>
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
            <p id='password_match' style='padding-bottom:13px;' class='invalid'>Confirmed</p>
        </div>
    </div>
</body>
</html>