<?php
    session_start();
    require_once("helpers/session.php");
    must_be_logged_in();
    check_activity_expiration();

    if(isset($_GET['current_password'])
        && isset($_GET['password'])
        && isset($_GET['confirm_password'])
        && isset($_GET['token']))
    {
        require_once("helpers/db.php");
        require_once("helpers/security.php");
        require_once("helpers/resources.php");

        $die_message = "The provided passwords cannot be verified at the moment.";

        $current_password = escape_with_trim($_GET['current_password']);
        $password = escape_with_trim($_GET['password']);
        $confirm_password = escape_with_trim($_GET['confirm_password']);
        $csrf_token = escape_with_trim($_GET['token']);

        if(!isset($_SESSION[CSRF_TOKEN])
            || !hash_equals($csrf_token,$_SESSION[CSRF_TOKEN]))
        {
            $_SESSION[CSRF_TOKEN] = bin2hex(random_bytes(64));
            die("🚨 CSRF Failed to verify 🚨");
            //die($die_message);
        }

        if(empty($current_password)
            || empty($password)
            || empty($confirm_password)
            || !validate_password($password,$confirm_password)
            || !validate_password_single($current_password))
        {
            $_SESSION[CSRF_TOKEN] = bin2hex(random_bytes(64));
            die($die_message);
        }

        $sql = "SELECT password,salt FROM `users` WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s',$_SESSION[SESSION_USERNAME]);
        if(!$stmt->execute())
        {
            $_SESSION[CSRF_TOKEN] = bin2hex(random_bytes(64));
            die($die_message);
        }
        $arr = $stmt->get_result()->fetch_assoc();
        if(empty($arr))
        {
            $_SESSION[CSRF_TOKEN] = bin2hex(random_bytes(64));
            die($die_message);
        }

        $salt = $arr['salt'];
        $hash_algo = 'sha3-512';
        $hashed_password = hash($hash_algo,$salt . $current_password);
        if(!hash_equals($hashed_password,$arr['password'])) {
            $_SESSION[CSRF_TOKEN] = bin2hex(random_bytes(64));
            die($die_message);
        }

        $salt = bin2hex(random_bytes(64));
        $hashed_password = hash($hash_algo,$salt . $password);
        $sql = "UPDATE `users` SET password = ?,salt = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss',$hashed_password,$salt,$_SESSION[SESSION_USERNAME]);
        if(!$stmt->execute()) {
            $_SESSION[CSRF_TOKEN] = bin2hex(random_bytes(64));
            die($die_message);
        }
        logout();
    }
    else {
        $_SESSION[CSRF_TOKEN] = bin2hex(random_bytes(64));
    }
?>