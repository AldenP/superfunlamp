<?php
include 'util.php';

$request = getRequest();

// $userID = $request[userIDKey];
// $phoneNumber = $request[phoneNumberKey];
// $email =  $request[emailKey];
// $firstName =  $request[firstNameKey];
// $lastName = $request[lastNameKey];
$userID = $request -> userID;
$phoneNumber = $request -> phoneNumber;
$email =  $request -> email;
$firstName =  $request -> firstName;
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

$stmt = $connection->prepare("INSERT into Contacts (UserId,PhoneNumber,Email,FirstName,LastName) VALUES(?,?,?,?,?)");

$stmt->bind_param("issss", $userID, $phoneNumber, $email, $firstName, $lastName);
$stmt->execute();
$stmt->close();
$connection->close();
returnEmpty();

?>
