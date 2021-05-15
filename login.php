<?php
    require_once('_pages/_login.php');
?>
    <html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="static/css/main.css">
        <script src="static/js/login.js"></script>
    </head>
    <body>
        <?php include("static/components/navigation.php"); ?>

        <div>
            <div class="form_outline">
                <div style="margin:30px">
                <form action = "" method = "POST" onsubmit='return valid_to_send()'>
                    <p class="form_title">Login</p>
                    <label>Username 👩‍💼</label><br>
                    <div class="input_wrapper">
                        <input type = "text" id="username" name="username" placeholder="Username"/>
                    </div><br><br>
                    <label>Password 🤐</label><br>
                    <div class="input_wrapper">
                        <input type="password" id="password" name="password" placeholder="Password"/>
                    </div><br><br>
                    <div class="submit_wrapper">
                        <input type="submit" value=" Submit " class="submit_button"/><br>
                    </div>
                </form>
                <div style="text-align:center;">
                    <a href="register.php">Register account</a>
                </div>
                </div>
            </div>
        </div>
    </body>
    </html>