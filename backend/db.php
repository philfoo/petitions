<?php
	//Server information
	$host = "localhost";
	$username = "root";
	$password = "root";
	$db_name = "petitions";

	$conn = new mysqli($host, $username, $password, $db_name);

	header("Content-Type: Application/json");

	if ($conn->connect_error){
		die('{"Error": "Connection failed: ' . $conn->connect_error . '"}');
	}
?>