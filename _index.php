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
	<link rel="stylesheet" type="text/css" href="css/index.css">

</head>
<body>


<div class="parent">


	<div class="nav" id="content">
		<?php
		if ($is_logged) {
			echo '<button  id="logout" onclick="location.href=\'logout.php\'" name="logout">Logout</button>';

		} else {

			echo '<button  id="login" onclick="location.href=\'login.php\'" name="login">Login</button>';
			echo '<button  id="register" onclick="location.href=\'register.php\'" name="register">Register</button>';
		}
		?>

	</div>


	<div class="bottom" id="bottom">
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
		<div class="movies">
			<?php


			if (isset($movies) && ! empty($movies)) {
				echo "<table class = \"moviesTable\" style=\"width:100%\">";


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
					//					foreach ($movie as $key => $value) {
					//						if ($key == 'genre_id') {
					//							$value = $genre_lookup[$value];
					//						}
					//						if (empty($value)) {
					//							$value = "Missing data";
					//						}
					//
					////						$value=($key=="movie_rating")?$value."/5":"0/5";
					echo "<td>" . $movie['id'] . "</td>";
					echo "<td>" . $movie['title'] . "</td>";
					echo "<td>" . $movie['release_date'] . "</td>";
					echo "<td>" . $genre_lookup[$movie['genre_id']] . "</td>";
					echo "<td>" . $movie['summary'] . "</td>";
					echo "<td>" . $movie['movie_rating'] . "/5</td>";
					echo "<td>" . $movie['image_id'] . "</td>";
					//					}
					echo "</tr>";
				}


				echo "</table>";
			}
			?>
		</div>
	</div>
</div>

</body>
</html>
