<?php
	
	include_once("db.php");
	//creates $conn mysqli instance

	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		
		$query = "SELECT * FROM users WHERE netid=" + $_SERVER["eppn"];

		//Load all rows in result
		if ($result = mysqli_query($conn, $query)){
			while ($user = mysqli_fetch_object($result)){
				echo json_encode($petitions);
			}
		}

	}

?>