<?php


        $inData = getRequest();

        $id = 0;
        $firstName = "";
        $lastName = "";

        $database = "UserDatabase"; // ini_get("database")
        $connection = new mysqli("localhost", "lisa", "saxophone", "ContactManager");
        // $connection->select_db($database);
        $err = $connection->connect_error;
        if ($err)
        {
        returnError($err);
        }
        else
        {
                $stmt = $connection->prepare("SELECT id,firstName,lastName FROM Users WHERE username=? AND passWord=?");
                $stmt->bind_param("ss", $inData["username"], $inData["password"]);
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
                //      returnResult($login);
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
