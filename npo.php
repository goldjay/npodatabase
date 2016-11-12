
<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","steingoj-db","wvzjVzjt5Wo41kWh","steingoj-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title> NPO Database </title>
	
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="row" id="mainContent">

<div id="navigation">
	<ul>
	<li><a href="#displayContent">Home</a></li>
  <li><a href="#addPeople">Add Person</a></li>
  <li><a href="#assignRole">Assign Role</a></li>
  <li><a href="#addMembership">Add/Update Role</a></li>
  <li><a href="#addEvent">Add Event</a></li>
	<li><a href="#addDonation">Add Donation</a></li>
	<li><a href="#addRole">Add New Role</a></li>
</ul>
</div>

<div id="displayContent">
<div>
<table id="peopleData">
	<tr>
		<td><h1>People<h1></td>

	</tr>
	<tr>
		<th>First</th>
		<th>Last</th>
		<th>Birth</th>
		<th>Phone</th>
		<th>Email</th>
		<th>City</th>
		<th>State</th>
		<th>Street</th>
		<th>Zip</th>
	</tr>

<?php
if(!($stmt = $mysqli->prepare("SELECT people.f_name, people.l_name, people.birthdate, people.phone, people.email, people.city, people.state, people.street, people.zip FROM people"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($fname, $lname, $birthdate, $phone, $email, $city, $state, $street, $zip)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname . "\n</td>\n<td>\n" . $birthdate . "\n</td>\n<td>\n" . $phone . "\n</td>\n<td>\n" . $email . "\n</td>\n<td>\n" . $city . "\n</td>\n<td>\n" . $state . "\n</td>\n<td>\n" . $street . "\n</td>\n<td>\n" . $zip . "\n</td>\n</tr>";
}
$stmt->close();
?>

</table>
</div>

	<form class="formStyle" id="addPeople" method="post" action="addPeople.php">
		<h2>Add a Person</h2>
		<fieldset>
			<legend>Name</legend>
			<p>First Name: <input type: "text" name = "firstName"></p>
			<p>Last Name: <input type: "text" name = "lastName"></p>
			<p>Birth Date: <input type: "date" name = "birthDate" placeholder="YYYY-MM-DD"></p>

		</fieldset>
		<fieldset>
			<legend>Contact</legend>
			<p>Phone number: <input type: "number" name = "phone"></p>
			<p>Email: <input type: "email" name = "email"></p>
		</fieldset>

		<fieldset>
			<legend>Address</legend>
			<p>City: <input type= "text" name = "city"></p>
			<p>State: <input type= "text" name = "state"></p>
			<p>Street: <input type= "text" name = "street"></p>
			<p>Zip Code: <input type= "number" name = "zip"></p>
		</fieldset>

		<input type="submit" name="submitbtn" value="submit">

	</form>


<?php
if(!($stmt = $mysqli->prepare("SELECT role.name FROM role"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($name)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
//echo "<tr\n>"
while($stmt->fetch()){
echo "<tr\n<td>\n  " . $name . "  \n</td></tr>";
}
//echo "\n</tr>";

$stmt->close();
?>


<form class="formStyle" id="assignRole" method="post" action="assignRole.php">
	<h2> Assign a new role</h2>
	<fieldset>
			<legend>Assign a role</legend>
			<p>First Name: <input type= "text" name = "firstName"></p>
			<p>Last Name: <input type= "text" name = "lastName"></p>
			<p>Role Name: <input type= "text" name = "roleName" placeholder="Roles listed above"></p>
		</fieldset>
		<input type="submit" name="submitbtn" value="submit">
</form>




	<form class="formStyle" id="addMembership" method="post" action="addMembership.php">
		<h2>Add or update a membership</h2>
		<fieldset>
			<legend>Name</legend>
			<p>First Name: <input type: "text" name = "firstName"></p>
			<p>Last Name: <input type: "text" name = "lastName"></p>
			<p>Expiration Date: <input type: "date" name = "expiration" placeholder="YYYY-MM-DD"></p>
		</fieldset>
		<input type="submit" name="submitbtn" value="submit">

	</form>




	<form class="formStyle" id="addEvent" method="post" action="addEvent.php">
		<h2>Add an Event</h2>
		<fieldset>
			<legend> Event </legend>
			<p>Event Name: <input type: "text" name = "name"></p>
			<p>Date: <input type: "date" name = "date" placeholder="YYYY-MM-DD"></p>
			<p>City: <input type: "text" name = "city"></p>
			<p>State: <input type: "text" name = "state"></p>
			<p>Street: <input type: "text" name = "street"></p>
			<p>Zip Code: <input type: "text" name = "zip"></p>

		</fieldset>
		<input type="submit" name="submitbtn" value="submit">

	</form>


	<form class="formStyle" id="addDonation" method="post" action="addDonation.php">
		<h2>Add a Donation</h2>
		<fieldset>
			<legend>Name</legend>
			<p>First Name: <input type: "text" name = "firstName"></p>
			<p>Last Name: <input type: "text" name = "lastName"></p>
			<p>Amount: <input type: "number" name = "amount"></p>
			<p>Event: <input type: "text" name = "event"></p>
			<p>Date: <input type: "date" name = "date" placeholder="YYYY-MM-DD"></p>

		</fieldset>
		<input type="submit" name="submitbtn" value="submit">
	</form>

	<form class="formStyle" id="addRole" method="post" action="addRole.php">
		<h2>Add a new role at the organization</h2>
		<fieldset>
			<legend>Name</legend>
			<p>Name <input type: "text" name = "name"></p>
		</fieldset>
		<input type="submit" name="submitbtn" value="submit">

	</form>
</div>
</div>
</body>
</html>
