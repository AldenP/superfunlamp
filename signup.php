<?php
	#Signup.php = handles the registration of a new user;
	header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: *');


	$inData = getRequest();

        $firstName = $inData["firstName"];
        $lastName = $inData["lastName"];
        $username = $inData["username"];
        $password = $inData["password"];
	
#	echo "Data Acquired";

	$connection = new mysqli("localhost", "superfun", "lamp", "Manager");

	$err = $connection->connect_error;
        if ($err) 
        {
	returnError($err);
	}
	elseif ($firstName == "" ||  $username == "" ||  $password == "")
        {
		http_response_code(409);
		returnError("Missing required field");
		$connection->close();
	}
	elseif ( userExists($connection, $username) )
	{
		returnError("User Already Exists!");
		$connection->close();
	}
	else
	{
		# Renamed Users table column 'passWord' to 'password' so this statement is good!
                $stmt = $connection->prepare("INSERT into Users (username, password, firstName, lastName) VALUES(?,?,?,?)");
                $stmt->bind_param("ssss", $username, $password, $firstName, $lastName);
                $stmt->execute();
#                $stmt->close();
#                $conn->close();
		
		#Prepare an SQL statement to get the created users's ID
		$stmt = $connection->prepare("SELECT id FROM Users WHERE username like ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();

		#Get result
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$id = $row["id"];		

	#	$obj = '{' . 'id: ' . $row . ', username: "' . $username . '", firstName: "' . $firstName . '", lastName: "' . $lastName . '"}';

		$retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
		
		
		sendResult($retValue);

                http_response_code(200);
#		returnError("");

		$stmt->close();
		$connection->close();
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

        function userExists($connection, $username)
        {
                $stmt = $connection->prepare("select * from Users where username like ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();

                $result = $stmt->get_result();

                if ( $row = $result->fetch_assoc())
		{
			$stmt->close();
                        return true;
                }

		$stmt->close();
                return false;
      }

?>
