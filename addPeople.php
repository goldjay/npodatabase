<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","steingoj-db","wvzjVzjt5Wo41kWh","steingoj-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
if(!($stmt = $mysqli->prepare("INSERT INTO people(f_name, l_name, birthdate, phone, email, city, state, street, zip) VALUES (?,?,?,?,?,?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
//If the insertion was successful

if(!($stmt->bind_param("sssissssi",$_POST['firstName'],$_POST['lastName'],$_POST['birthDate'],$_POST['phone'],$_POST['email'],$_POST['city'],$_POST['state'],$_POST['street'],$_POST['zip']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to people.";
	
	
}

$stmt->close();
?>