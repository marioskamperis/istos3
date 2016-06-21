<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AsoeeQUIZ</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
		  integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

</head>
<body>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">Quiz</a>
		</div>
		<ul class="nav navbar-nav">
			<li><a href="../index.php">Home</a></li>
			<li><a href="../movies/index.php">AsoeeMDB</a></li>
			<li class="active"><a href="../quiz/index.php">Quiz</a></li>
		</ul>
	</div>
</nav>
<div class="row"></div>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<form action="index.php" method="post">
			<input type="text" name="start" value="true" hidden><br>
			<input onclick="start()" type="submit" value="START THE QUIZ" id="button" class="btn btn-primary"/>
		</form>
	</div>
	<div class="col-md-4"></div>

</div>
<div class="row"></div>
</body>
</html>
<script>
	function start()
	{
		window.location.href = "index.php?start=true"
	}
</script>
<?php
/**
 * Created by PhpStorm.
 * User: Marios
 * Date: 6/20/2016
 * Time: 8:20 PM
 */
if (isset($_POST['start']) && ! empty($_POST['start'])) {
	include_once ("DB_Functions.php");
	$db= new DB_Functions();

	session_start();
	$_SESSION['startTime']=microtime(true);
	$_SESSION['no_of_question']=0;
	$_SESSION['correct_answers']=0;
	$questions=$db->getQuestions();
	var_dump($questions);

	$_SESSION['questions']=$questions;
	header("Location: quiz.php");
	
}
?>