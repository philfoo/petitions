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
			$comment = $_POST['comment'];
			$timestamp = $_POST['timestamp'];
			$query->execute();

			//Update votes count
			$votes_result = $conn->query("SELECT *FROM votes WHERE petitionid = '$petitionid'");
			$numvotes = $votes_result->num_rows;
			$votes_query = "UPDATE petitions
							SET count = $numvotes
							WHERE id = $petitionid";
			mysqli_query($conn, $votes_query);
		}
		
		//ADD NEW PETITON TO DATABASE
		else{
			$query = $conn->prepare("INSERT INTO petitions(name, author, blurb, content, tags, category, date) VALUES(?,?,?,?,?,?,?)");
			$query->bind_param("sssssss", $name, $author, $blurb, $content, $tags, $category, $date);
			
			//Grab info from AJAX
			$name = $_POST['name'];
			$author = $_ENV['netid'];
			$blurb = $_POST['blurb'];
			$content = $_POST['content'];
			$tags = $_POST['tags'];
			$category = $_POST['category'];
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

	//DELETE POST FROM AUTHOR
	if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
		//Check for authentication
		$petitionid = $_REQUEST['petitionid'];
		$result = $conn->query("SELECT author FROM petitions WHERE petitionid = '$petitionid'");
		
		//Authenticated
		if ($_ENV['netid'] == $result['author']){
			//Remove from petitions table
			$delete_query = "DELETE FROM petitions WHERE petitionid = '$petitionid'";
			mysqli_query($conn, $delete_query);

			//Remove petition votes from votes table
			$remove_votes_query = "DELETE FROM votes WHERE petitionid = '$petitionid'";
			mysqli_query($conn, $remove_votes_query);
		}
	}
?>