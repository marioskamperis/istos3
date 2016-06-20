<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Title</title>
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
<div class="row"></div>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4"><button type="button" onclick ="start()" class="btn btn-primary">START THE QUIZ</button></div>
	<div class="col-md-4"></div>

</div>
<div class="row"></div>
</body>
</html>
<script>
	function start(){
		window.location.href="index.php?start=true"
	}
</script>
<?php
/**
 * Created by PhpStorm.
 * User: Marios
 * Date: 6/20/2016
 * Time: 8:20 PM
 */