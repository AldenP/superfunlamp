<?php
include 'util.php';

$request = getRequest();

// $userID = $request[userIDKey];
// $id = $request[idKey];
$userID = $request -> userID;
$id = $request -> id;

$database = "UserDatabase"; // ini_get("database")
$connection = new mysqli("insert server", "insert user", "insert password", $database, 3306);
// $connection->select_db($database);
$err = $connection->connect_error;
if ($err) 
{
	returnError($err);
	return;
}

$stmt = $connection->prepare("DELETE FROM Contacts WHERE userID = ? AND ID = ?");
$stmt->bind_param("ii", $userID, $id);
$stmt->execute();
$stmt->close();
$connection->close();
returnEmpty();

?>
