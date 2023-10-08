<?php
#create.php - Creates a new Contact

header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');


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
$userId = $request["parent_id"];

$connection = new mysqli("localhost", "superfun", "lamp", "Manager");
// $connection->select_db($database);
$err = $connection->connect_error;
if ($err) 
{
	returnError($err);
}
else{
	$stmt = $connection->prepare("INSERT into Contacts (firstName, lastName,phone,email,parent_id) VALUES(?,?,?,?,?)"); #added a semi colon to terminate statement (may not be needed?)
	$stmt->bind_param("sssss", $firstName, $lastName, $phone, $email, $userId);
	$stmt->execute();
	$stmt->close();
	$connection->close();

	#Send a confirmation to the javascript (to be seen under developer tools for debug).
	$retValue = '{"user_id":' . $userId . ',"firstName":"' . $firstName . '","lastName":"' . $lastName .'","phone":"' . $phone . '","email":"' . $email . '","error":""}';
	sendResult($retValue); #send the data added back (as json) as a confirmation of accurate data

	#returnError("Connection Closed by create.php");
}

function ret($first)
{
	$ab = '{firstname":"' .$first . '"}';
	echo $ab;
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
