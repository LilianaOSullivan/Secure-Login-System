<?php
	function escape(string $str):string {
		/*
			Escapes XSS characters.

            Parameters:
					$str (string): String to be escaped

            Returns:
                    (string): Escaped string
		*/
		$array = array(
			'&' => '&amp;',
			// ';' => '&#59;',

			'<' => '&lt;',
			'>' => '&gt;',
			'"' => '&quot;',
			"'" => '&#x27;',
			'/' => '&#x2F;',
			' ' => '&nbsp;',
			'%' => '&percnt;',
			'+' => '&plus;',
			',' => '&comma;',
			'-' => '&hyphen;',
			'=' => '&equals;',
			'^' => '&caret;',
			'{' => '&#123;',
			'}' => '&#125;',
			'(' => '&#40;',
			')' => '&#41;',
			'|' => '&#124;'
		);

		return str_replace(array_keys($array),$array,$str);
	}

	function escape(string $str):string {
		/*
			Escapes XSS characters.

            Parameters:
					$str (string): String to be escaped

            Returns:
                    (string): Escaped string
		*/
		$array = array(
			'&' => '&amp;',
			// ';' => '&#59;',

			'<' => '&lt;',
			'>' => '&gt;',
			'"' => '&quot;',
			"'" => '&#x27;',
			'/' => '&#x2F;',
			' ' => '&nbsp;',
			'%' => '&percnt;',
			'+' => '&plus;',
			',' => '&comma;',
			'-' => '&hyphen;',
			'=' => '&equals;',
			'^' => '&caret;',
			'{' => '&#123;',
			'}' => '&#125;',
			'(' => '&#40;',
			')' => '&#41;',
			'|' => '&#124;'
		);

		return str_replace(array_keys($array),$array,$str);
	}

	function escape_with_trim(string $str):string {
		/*
			Escapes XSS characters, and applies a Trim.

            Parameters:
					$str (string): String to be escaped and Trimmed

            Returns:
                    (string): Trimmed and Escaped string
		*/
		return escape(Trim($str));
	}

	function validate_password_single(string $password):bool {
		/*
			validates that a password is meeting the minimum criteria.
			It must at minimum
				- Be of length 8
				- Contain minimum 1 number
				- Contain minimum 1 lowercase letter
				- Contain minimum 1 uppercase letter
				- 1 non-alphanumeric character

            Parameters:
                    $password (string): The password to validate

            Returns:
                    (bool): true if valid, false if invalid
		*/
		return validate_password($password,$password);
	}

	function validate_password(string $password,string $confirm_password):bool {
		/*
			validates that a password is meeting the minimum criteria, with confirmation.
			It must at minimum
				- Be of length 8
				- Contain minimum 1 number
				- Contain minimum 1 lowercase letter
				- Contain minimum 1 uppercase letter
				- 1 non-alphanumeric character

            Parameters:
                    $password (string): The password to validate
                    $confirm_password (string): A confirmation of the password

            Returns:
                    (bool): true if valid, false if invalid
		*/
		if (!hash_equals($password,$confirm_password) || strlen($password) < 8) {
			return false; // Passwords don't match, or length is invalid
		}

		if (!preg_match("#[0-9]+#", $password)) {
			return false; // Contains no numbers
		}

		if (!preg_match("#[a-z]+#", $password)) {
			return false; //Contains no lowercase
		}

		if (!preg_match("#[A-Z]+#", $password)) {
			return false; //Contains no uppercase
		}

		if (!preg_match("#[^\w\d\s]+#", $password)) {
			return false; //Contains no special characters
		}

		return true;
	}

	function logout() {
		/*
			Logs a user out, and redirects them to the login screen.

            Parameters:
					None

            Returns:
                    None
		*/
		require_once("helpers/resources.php");
		if(isset($_SESSION[SESSION_USERNAME]))
		{
			session_unset();
			session_destroy();
		}
		header("Location: login.php");
		exit;
	}
?>