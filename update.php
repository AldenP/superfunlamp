<?php
include 'util.php';

$request = getRequest();

// $userID = $request[userIDKey];
// $id = $request[idKey];
// $phoneNumber = $request[phoneNumberKey];
// $email = $request[emailKey];
// $firstName = $request[firstNameKey];
// $lastName = $request[lastNameKey];
$userID = $request -> userID;
$id = $request -> id;
$phoneNumber = $request -> phoneNumber;
$email = $request -> email;
$firstName = $request -> firstName;
$lastName = $request -> lastName;

$database = "UserDatabase"; // ini_get("database")
$connection = new mysqli("localhost", "root", "COP4331C", $database, 3306);
// $connection->select_db($database);
$err = $connection->connect_error;
if ($err) 
{
	returnError($err);
	return;
}

$stmt = $connection->prepare("UPDATE Contacts SET PhoneNumber = ?, Email = ?, FirstName = ?, LastName = ? WHERE UserID = ? AND ID = ?");
$stmt->bind_param("ssssii", $phoneNumber, $email, $firstName, $lastName, $userID, $id);
$stmt->execute();
$stmt->close();
$connection->close();
returnEmpty();

?>
