<?php

require_once 'DB_Functions.php';
$db = new DB_Functions();

$array = $db->getGenres();

session_start();
$user = $_SESSION['user'];
$is_logged=(!empty($user)?true:false);
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
	//	var_dump($movies);
	//	foreach ($movies as $item) {
	//		foreach ($item as $inneritem) {
	//			echo $inneritem . "\n";
	//		}
	//	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Title</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script type="text/javascript">
//		function logout{
//			alert("logged out");
//		}
//		function login{
//			alert("login out");
//		}
//		function register{
//			alert("register out");
//		}
	</script>
</head>
<body>


<div class="parent">

	<div id="content">
		<?php
		if($is_logged){
			echo'<button  id="logout" onclick="location.href=\'logout.php\'" name="logout">Logout</button>';

		}else{

			echo'<button  id="login" onclick="location.href=\'login.php\'" name="login">Login</button>';
			echo'<button  id="register" onclick="location.href=\'register.php\'" name="register">Register</button>';
		}
		?>

	</div>


	<div class="bottom" id="bottom">
		<form action="index.php" method="POST">
			<select name="genreSelect" onchange="this.form.submit()">
				<option value="0">All Genres</option>
				<?php
				foreach ($array as $item) {
					echo '<option value="' . $item[0] . '">' . $item[1] . '</option>';
				}
				?>
			</select>
		</form>
		<div class="movies">
			<?php

			if (isset($movies) && ! empty($movies)) {
				echo "<table style=\"width:100%\">";


				echo "<tr>";
				echo "<th>id</th>";
				echo "<th>title</th>";
				echo "<th>release_date</th>";
				echo "<th>genre_id</th>";
				echo "<th>image_id</th>";
				echo "<th>summary</th>";
				//		echo "</tr>";
				//		foreach ($movies as $movie) {
				//			foreach ($movie as $key => $value) {
				//				echo "<th>" . $key . "</th>";
				//			}
				//		}
				echo "</tr>";


				foreach ($movies as $movie) {

					echo "<tr>";
					foreach ($movie as $key => $value) {
						echo "<td>" . $value . "</td>";
					}
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
