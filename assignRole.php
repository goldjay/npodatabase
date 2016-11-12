<?php


//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","steingoj-db","wvzjVzjt5Wo41kWh","steingoj-db");


if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

	$fname=$_POST['firstName'];
	$lname=$_POST['lastName'];
	$rname=$_POST['roleName'];

	//Check if the person exists
	$qry="SELECT people.id FROM people WHERE f_name='$fname' AND l_name='$lname'";
	$result = mysqli_query($mysqli, $qry);

	$row = mysqli_fetch_array($result);


	if($row[0] > 0){
			//echo "YOU FOUND A PERSON";
			//Check if the role exists
			$find="SELECT role.rid FROM role WHERE role.name='$rname'";
			$found= mysqli_query($mysqli, $find);

			if($rid = mysqli_fetch_array($found)){
					//echo "THE ROLE EXISTS";
					//Try to add the role/person combo to people_role
					if(!($stmt = $mysqli->prepare("INSERT into people_role (pid, rid) VALUES ('$row[0]','$rid[0]')"))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}

					if(!$stmt->execute()){
						echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
					} else {
						echo "Added " . $stmt->affected_rows . " rows to people_role.\n";
					}
			}
			else{
				echo "The role you have typed doesn't exist. Please look above the fields to find a list of available roles";
			}
	}
	else{
		echo "Person not found in database. Please check your spelling or try a different name";
	}
?>
