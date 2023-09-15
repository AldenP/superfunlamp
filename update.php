<?php
include 'util.php';

$request = getRequest();

$userID = $request[$userIDKey];
$id = $request[$idKey];
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

$stmt = $connection->prepare("UPDATE Contacts PhoneNumber = ?, Email = ?, FirstName = ?, LastName = ?) WHERE UserID = ? AND ID = ?");
$stmt->bind_param("ssssii", $phoneNumber, $email, $firstName, $lastName, $userID, $id);
$stmt->execute();
$stmt->close();
$connection->close();
returnEmpty();

?>