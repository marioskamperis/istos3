<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AsoeeMDB</title>
	<link rel="stylesheet" type="text/css" href="index.css">
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
			<li class="active"><a href="../index.php">Home</a></li>
			<li><a href="movies/index.php">AsoeeMDB</a></li>
			<li><a href="quiz/index.php">Quiz</a></li>
		</ul>
	</div>
</nav>
<div class="row"></div>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-5">
		<input onclick="movies()" style="width:80%;" type="submit" value="AsoeeMDB " id="button" class="btn btn-primary"/>
	</div>
	<div class="col-md-5">
		<input onclick="quiz()" style="width:80%;" type="submit" value="Quiz" id="button" class="btn btn-success"/>
	</div>
	<div class="col-md-1"></div>

</div>
<div class="row"></div>
</body>
</html>
<script>
	function quiz()
	{
		window.location.href = "quiz/index.php";
	}

	function movies()
	{
		window.location.href = "movies/index.php";
	}
</script>
