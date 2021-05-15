<?php
    require_once("helpers/lockout.php");
    abstract class log_strings {
        // Actions --
        const LOGIN_S = "LOGIN SUCCESS";
        const LOGIN_F = "LOGIN FAILED";
        const REGISTRATION_F = "REGISTRATION_FAILED";

        // Outcomes --
        const LOGIN_S_OUTCOME = "Login by %s. Created session variables.";
    }

    function write_log($conn,string $action,string $outcome="") {
        $ip = escape_with_trim((
            request_from_ips()
                ? $_SERVER['REMOTE_ADDR']
                : $_SERVER['HTTP_CLIENT_IP']
        ));
        $sql = "CALL write_log(?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss',$action,$ip,$outcome);
        if(!$stmt->execute()) {
            echo $stmt->error;
        }
    }
?>