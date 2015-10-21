<?php
	
	require_once("db.php");
	//creates $conn mysqli instance
	$user = Array();

	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		
		$query = "SELECT * FROM users WHERE netid=" + explode("@",$_SERVER["eppn"])[0];

		//Load all rows in result
		if ($result = mysqli_query($conn, $query)){
			if ($user = mysqli_fetch_object($result)){
				//we're golden. continue.
			} else {
				addUser();
			}
		} else {
			addUser();
		}

	}
	
	function addUser() {
		$add_user_query = $conn->prepare("INSERT INTO users (netid, admin, remainingvotes, lastvote) VALUES(?,?,?,?)");
		$add_user_query->bind_param("ss", $netid, $admin);
		$netid = explode("@",$_SERVER['eppn'])[0];
		$admin = false;
		$remainingvotes = 3;
		$lastvote = 0; //1970
		$add_user_query->execute();
		
		$user["netid"] = $netid;
		$user["admin"] = $admin;
		$user["remainingvotes"] = $remainingvotes;
		$user["lastvote"] = $lastvote;
	}

?>
