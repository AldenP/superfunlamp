<?php
include 'util.php';

$request = getRequest();

$userID = $request[$userIDKey];
$phoneNumber = $request[$phoneNumberKey];
$email = $request[$emailKey];
$firstName = $request[$firstNameKey];
$lastName = $request[$lastNameKey];

$connection = new mysqli();
$connection->select_db(ini_get("database"));
if ($connection->connect_error) {
	returnWithError($connection->connect_error);
	return;
}

$stmt = $connection->prepare("INSERT into Contacts (UserId,PhoneNumber,Email,FirstName,LastName) VALUES(?,?,?,?,?)");
$stmt->bind_param("issss", $userId, $phoneNumber, $email, $firstName, $lastName);
$stmt->execute();
$stmt->close();
$connection->close();
returnEmpty();

?>