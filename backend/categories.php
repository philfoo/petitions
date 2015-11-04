<?php
	require_once("db.php");
	require_once("ensureUser.php");
	//creates $conn mysqli instance and $user

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		//adds a new category (admin access only)

		//Check for admin rights
		if ($user['admin'] == 1){
			$add_cat_query = $conn->prepare("INSERT INTO categories(category, description) VALUES(?,?)");
			$add_cat_query->bind_param("ss", $category, $description);
			$category = $_POST['category'];
			$description = $_POST['description'];
			$add_cat_query->execute();
		}
	}

	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		//Return JSON Array of all categories
		$query = "SELECT * FROM categories";

		//Initialize categories array
		$categories = [];

		//Load all rows in result
		if ($result = mysqli_query($conn, $query)){
			while ($row = mysqli_fetch_object($result)){
				array_push($categories, $row);
			}
		}

		//Should output array with only  categories
		echo json_encode($categories);
	}
?>