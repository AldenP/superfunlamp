
<html>
<title>Edit Contact</title>

<body>
	<h1>Edit Contact Info</h1>
	
	<!--Would be wise to take the current info and populate the boxes--!>
	<form action="editContact.php" method="post">
	<label>First Name:</label>
	<input type="text" value="First Name" name="firstName">
	<br>
	<label>Last Name:</label>
	<input type="text" value="Last Name" name="lastName">
	<br>
	<label>Email:</label>
	<input type="text" value="Email" name="email">
	<br>
	<label>Phone:</label>
	<input type="text" value="Phone" name="phone">
	<br>
	
	<input type="submit" value="Update">
	</form>
</body>
</html>

<?php
	$firstName = $_POST["firstName"];
	$lastName = $_POST["lastName"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];

	echo $firstName . $lastName;
	#Setup SQL connection. 
	#Need the userID/contact ID to update!



?>
