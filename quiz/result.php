<?php
session_start();


$finishTime = time();
$time = round(microtime(true) - $_SESSION["startTime"], 2);

//echo $_SESSION['startTime'];
//echo $_SESSION['correct_answers'];
session_destroy();
?>

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
			<li class="active"><a href="index.php">Home</a></li>
		</ul>
	</div>
</nav>
<div class="row">

	<div class="col-md-2"></div>
	<div class="col-md-2">Your Time was :</div>
	<div class="col-md-2">
		<h4><b><?php echo $time; ?>seconds</b></h4>

	</div>
	<div class="col-md-2"></div>
</div>
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-2">Your Score is :</div>
	<div class="col-md-2"><h4><b><?php echo $_SESSION['correct_answers']; ?> correct answers Out of 6</b></h4></div>
	<div class="col-md-2"></div>
</div>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<form action="index.php" method="post">
			<input type="text" name="start" value="true" hidden><br>
			<input onclick="start()" type="submit" value="START THE QUIZ AGAIN" id="button" class="btn btn-primary"/>
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
