<?php


if (isset($_GET['movie_id']) && ! empty($_GET['movie_id'])) {




	require_once 'DB_Functions.php';
	$db = new DB_Functions();

//	$ok= $db->vote(1, 1 ,2);
//	echo $ok;
//	exit;
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
		echo "<script>var is_logged=true;</script>";
		//		var_dump($user['id']);
		$user_rating = $db->getUserRating($user['id'], $movie_id);
		$user_rating = $user_rating['rating'];
		$numberOfVoters = $db->getNumberofVoters($movie_id);
		$numberOfVoters = $numberOfVoters['voters'];
	} else {
		$is_logged = false;
		echo "<script>var is_logged=false;</script>";
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
		  integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
</head>
<body style="overflow: scroll;">
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">AsoeeMDB</a>
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
		<div
			class="col-md-4"><?php echo '<td><img class ="img-thumbnail" style src="data:image/jpeg;base64,' . base64_encode($movie['image']) . '"/></td>'; ?></div>
		<div class="col-md-4"></div>
	</div>

	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-2"><span>Title: </span></div>
		<div class="col-md-2">
			<span class="value"><?php echo $movie['title']; ?></span></div>
		<div class="col-md-4"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-2"><span>Release Date:</span></div>
		<div class="col-md-2"><span class="value"><?php echo $movie['release_date']; ?></span></div>
		<div class="col-md-4"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-2"><span>Genre:</span></div>
		<div class="col-md-2"><span class="value"><?php echo $genre_lookup[$movie['genre_id']]; ?></span></div>
		<div class="col-md-4"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-2"><span>Summary: </span></div>
		<div class="col-md-2"><span class="value"><?php echo $movie['summary']; ?></span></div>
		<div class="col-md-4"></div>
	</div>

	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-2"><span>
					<?php
					if ($is_logged) {
						echo "Your Rating";
					} else {
						echo "Public Rating";
					}
					?>
				</span></div>
		<div class="col-md-1"><span id="rating">
					<?php
					if ($is_logged) {
						if (empty($user_rating) || $user_rating == false) {
							echo "You have not Voted yet for this movie";
						} else {
							echo round($user_rating, 2) . " out of 5 stars";
						}
					} else {
						echo round($movie_rating, 2) . " out of 5 stars ";
					}
					?>
				</span></div>
		<div class="col-md-1"><span class="value" id="voters"><?php echo $numberOfVoters." Voters"; ?></span></div>
		<div class="col-md-4"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4"><span class="star-system">
					<?php
					$stars = "<div onchange='getVote();' class=\"stars\"><form action=\"\">
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
							  </form></div>";

					if ($is_logged) {
						echo $stars;
						$user_rating = intval($user_rating);

						if ($user_rating != 0) {
							echo "<script>var rating=".$user_rating.";</script>";
							echo "<script> document.getElementById(\"star-" . $user_rating . "\").checked=true;</script>";
						}
					} else {
						echo $stars;
						$movie_rating = intval($movie_rating);
						if ($movie_rating != 0) {
							echo "<script>var rating=".$movie_rating.";</script>";
							echo "<script>document.getElementById(\"star-" . $movie_rating . "\").checked=true;</script>";
						}

					}

					?>

				</span></div>
		<div class="col-md-4"></div>
	</div>
<!--	<div class="row">-->
<!--		<div class="col-md-4"></div>-->
<!--		<div class="col-md-2"><span>Number Of Voters</span></div>-->
<!--		<div class="col-md-2"><span class="value" id="voters">--><?php //echo $numberOfVoters; ?><!--</span></div>-->
<!--		<div class="col-md-4"></div>-->
<!--	</div>-->
</div>

</body>
<script type="text/javascript">

	function getVote()
	{
		var els = document.getElementsByClassName("star");
		Array.prototype.forEach.call(els, function (el)
		{
			// Do stuff here
			if (el.checked == true) {
				var vote = el.id;
				vote = vote.substr(vote.length - 1);
				if (is_logged == false) {
					alert("You must login to vote.");
					document.getElementById("star-"+vote).checked=false;
					return;
				}else{
					loadDoc(vote);
				}

			}

		});

	}

	function loadDoc(vote)
	{

		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function ()
		{
			if (xhttp.readyState == 4 && xhttp.status == 200) {

				var response = JSON.parse(xhttp.responseText);


				if (response.error == false) {
					alert("Your Voting was submitted successfully");
					document.getElementById("rating").innerHTML = vote + " out of 5 stars";

//					var voters = document.getElementById("voters").innerHTML;
//					voters= parseInt(voters);
//					voters++;
//					document.getElementById("voters").innerHTML = voters;

				} else {
					alert("Something went wrong during voting. Please try again later.");
				}

			}
		};
		var postvars = "user_id=" + <?php echo $user['id'];?> +"&movie_id=" + <?php echo $movie_id;?> +"&vote=" + vote;


		xhttp.open("POST", "voting.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//		xhttp.setRequestHeader("Content-length", postvars.length);
		//		xhttp.setRequestHeader("Connection", "close");
		xhttp.send(postvars);

	}

</script>
</html>

