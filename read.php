<?php
include 'util.php';

$request = getRequest();

$userID = $request[$userIDKey];

$connection = new mysqli();
$connection->select_db(ini_get("database"));
if ($connection->connect_error) {
	returnWithError($connection->connect_error);
	return;
}

$stmt = $connection->prepare("select * from Contacts where UserId = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$result->fetch_all();
$resultString = implode(",", $result);
$stmt->close();
$connection->close();
returnWithResultAndError($resultString);

?>