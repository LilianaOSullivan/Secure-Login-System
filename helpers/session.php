<?php
    require_once('helpers/resources.php');
    require_once('helpers/security.php');

    function must_be_logged_in() {
        /*
			Checks if a user is logged in.
            If they are not logged in, they are redirect to the login screen.

            Parameters:
					None

            Returns:
                    null
		*/
        session_regenerate_id();
        if(!isset($_SESSION[SESSION_USERNAME]))
        {
            header("Location: login.php");
            exit;
        }
    }

    function must_be_admin($conn) {
        /*
			Checks if a logged in user is an admin.
            If they are not logged in, they are redirect to the login screen.
            If they are not an admin, a die message is displayed.

            Parameters:
					None

            Returns:
                    null
		*/
        must_be_logged_in();
        $username = $_SESSION[SESSION_USERNAME];
        $sql = "SELECT username FROM users WHERE username = ? AND admin = 1 LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s',$username);
        if(!$stmt->execute()) {
            die("This page is currently unavailable.");
        }
        $arr = $stmt->get_result()->fetch_assoc();
        if(empty($arr)) {
            die("You must be an admin to access this page");
        }
    }

    function check_max_session_expiration() {
        /*
			Checks if the forced logout period has been reached.
            It will log the user out if time reached.

            Parameters:
					None

            Returns:
                    null
		*/
        if($_SESSION[SESSION_EXPIRATION_TIME] < new DateTime()) {
            logout();
        }
    }

    function check_session_inactivity() {
        /*
			Checks if the inactivity period has been reached.
            It will log the user out if time reached.

            Parameters:
					None

            Returns:
                    null
		*/
        if(isset($_SESSION[SESSION_INACTIVITY]) && $_SESSION[SESSION_INACTIVITY] < new DateTime()) {
            logout();
        }
        $_SESSION[SESSION_INACTIVITY] = new DateTime('+10 minutes');
    }

    function check_activity_expiration() {
        /*
			Checks both forced logout and inactivity periods.
            It will log the user out if any periods are reached.

            Parameters:
					None

            Returns:
                    null
		*/
        check_max_session_expiration();
        check_session_inactivity();
    }
?>