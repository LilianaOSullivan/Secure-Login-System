<?php
    require_once("helpers/resources.php");
    require_once("helpers/security.php");
    require_once("helpers/log.php");

    function request_from_ips($whitelist = ['127.0.0.1', '::1','localhost']):bool {
        /*
			Checks if a request is from a defined set of IP addresses. Defaults to localhost

            Parameters:
					$whitelist (array): Array of IPs to check.

            Returns:
                    (bool): True if request originated from whitelist IPs, otherwise False
		*/
        if(isset($_SERVER['REMOTE_ADDR'])) {
            return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
        }
        return false;
    }

    function check_lockout($conn)
    {
        /*
			Checks for a lockout. If a lockout is currently applied, an error message is displayed.

            Parameters:
                    $conn: Connection to the database.

            Returns:
                    null
		*/

        $useragent = escape_with_trim($_SERVER["HTTP_USER_AGENT"]);
        $ip = escape_with_trim((
            request_from_ips()
                ? $_SERVER['REMOTE_ADDR']
                : $_SERVER['HTTP_CLIENT_IP']
        ));
        $sql = "SELECT * FROM `lockout` WHERE ip = ? AND useragent = ? AND until > CURRENT_TIMESTAMP LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss',$ip,$useragent);
        if(!$stmt->execute()) {
            echo $stmt->error;
        }
        $arr = $stmt->get_result()->fetch_assoc();
        if(!empty($arr)) // * Lockout exists
        {
            $d = new DateTime($arr['until']);
            $curr = new DateTime('-1 hour'); // Timezone adjustment
            $diff = $d->diff($curr);
            if($diff->i > 0)
            {
                $seconds = "";
                if($diff->s > 0)
                    $seconds = " and $diff->s seconds";
                $message = 'You are locked out for ' . $diff->i . ' minute(s)' . $seconds;
                die($message);
            }
            die('You are locked out for  '. $diff->s . ' seconds');
        }
    }

    function increment_attempts($conn,string $action="") {
        /*
			Increments login attempts, and locks out a user if the limit is reached.

            Parameters:
                    $conn: Connection to the database.

            Returns:
                    null
		*/

        $useragent = escape_with_trim($_SERVER["HTTP_USER_AGENT"]);
        $ip = escape_with_trim((
            request_from_ips()
                ? $_SERVER['REMOTE_ADDR']
                : $_SERVER['HTTP_CLIENT_IP']
        ));
        $sql = "CALL sp_lockout(?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss',$ip,$useragent,$action);
        if(!$stmt->execute()) {
            echo $stmt->error;
        }

        check_lockout($conn);
    }

    function lockout_cleanup($conn) {
        /*
            Resets lockout attempts to zero for the IP and useragent for this request.

            Parameters:
                    None

            Returns:
                    null
        */
        $sql = "UPDATE `lockout` SET attempts = 0 WHERE ip = ? AND useragent = ?";
        $useragent = escape_with_trim($_SERVER["HTTP_USER_AGENT"]);
        $ip = escape_with_trim((
            request_from_ips()
                ? $_SERVER['REMOTE_ADDR']
                : $_SERVER['HTTP_CLIENT_IP']
        ));
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss',$ip,$useragent);
        if(!$stmt->execute()) {
            echo $stmt->error;
        }
    }

?>