<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        require_once("helpers/db.php");
        require_once("helpers/security.php");
        require_once("helpers/lockout.php");
        require_once("helpers/log.php");

        check_lockout($conn);

        $die_message = "Username is taken and/or password is incorrect";
        $username = escape_with_trim($_POST['username']);
        $password = escape_with_trim($_POST['password']);
        $confirm_password = escape_with_trim($_POST['confirm_password']);

        if(empty($username)) {
            die($die_message);
        }

        if(!validate_password($password,$confirm_password)) {
            increment_attempts($conn,log_strings::REGISTRATION_F);
            die($die_message);
        }

        $sql = "SELECT username FROM users WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s',$username);
        if(!$stmt->execute())
            die($die_message);
        if(empty($stmt->get_result()->fetch_assoc()))
        {
            // * Username does not exist

            $salt = bin2hex(random_bytes(64));
            $hashed_password = hash('sha3-512', $salt . $password);
            $sql = "INSERT INTO `users` (username,password,salt) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss',$username,$hashed_password,$salt);
            if(!$stmt->execute()) {
                increment_attempts($conn,log_strings::REGISTRATION_F);
                die($die_message);
            }
            lockout_cleanup($conn);
            header("Location: login.php");
        }
        else
        {
            // * Username exists/is taken

            increment_attempts($conn,log_strings::REGISTRATION_F);
            die($die_message);
        }
    }
?>