<?php
	#Login.php - handles the login.

header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

	$inData = getRequest();

	$id = 0;
	$firstName = "";
	$lastName = "";


	$connection = new mysqli("localhost", "superfun", "lamp", "Manager");
	// $connection->select_db($database);
	$err = $connection->connect_error;
        if ($err) 
        {
        returnError($err);
        }
	else
	{   
       		$stmt = $connection->prepare("SELECT id,firstName,lastName FROM Users WHERE username=? AND password=?");
		$stmt->bind_param("ss", $inData["login"], $inData["password"]);
		$stmt->execute();
		$result = $stmt->get_result();

		if($row = $result->fetch_assoc())
		{
			returnWithInfo($row['firstName'], $row['lastName'], $row['id']);
		}
		else
		{
			returnError("No Records Found");
		}

		$stmt->close();
		$connection->close();
	}

function getRequest()
{
     return json_decode(file_get_contents('php://input'), true);
    //return json_decode(readline());
}

function returnWithInfo($firstName, $lastName, $id)
	{
       // $login = new Login();
       // $login -> id = $id;
       // $login -> firstName = $firstName;
       // $login -> lastName = $lastName;
		//	returnResult($login);
	$retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
	sendResponse($retValue);
	}

function sendResponse($obj)
{
	header('Content-type: application/json');
	echo $obj;
}

function returnError(string $err)
	{
		$retValue = '{"id":0, "firstName":"", "lastName":"", "error":"' . $err . '"}';
		sendResponse($retValue);
   }



?>
