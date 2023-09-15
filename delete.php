<?php
include 'util.php';

$request = getRequest();

$userID = $request[$userIDKey];
$id = $request[$idKey];

$connection = new mysqli();
$connection->select_db(ini_get("database"));
if ($connection->connect_error) {
	returnWithError($connection->connect_error);
	return;
}

$stmt = $connection->prepare("DELETE FROM Contacts WHERE userID = ? AND ID = ?");
$stmt->bind_param("ii", $userID, $id);
$stmt->execute();
$stmt->close();
$connection->close();
returnEmpty();

?>