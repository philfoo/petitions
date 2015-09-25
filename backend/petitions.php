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
		//Generate PHP array, convert to JSON file
	}
?>