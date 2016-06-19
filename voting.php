<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => false);
try {

	if (isset($_POST['user_id']) && isset($_POST['movie_id']) && isset($_POST['vote']) && ! empty($_POST['user_id']) && ! empty($_POST['movie_id']) && ! empty($_POST['vote'])) {

		// receiving the post params
		$user_id = $_POST['user_id'];
		$movie_id = $_POST['movie_id'];
		$vote = $_POST['vote'];

		$res = $db->vote($user_id,$movie_id,$vote);
		if ($res != false) {
			$response["error"] = false;
			echo json_encode($response);
		} else {
			$response["error"] = true;
			$response["error_msg"] = "Something went wrong with your vote.";
			echo json_encode($response);
		}
	} else {
		// required post params is missing
		$response["error"] = true;
		$response["error_msg"] = "Required parameters user_id or movie_id or rating are missing!";
		echo json_encode($response);
	}
} catch (Exception $e) {
	$response["error"] = true;
	$response["error_msg"] = "Exception Caught at voting.php " . $e . "";
	echo json_encode($response);
}
?>