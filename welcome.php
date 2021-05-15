<?php
    require_once('_pages/_welcome.php');
?>

<html>
<head>
    <title>Welcome</title>
    <link rel="stylesheet" href="static/css/main.css">
</head>

<body>
    <?php include("static/components/navigation.php"); ?>
    <div class="form_outline">
        <div style="margin:30px">
            <div style="margin: 0 auto;text-align:center;">
                <h2>Welcome <?= $_SESSION['username'] ?> </h2>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>


