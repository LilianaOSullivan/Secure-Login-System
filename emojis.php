<?php
    require_once("_pages/_emojis.php");
?>

<html>
<head>
    <title>Emojis! </title>
    <link rel="stylesheet" href="static/css/main.css">
    <link rel="stylesheet" href="static/css/emojis.css">
</head>

<body>
    <?php include("static/components/navigation.php"); ?>
    <div class="form_outline">
        <div style="margin:30px">
            <div style="margin: 0 auto;text-align:center;">
            <h2>You must be logged in to access this page 😇 </h2>
            <br>
                <?php
                    foreach($emoji_code_range as $range)
                        for($emoji_code=$range[0];$emoji_code<=$range[1];$emoji_code++)
                            echo html_entity_decode('&#'.$emoji_code.';', 0, 'UTF-8');
                ?>
            </div>
        </div>
    </div>
</body>
</html>