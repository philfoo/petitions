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

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		//adds a netID as an admin
	}

	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		//List all admins (JSON)
		$query = "SELECT netid FROM users WHERE admin = 1";

		//Initialize categories array
		$admins = [];

		//Load all rows in result
		if ($result = mysqli_query($conn, $query)){
			while ($row = mysqli_fetch_object($result)){
				array_push($admins, $row);
			}
		}

		//Should output array with only admins
		echo json_encode($admins);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
		$id = $_REQUEST['netid'];

		$remove_admin_query = "UPDATE users
							   SET admin = 0
							   WHERE netid = $id";
							   
		mysqli_query($conn, $remove_admin_query);
	}
?>