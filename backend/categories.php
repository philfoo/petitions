<?php
	include_once("db.php");
	//creates $conn mysqli instance

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		//adds a new category (admin access only)

		//Check for admin rights
		$user_id = $_ENV['netid'];
		$result = $conn->query("SELECT admin FROM users WHERE netid = '$user_id' LIMIT 1");
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		if ($row['admin'] == 1){
			$add_cat_query = $conn->prepare("INSERT INTO categories(category, desecription) VALUES(?,?)");
			$add_cat_query->bind_param("ss", $category, $description);
			$category = $_POST['category'];
			$description = $_POST['description'];
			$add_cat_query->execute();
		}
	}

	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		//Return JSON Array of all categories
		$query = "SELECT category FROM categories";

		//Initialize categories array
		$categories = [];

		//Load all rows in result
		if ($result = mysqli_query($conn, $query)){
			while ($row = mysqli_fetch_object($result)){
				array_push($categories, $row);
			}
		}

		//Should output array with only  categories
		echo json_encode($petitions);
	}
?>