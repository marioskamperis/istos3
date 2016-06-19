<?php


if (isset($_GET['movie_id']) && ! empty($_GET['movie_id'])) {

	require_once 'DB_Functions.php';
	$db = new DB_Functions();

	session_start();

	//Lookup Table for genres
	$genres = $db->getGenres();
	$genre_lookup = array();
	foreach ($genres as $item) {
		$genre_lookup[$item[0]] = $item[1];
	}
	unset($genre);
	//Lookup Table for genres

	//GET Movie

	$movie_id = $_GET['movie_id'];
	$movie = $db->getMovie($movie_id);
	//GET Movie

	//Decide Data to show user
	if (isset($_SESSION['user']) && ! empty($_SESSION['user'])) {
		$user = $_SESSION['user'];
		$is_logged = true;
		//		var_dump($user['id']);
		$user_rating = $db->getUserRating($user['id'], $movie_id);
		$user_rating = $user_rating['rating'];

		$numberOfVoters = $db->getNumberofVoters($movie_id);

		$numberOfVoters = $numberOfVoters['voters'];
	} else {
		$is_logged = false;
		$movie_rating = $db->getMovieRating($movie_id);
		$movie_rating = $movie_rating['average'];

		$numberOfVoters = $db->getNumberofVoters($movie_id);

		$numberOfVoters = $numberOfVoters['voters'];
	}
	//Decide Data to show user

} else {
	header("location: index.php"); // Redirecting To Other Page
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Title</title>
	<link rel="stylesheet" type="text/css" href="css/movie.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
</head>
<body>
<div class="parent">
	<div class="top">
		<div id="content">
			<?php
			if ($is_logged) {
				echo '<button  id="logout" onclick="location.href=\'logout.php\'" name="logout">Logout</button>';
				echo '<button  id="home" onclick="location.href=\'index.php\'" name="logout">Home</button>';

			} else {

				echo '<button  id="login" onclick="location.href=\'login.php\'" name="login">Login</button>';
				echo '<button  id="register" onclick="location.href=\'register.php\'" name="register">Register</button>';
				echo '<button  id="home" onclick="location.href=\'index.php\'" name="logout">Home</button>';
			}
			?>

		</div>
		<div class="top">
			<img src="images/img1.jpg" id="profile_pic"/>
		</div>
	</div>
	<div class="bottom">
		<div class="movie">
			<div class="movie-info">
				<span class="label">Title: </span><span class="value"><?php echo $movie['title']; ?></span>
			</div>
			<div class="movie-info">
				<span class="label">Release Date: </span><span class="value"><?php echo $movie['release_date']; ?></span>
			</div>
			<div class="movie-info">
				<span class="label">Genre: </span><span class="value"><?php echo $genre_lookup[$movie['genre_id']]; ?></span>
			</div>
			<div class="movie-info">
				<span class="label">Summary: </span><span class="value"><?php echo $movie['summary']; ?></span>
			</div>
			<div class="movie-info">
				<span class="label">
					<?php
					if ($is_logged) {
						echo "Your Rating";
					} else {
						echo "Public Rating";
					}
					?>
				</span>
				<span class="value">
					<?php
					if ($is_logged) {
						if (empty($user_rating) || $user_ratin==false) {
							echo "You have not Voted yet for this movie";
						} else {
							echo round($user_rating, 2) . " out of 5 stars";
						}
					} else {
						echo round($movie_rating, 2) . " out of 5 stars";
					}
					?>
				</span>
			</div>
			<div class="movie-info">
				<span class="star-system">
					<?php
					$stars = "<div class=\"stars\">
  <form action=\"\">
    <input class=\"star star-5\" id=\"star-5\" type=\"radio\" name=\"star\"/>
    <label class=\"star star-5\" for=\"star-5\"></label>
    <input class=\"star star-4\" id=\"star-4\" type=\"radio\" name=\"star\"/>
    <label class=\"star star-4\" for=\"star-4\"></label>
    <input class=\"star star-3\" id=\"star-3\" type=\"radio\" name=\"star\"/>
    <label class=\"star star-3\" for=\"star-3\"></label>
    <input class=\"star star-2\" id=\"star-2\" type=\"radio\" name=\"star\"/>
    <label class=\"star star-2\" for=\"star-2\"></label>
    <input class=\"star star-1\" id=\"star-1\" type=\"radio\" name=\"star\"/>
    <label class=\"star star-1\" for=\"star-1\"></label>
  </form>
</div>";

					if ($is_logged) {


						echo $stars;
						$user_rating = intval($user_rating);
						echo "<script> document.getElementById(\"star-" . $user_rating . "\").checked=true;</script>";
					} else {
						echo $stars;
						$movie_rating = intval($movie_rating);
						echo "<script>document.getElementById(\"star-" . $movie_rating . "\").checked=true;</script>";
					}

					?>

				</span>
			</div>
			<div class="movie-info">
				<span class="label">Number Of Voters</span>
				<span class="value"><?php echo $numberOfVoters; ?></span>
			</div>
		</div>

	</div>
</div>

</body>
<script type="text/javascript">

</script>
</html>

<!--<div class=\"rating\" id = \"movie_rating_".$movie_id."\"><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></div>"-->

