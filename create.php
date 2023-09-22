<?php

$request = getRequest();

// $userID = $request[userIDKey];
// $phoneNumber = $request[phoneNumberKey];
// $email =  $request[emailKey];
// $firstName =  $request[firstNameKey];
// $lastName = $request[lastNameKey];
$firstName = $request["firstName"];
$lastName = $request["lastName"];
$phone = $request["phone"];
$email = $request["email"];
$userId = $request["userId"];

$database = "UserDatabase"; // ini_get("database")
$connection = new mysqli("localhost", "lisa", "saxophone", "ContactManager");
// $connection->select_db($database);
$err = $connection->connect_error;
if ($err)
{
        returnError($err);
}
else{
$stmt = $connection->prepare("INSERT into Contacts (firstName, lastName,phone,email,parent_id) VALUES(?,?,?,?,?)");
$stmt->bind_param("sssss", $userId, $phone, $email, $firstName, $lastName);
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
