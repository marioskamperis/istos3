<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>AsoeeMDB</title>
	<link rel="stylesheet" href="css/login.css">
</head>

<body>
<div class="wrapper">
	<div class="container">

		<div class="login">
			<form name="form" actions="login.php" method="POST" accept-charset="utf-8" autocomplete="off">
				<input type="text" name='email' id='email' placeholder="example@email.com" required>
				<input type="text" name='password' id='password' placeholder="password" required>
				<input type="submit" value="Sign In">
				<input class="btn btn-primary" type ="submit" onclick="location.href='register.php'" value="Register Now">
				<input type ="submit" onclick="location.href='index.php'" value="List Of Movies">
			</form>
		</div>
		<div class="shadow"></div>


	</div>
</div>
</body>
</html>

<?php

/**
 * File to handle all API requests
 * Accepts GET and POST
 *
 * Each request will be identified by TAG
 * Response will be JSON data
 *
 * /**
 * check for POST request
 */

// include db handler
require_once 'DB_Functions.php';
$db = new DB_Functions();

// login from browser
if (isset($_POST['email']) && $_POST['email'] != '' && isset($_POST['password']) && $_POST['password'] != '') {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$email = stripslashes($email);
	$password = stripslashes($password);

	

	$user = $db->getUserByEmailAndPassword($email, $password);
	if ( ! empty($user)) {
		echo "user found";
		session_start();
		$_SESSION['user'] = $user; // Initializing Session


		if ( ! empty($_SERVER['HTTP_CLIENT_IP'])) {
			$_SESSION['ip'] = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$_SESSION['ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		}
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
			$_SESSION['browser'] = 'Internet explorer';
		} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false) //For Supporting IE 11
		{
			$_SESSION['browser'] = 'Internet explorer';
		} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {
			$_SESSION['browser'] = 'Mozilla Firefox';
		} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false) {
			$_SESSION['browser'] = 'Google Chrome';
		} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false) {
			$_SESSION['browser'] = "Opera Mini";
		} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			$_SESSION['browser'] = "Opera";
		} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) {
			$_SESSION['browser'] = "Safari";
		} else {
			$_SESSION['browser'] = 'Something else';
		}


		$user_info = $db->loginUser($user['id'], $_SESSION['ip'], $_SESSION['browser']);

		$_SESSION['user_info'] = $user_info;
		header("location: index.php"); // Redirecting To Other Page
	} else {
		// This is in the PHP file and sends a Javascript alert to the client
		$message = "Wrong UserName or Password";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
}
?>