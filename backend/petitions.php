<?php
	//Server information
	$host = "localhost";
	$username = "root";
	$password = "root";
	$db_name = "petitions";
	$tbl_name = "petitions";

	$conn = new mysqli($host, $username, $password, $db_name);

	if ($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		//VOTE FOR THE PETITION
		if (array_key_exists("petitionid", $_REQUEST)) {
			
			$query = $conn->prepare("INSERT INTO votes(netid, name, petitionid, comment, timestamp) VALUES(?,?,?,?,?)");
			$query->bind_param("sssss", $netid, $name, $petitionid, $comment, $timestamp);
			
			$netid = $_ENV['netid']; //From Shibboleth
			$name = $_POST['name'];
			$petitionid = $_REQUEST['petitionid']; //From URL
			$comment = $POST['comment'];
			$timestamp = $POST['timestamp'];

			$query->execute();
		}
		
		//ADD NEW PETITON TO DATABASE
		else{
			$query = $conn->prepare("INSERT INTO petitions(name, author, blurb, content, tags, category, date) VALUES(?,?,?,?,?,?,?)");
			$query->bind_param("sssssss", $name, $author, $blurb, $content, $tags, $category, $date);
			
			//Grab information from AJAX
			$name = $_POST['name'];
			$author = $_ENV['netid'];
			$blurb = $_POST['blurb'];
			$content = $_POST['content'];
			$tags = $_POST['tags'];
			$category = $_POST['category'];
			//Passed a string from AJAX hopefully
			$date = $_POST['date'];

			$query->execute();
		}

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