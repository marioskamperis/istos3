<?php

require_once 'DB_Functions.php';
$db = new DB_Functions();

$genres = $db->getGenres();
$genre_lookup = array();
foreach ($genres as $item) {
	$genre_lookup[$item[0]] = $item[1];
}
unset($genre);

session_start();
$user = $_SESSION['user'];
$is_logged = (! empty($user) ? true : false);

//
//echo __DIR__;
//$file= "images/img1.jpg";
//$img= file_get_contents($file);
//$size = getimagesize($img);
//echo $img;
//echo $size;
//
//$db->storeImage($img,1);
//
//exit;
// login from browser
//echo $_POST['genreSelect'];

if (isset($_POST['genreSelect']) && $_POST['genreSelect'] != '') {
	$movies = $db->getMovies($_POST['genreSelect']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Title</title>
	<!--	<link rel="stylesheet" type="text/css" href="css/index.css">-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
		  integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</head>
<body>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">AssoeMDB</a>
		</div>
		<ul class="nav navbar-nav">
			<li class="active"><a href="index.php">Movies</a></li>
			<?php
			if ($is_logged) {
				echo '<li><a href="logout.php">Logout</a></li>';

			} else {

				echo '<li><a href="login.php">Login</a></li>';
				echo '<li><a href="register.php">Register</a></li>';
			}
			?>
		</ul>
	</div>
</nav>


<div class="parent">

	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<form action="index.php" method="POST">
				<select class="form-control" name="genreSelect" onchange="this.form.submit()">
					<option value="0">All Genres</option>
					<?php
					foreach ($genre_lookup as $key => $value) {
						echo '<option value="' . $key . '">' . $value . '</option>';
					}
					?>
				</select>
			</form>
		</div>
		<div class="col-md-4"></div>

	</div>
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<table class="table table-striped table-hover">
				<?php


				if (isset($movies) && ! empty($movies)) {


					echo "<tr>";
					echo "<th>id</th>";
					echo "<th>title</th>";
					echo "<th>release_date</th>";
					echo "<th>genre_id</th>";
					echo "<th>summary</th>";
					echo "<th>movie_rating</th>";
					echo "<th>image_id</th>";
					echo "</tr>";

					foreach ($movies as $movie) {

						echo "<tr id = " . $movie['id'] . " onclick=\"window.document.location='movie.php?movie_id=" . $movie['id'] . "';\">";
						echo "<td>" . $movie['id'] . "</td>";
						echo "<td><a href='movie.php?movie_id=" . $movie['id'] . "'> " . $movie['title'] . "</a></td>";
						echo "<td>" . $movie['release_date'] . "</td>";
						echo "<td>" . $genre_lookup[$movie['genre_id']] . "</td>";
						echo "<td>" . $movie['summary'] . "</td>";
						echo "<td>" . (empty($movie['movie_rating'])?0:$movie['movie_rating']) . "/5</td>";
						echo "<td>" . $movie['image_id'] . "</td>";
						echo "</tr>";
					}


				}
				?>
			</table>
		</div>
		<div class="col-md-1"></div>

	</div>
</div>
</div>

</body>
</html>
