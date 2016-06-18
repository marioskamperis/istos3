<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Texnoligies Kai Programatismos</title>
	<link rel="stylesheet" href="css/register.css">
</head>

<body>
<div class="wrapper">
	<div class="container">
		<div class="login">
			<form name="form" actions="register.php" method="POST" accept-charset="utf-8" autocomplete="off">

				<input type="text" name='name' id='name' placeholder="FullName" required>
				<input type="text" name='email' id='email' placeholder="example@email.com" required>
				<!--				set password field as text to prevent autocompleye-->
				<input type="text" name='password' id='password' placeholder="password" required>
				<input type="submit" value="Register Now">
			</form>
		</div>
		<div class="shadow"></div>

	</div>

</body>
</html>
<?php

// include db handler
require_once 'DB_Functions.php';
$db = new DB_Functions();
/**
 * Registering a user device
 * Store reg id in users table
 */


if (isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["email"])) {

	$email = $_POST["email"];
	$password = $_POST["password"];
	$name = $_POST["name"];
	$res = $db->storeUser($email, $password, $name);

//	var_dump($res);
	$error = $res["error"];
	$msg = $res["msg"];
	if ($error == true) {
		echo '<script> alert("'.$msg.'"); </script>';
	} else {
		header("Location: login.php");
		die();
	}
}
?>
