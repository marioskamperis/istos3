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

if (isset($_POST['genreSelect']) && $_POST['genreSelect'] != '') {
	$movies = $db->getMovies($_POST['genreSelect']);

}else{
	$movies= $db->getMovies(0);
}


function make_comparer() {
	// Normalize criteria up front so that the comparer finds everything tidy
	$criteria = func_get_args();
	foreach ($criteria as $index => $criterion) {
		$criteria[$index] = is_array($criterion)
			? array_pad($criterion, 3, null)
			: array($criterion, SORT_ASC, null);
	}

	return function($first, $second) use ($criteria) {
		foreach ($criteria as $criterion) {
			// How will we compare this round?
			list($column, $sortOrder, $projection) = $criterion;
			$sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

			// If a projection was defined project the values now
			if ($projection) {
				$lhs = call_user_func($projection, $first[$column]);
				$rhs = call_user_func($projection, $second[$column]);
			}
			else {
				$lhs = $first[$column];
				$rhs = $second[$column];
			}

			// Do the actual comparison; do not return if equal
			if ($lhs < $rhs) {
				return -1 * $sortOrder;
			}
			else if ($lhs > $rhs) {
				return 1 * $sortOrder;
			}
		}

		return 0; // tiebreakers exhausted, so $first == $second
	};
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AsoeeMDB</title>
	<!--	<link rel="stylesheet" type="text/css" href="css/index.css">-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
		  integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

</head>
<body style="overflow: scroll;">
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">AssoeMDB</a>
		</div>
		<ul class="nav navbar-nav">
			<li><a href="../index.php">Home</a></li>
			<li class="active"><a href="../movies/index.php">AsoeeMDB</a></li>
			<li><a href="../quiz/index.php">Quiz</a></li>
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

					$actual_link = "$_SERVER[REQUEST_URI]";
					$url="";

					if (preg_match("/order/",$actual_link)) {
						if(preg_match("/desc/",$actual_link)){
							usort($movies, make_comparer(['movie_rating', SORT_DESC]));
							$url="index.php?order=asc";

							$order_icon="<i class=\"fa fa-long-arrow-up\" aria-hidden=\"true\"></i>";

						}else{
							usort($movies, make_comparer(['movie_rating', SORT_ASC]));
							$url="index.php?order=desc";
							$order_icon="<i class=\"fa fa-long-arrow-down\" aria-hidden=\"true\"></i>";
						}
					}else{
						$url="index.php?order=asc";
					}


					echo "<tr>";
					echo "<th><a href ='index.php'>Movie ID</a></th>";
					echo "<th>Movie Title</th>";
					echo "<th>Release Date</th>";
					echo "<th>Genre</th>";
					echo "<th>Summary</th>";
					echo "<th><a href ='".$url."'>Rating</a>".$order_icon."</th>";
					echo "<th>Image</th>";
					echo "</tr>";



					foreach ($movies as $movie) {

						echo "<tr id = " . $movie['id'] . " onclick=\"window.document.location='movie.php?movie_id=" . $movie['id'] . "';\">";
						echo "<td>" . $movie['id'] . "</td>";
						echo "<td><a href='movie.php?movie_id=" . $movie['id'] . "'> " . $movie['title'] . "</a></td>";
						echo "<td>" . $movie['release_date'] . "</td>";
						echo "<td>" . $genre_lookup[$movie['genre_id']] . "</td>";
						echo "<td>" . $movie['summary'] . "</td>";
						echo "<td>" . (empty($movie['movie_rating'])?0:round($movie['movie_rating'],2)) . "/5</td>";
						echo '<td><img class ="img-thumbnail" style src="data:image/jpeg;base64,'.base64_encode( $movie['image'] ).'"/></td>';

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
