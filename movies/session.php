<?php
include('DB_Connect.php');
?>
<?php

session_start();// Starting Session
// Storing Session
$user_check = $_SESSION['login_user'];
// SQL Query To Fetch Complete Information Of User
$ses_sql = mysqli_query("select name from users where name='$user_check'", $connection);
$row = mysqli_fetch_assoc($ses_sql);
$login_session = $row['username'];
if ( ! isset($login_session)) {
	mysqli_close($connection); // Closing Connection
	header('Location: login.php'); // Redirecting To Home Page
}
?>