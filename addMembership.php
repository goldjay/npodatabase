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
$expDate=$_POST['expiration'];
	
$qry="SELECT people.id FROM people WHERE f_name='$fname' AND l_name='$lname'";
$result = mysqli_query($mysqli, $qry);
$num_rows = mysqli_num_rows($result);

$row = mysqli_fetch_array($result);


//If there is a person by that name
if($row[0] > 0){
	echo "Your person was found\n";
	
	$find="SELECT membership.mid FROM membership WHERE mid='$row[0]'";
	$found = mysqli_query($mysqli, $find);
	$mid = mysqli_fetch_array($found);
	
	
	//$mid for new
	//$row[0] for update
	
	//If they already have a membership aka if their id exist in the membership table
	if($mid[0] > 0){
			echo "They have a membership\n";
		//Update the membership date	
		if(!($stmt = $mysqli->prepare("Update membership SET expDate='$expDate' WHERE mid='$row[0]'"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
	
		if(!$stmt->execute()){
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
		} else {
			echo "Added " . $stmt->affected_rows . " rows to membership.\n";
		}
		
	}
	//If the person exists, but doesn't have a membership, create a new membership
	else{
		echo "Creating a new membership...\n";
		
		if(!($stmt = $mysqli->prepare("INSERT INTO membership(mid, expDate) VALUES ('$row[0]', '$expDate')"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		
		if(!$stmt->execute()){
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
		} else {
			echo "Added " . $stmt->affected_rows . " rows to membership.\n";
		}
	}
	
	$stmt->close();
}	
//The person in question doesn't exist
else{
	echo "There is no person by that name./n Either retry your addition or add a person./n";
	
}

?>