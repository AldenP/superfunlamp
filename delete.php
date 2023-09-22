<?php

$request = getRequest();

// $userID = $request[userIDKey];
// $id = $request[idKey];
$userID = $request["userId"];
$contactID = $request["contactId"];

$database = "UserDatabase"; // ini_get("database")
$connection = new mysqli("localhost", "lisa", "saxophone", "ContactManager");
// $connection->select_db($database);
$err = $connection->connect_error;
if ($err)
{
        returnError($err);
}
else {

$stmt = $connection->prepare("DELETE FROM Contacts WHERE parent_id = ? AND contact_id = ?");
$stmt->bind_param("ss", $userID, $contactID);
$stmt->execute();
$stmt->close();
$connection->close();
returnError("");
}
function getRequest()
        {
                return json_decode(file_get_contents('php://input'), true);
        }

function sendResult( $obj )
        {
                header('Content-type: application/json');
                echo $obj;
        }

function returnError( $err )
        {
                $retValue = '{"error":"' . $err . '"}';
                sendResult( $retValue );
        }
?>
