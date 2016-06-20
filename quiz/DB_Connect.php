<?php

class DB_Connect
{

	// constructor
	function __construct()
	{

	}

	// destructor
	function __destruct()
	{
		// $this->close();
	}

	// Connecting to database
	public function connect()
	{

		require_once 'Config.php';
		// connecting to mysqli
		$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		// selecting database
		// return database handler

		return $con;
	}

	// Closing database connection
	public function close()
	{
		mysqli_close();
	}

}

?>