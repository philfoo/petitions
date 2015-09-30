<?php
	//Server information
	$host = "colab-sbx-31@oit.duke.edu";
	$username = "root";
	$password = "root";
	$db_name = "petitions";
	$tbl_name = "petitions";

	//Create connection
	$conn = new mysqli($host, $username, $password, $dbname);

	if ($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		//add to the database here
		
		//Prepared statement
		$query = $conn->prepare("INSERT INTO petitions(name, author, blurb, content, tags, category, date) VALUES(?,?,?,?,?,?,?)");
		$query->bind_params("sssssss", $name, $author, $blurb, $content, $tags, $category, $date);
		
		//Grab information from AJAX
		$name = $_POST['name'];
		$author = $_POST['author'];
		$blurb = $_POST['blurb'];
		$content = $_POST['content'];
		$tags = $_POST['tags'];
		$category = $_POST['category'];
		//Passed a string from AJAX hopefully
		$date = $_POST['date'];

		$query->execute();

	}

	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		
		$query = "SELECT * FROM petitions";

		//Initialize petitions array with PHP objects
		$petitions = [];

		//Load all rows in result
		if ($result = mysqli_query($conn, $query)){
			while ($row = mysqli_fetch_object($result)){
				array_push($petitions, $row);
			}
		}

		echo json_encode($petitions);
	}
?>