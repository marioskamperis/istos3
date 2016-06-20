<?php
error_reporting(E_ERROR | E_PARSE);

class DB_Functions
{

	private $db;
	private $con;

	//put your code here
	// constructor
	function __construct()
	{
		require_once 'DB_Connect.php';
		// connecting to database
		$this->db = new DB_Connect();
		$this->con = $this->db->connect();

	}

	// destructor
	function __destruct()
	{

	}


	public function getUsers()
	{
		$all_users = mysqli_query($this->con, "SELECT * FROM users");
		return mysqli_fetch_array($all_users);

	}

	public function getUserInfo($id)
	{
		$user_info = mysqli_query($this->con, "SELECT * FROM user_info WHERE user_id='$id'");
		$return = mysqli_fetch_array($user_info);

	}


	public function getQuestions()
	{

		$sql = "SELECT * FROM istos3.quiz ORDER BY RAND() LIMIT 6";
		$result = mysqli_query($this->con, $sql);


		while ($row = mysqli_fetch_assoc($result)) {
			$question_array[] = $row;
		}
		
		if ( ! empty($question_array)) {
			return $question_array;
		} else {
			return false;
		}


	}

}

?>