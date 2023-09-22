<?php
include 'util.php';

$request = getRequest();

// $userID = $request[userIDKey];
// $pageIndex = $request[pageKey];
// $countsPerPage = $request[countsPerPageKey];
$userID = $request -> userID;
$pageIndex = $request -> page;
$countsPerPage = $request -> countsPerPage;

$database = "UserDatabase"; // ini_get("database")
$connection = new mysqli("insert server", "insert user", "insert password", $database, 3306);
// $connection->select_db($database);
$err = $connection->connect_error;
if ($err) 
{
	returnError($err);
	return;
}

$stmt = $connection->prepare("SELECT * FROM Contacts WHERE UserId = ? ORDER BY LastName, FirstName, UserID ASC LIMIT ? OFFSET ?");
$offset = $countsPerPage * $pageIndex;
$stmt->bind_param("iii", $userID, $countsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$connection->close();

if ($result)
{
	$arr = $result->fetch_all();
	returnResult($arr);
} 
else 
{
	returnEmpty();
}

?>
