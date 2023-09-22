<?php
include 'util.php';

	$request = getRequest();

	$username = $request -> username;
	$password = $request -> password;

	$database = "UserDatabase"; // ini_get("database")
	$connection = new mysqli("localhost", "lisa", "saxophone", "ContactManager");
	// $connection->select_db($database);
	$err = $connection->connect_error;
        if ($err) 
        {
        returnError($err);
        return;
        }
	else
	{   
        $stmt = $connection->prepare("SELECT ID, FirstName, LastName FROM Users WHERE UserName = ? AND Password = ?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();

		if($row = $result->fetch_assoc())
		{
			returnWithInfo($row['ID'], $row['FirstName'], $row['LastName']);
		}
		else
		{
			returnError("No Records Found");
		}

		$stmt->close();
		$connection->close();
	}
	
	function returnWithInfo($id, $firstName, $lastName)
	{
        $login = new Login();
        $login -> id = $id;
        $login -> firstName = $firstName;
        $login -> lastName = $lastName;
		returnResult($login);
	}
