<?php
    /*
        This file contains string constants used throughout the system.
    */

    define("SESSION_USERNAME","username"); // Username key in a session. If this is set, they are logged in
    define("SESSION_EXPIRATION_TIME","expiration_time"); // Session Key for total forced logout time
    define("SESSION_INACTIVITY","inactivity"); // Key for session activity (Eg 10 minutes)
    define("CSRF_TOKEN","csrf_token"); // Token used in Cross Site Request Forgery protection
?>