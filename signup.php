<?php
include 'util.php';

	$request = getRequest();
    
	// $username = $request[usernameKey];
	// $password = $request[passwordKey];
	// $firstName = $request[firstNameKey];
	// $lastName = $request[lastNameKey];
	$username = $request -> username;
	$password = $request -> password;
	$firstName = $request -> firstName;
	$lastName = $request -> lastName;

	$database = "UserDatabase"; // ini_get("database")
	$connection = new mysqli("insert server", "insert user", "insert password", $database, 3306);
	// $connection->select_db($database);
	$err = $connection->connect_error;
    if ($err) 
    {
        returnError($err);
        return;
    }
	
	$stmt = $connection->prepare("INSERT into Users (FirstName,LastName,Username,Password) VALUES(?,?,?,?)");
	$stmt->bind_param("ssss", $firstName, $lastName, $username, $password);
	$stmt->execute();
	if (mysqli_stmt_errno($stmt) != 0)
	{
		$err = $stmt->$error;
		returnError($err);
		return;
	}
	$stmt->close();
	$connection->close();

?>
