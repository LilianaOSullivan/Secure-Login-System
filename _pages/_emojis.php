<?php
    session_start();
    require_once("helpers/session.php");
    must_be_logged_in();
    check_activity_expiration();

    $emoji_code_range = [
        [0x1f600, 0x1f64e],
        [0x1f910, 0x1f91e],
        [0x1f920, 0x1f927],
        [0x1f300, 0x1f5ff],
        [0x1f680, 0x1f6c1],
        [0x1f950, 0x1f95e],
        [0x1f980, 0x1f991]
    ];

    // This emoji loop and unicode values are taken from the below link
    // https://stackoverflow.com/questions/46738692/php-foreach-loop-to-print-all-emojis
?>