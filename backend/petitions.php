<?php
	require_once("db.php");
	require_once("ensureUser.php");
	//creates $conn mysqli instance and $user

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		//VOTE FOR THE PETITION
		if (array_key_exists("petitionid", $_REQUEST)) {
			if ($user['remainingvotes'] <= 0) {
				http_response_code(402);
				echo '{"error":"You can only vote on three per day!"}';
				exit();
			}
			$query = $conn->prepare("INSERT INTO votes(netid, name, petitionid, comment, timestamp) VALUES(?,?,?,?,?)");
			$query->bind_param("sssss", $netid, $name, $petitionid, $comment, $timestamp);
			$netid = $user['netid'];
			$name = $user['netid'];
			$petitionid = $_REQUEST['petitionid']; //From URL
			$comment = substr($_POST['comment'],0,255);//limit to 255
			$timestamp = round(microtime(true) * 1000);;
			$query->execute();

			//Update votes count
			$votes_result = $conn->query("SELECT * FROM votes WHERE petitionid = '$petitionid'");
			$numvotes = $votes_result->num_rows;
			$votes_query = "UPDATE petitions
							SET count = $numvotes
							WHERE id = $petitionid";
			mysqli_query($conn, $votes_query);

			//Change votes remaining
			$votes_remaining_query = "UPDATE users
									  SET remainingvotes = remainingvotes-1
									  WHERE netid = '$netid'";
			mysqli_query($conn, $votes_remaining_query);

		}
		
		//ADD NEW PETITON TO DATABASE
		else{
			$query = $conn->prepare("INSERT INTO petitions(name, author, blurb, content, tags, category, date) VALUES(?,?,?,?,?,?,?)");
			$query->bind_param("sssssss", $name, $author, $blurb, $content, $tags, $category, $date);
			
			//Grab info from AJAX
			$name = $_POST['name'];
			$author = $user['netid'];
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
		$result = $conn->query("SELECT author FROM petitions WHERE id = '$petitionid' LIMIT 1");
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		//Authenticated
		if ($user['netid'] == $row['author']){
			//Remove from petitions table
			$delete_query = "DELETE FROM petitions WHERE id = '$petitionid'";
			mysqli_query($conn, $delete_query);
		} else {
			http_response_code(403);
			echo '{"error":"unauthorized"}';
		}
	}
?>