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
	$event=$_POST['event'];
	$amount=$_POST['amount'];
	$date=$_POST['date'];


//var_dump($_POST);



	//Check if the person exists
	$qry="SELECT people.id FROM people WHERE f_name='$fname' AND l_name='$lname'";
	$result = mysqli_query($mysqli, $qry);

	$row = mysqli_fetch_array($result);


	if($row[0] > 0){
			echo "YOU FOUND A PERSON";
			//Check if the event exits
			$find="SELECT event.eid FROM event WHERE name='$event'";
			$found = mysqli_query($mysqli, $find);
			$eid = mysqli_fetch_array($found);

			//echo	$eid[0];
			if($eid[0] > 0){
				echo "Your event exists!";
				// Add a new donation to the donation table
				if(!($stmt = $mysqli->prepare("INSERT INTO donation(pid, eid, amount, ddate) VALUES ('$row[0]', '$eid[0]', '$amount', '$date')"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
				} else {
					echo "Added " . $stmt->affected_rows . " rows to donation.\n";
				}
			$stmt->close();
			/*
				//Add new donation to the people_donation table
				$search="SELECT donation.did FROM donation WHERE pid='$row[0]' AND eid='$eid[0]'";
				$searched = mysqli_query($mysqli, $search);
				$did = mysqli_fetch_array($found);

				echo	"HERE is where you should see the DID";
				echo $did[0];
			*/
			}
			else{
				echo "The event you have specified does not exist. Check your spelling and try again or create a new event.";
			}
	}
	else {
		echo "Could not find the person you requested. Please double-check your spelling and try again.";
	}

?>
