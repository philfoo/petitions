<?php
	
	require_once("db.php");
	//creates $conn mysqli instance
	$user = Array();
		
	$query = "SELECT * FROM users WHERE netid='" . explode("@",$_SERVER["eppn"])[0] . "';";

	//Load all rows in result
	if ($result = $conn->query($query)) {
		if ($user = mysqli_fetch_object($result)){
		//we're golden. continue.
			$user = get_object_vars($user);//final fix I hope
		} else {
			addUser($conn);
		}
	} else {
		addUser($conn);
	}
		
	function addUser($conn) {
		$add_user_query = $conn->prepare("INSERT INTO users (netid, admin, remainingvotes) VALUES(?,?,?)");
		$add_user_query->bind_param("ssss", $netid, $admin, $remainingvotes);
		$netid = explode("@",$_SERVER['eppn'])[0];
		$admin = false;
		$remainingvotes = 3;
		$add_user_query->execute();
		
		$user["netid"] = $netid;
		$user["admin"] = $admin;
		$user["remainingvotes"] = $remainingvotes;
	}
	
	//results in $user object, with properties 'netid','admin','remainingvotes', to be used in other files	
?>
