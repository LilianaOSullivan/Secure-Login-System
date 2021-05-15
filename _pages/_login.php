<?php
    require_once('helpers/create_db.php');

    session_start();
    require_once("helpers/db.php");

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        require_once("helpers/lockout.php");
        check_lockout($conn);

        require_once("helpers/resources.php");
        require_once("helpers/log.php");
        require_once("helpers/security.php");

        $username = escape_with_trim($_POST['username']);
        $password = escape_with_trim($_POST['password']);

        $die_message = "The username $username and password could not be authenticated at the moment";
        if(strlen($username) === 0 || strlen($password) === 0) {
            // * Empty password or username posted
            increment_attempts($conn,log_strings::LOGIN_F);
            die($die_message);
        }

        $sql = "SELECT password,salt FROM users WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s',$username);
        if(!$stmt->execute()) {
            increment_attempts($conn,log_strings::LOGIN_F);
            die($die_message);
        }
        $arr = $stmt->get_result()->fetch_assoc();
        if(!isset($arr['salt'])) {
            // * Username does not exist
            increment_attempts($conn,log_strings::LOGIN_F);
            die($die_message);
        }

        $hashed_password = hash('sha3-512',$arr['salt'] . $password);
        if(!hash_equals($hashed_password,$arr['password'])) {
            // * Password incorrect
            increment_attempts($conn,log_strings::LOGIN_F);
            die($die_message);
        }

        lockout_cleanup($conn);
        session_regenerate_id();
        write_log($conn,
                log_strings::LOGIN_S,
                sprintf(log_strings::LOGIN_S_OUTCOME,$username)
        );
        $_SESSION[SESSION_USERNAME] = $username;
        $_SESSION[SESSION_EXPIRATION_TIME] = new DateTime('+1 Hour');
        header("Location: welcome.php");
    }
?>