<?php
	require_once("db.php");
	require_once("ensureUser.php");
	//creates $conn mysqli instance

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
?>