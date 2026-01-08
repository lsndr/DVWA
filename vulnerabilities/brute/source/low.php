<?php

// Disable error display to users
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

// Log errors to a file instead
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/php_errors.log');

if( isset( $_GET[ 'Login' ] ) ) {
	// Get username
	$user = $_GET[ 'username' ];

	// Get password
	$pass = $_GET[ 'password' ];
	$pass = md5( $pass );

	// Check the database
	$query  = "SELECT * FROM `users` WHERE user = '$user' AND password = '$pass';";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );

	if($result === false) {
        // Log the error message to the server logs
        error_log('Database query error: ' . mysqli_error($GLOBALS["___mysqli_ston"]));
        // Display a generic error message to the user
        die('<pre>An error occurred. Please try again later.</pre>');
    }

	if( $result && mysqli_num_rows( $result ) == 1 ) {
		// Get users details
		$row    = mysqli_fetch_assoc( $result );
		$avatar = $row["avatar"];

		// Login successful
		$html .= "<p>Welcome to the password protected area {$user}</p>";
		$html .= "<img src=\"{$avatar}\" />";
	}
	else {
		// Login failed
		$html .= "<pre><br />Username and/or password incorrect.</pre>";
	}

	((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
}

?>