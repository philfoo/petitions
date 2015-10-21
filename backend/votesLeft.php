<?php
	//Server information
	$host = "localhost";
	$username = "root";
	$password = "root";
	$db_name = "petitions";

	$conn = new mysqli($host, $username, $password, $db_name);

	if ($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		//Return votes left for a user
		$user = $_ENV['netid'];

		
	}

?>