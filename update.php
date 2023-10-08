<?php
#update.php
header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

        $request = getRequest();

        $firstName = $request["firstName"];
        $lastName = $request["lastName"];
        $phone = $request["phone"];
        $email = $request["email"];
        $userId = $request["parent_id"];
        $id = $request["contact_id"];
       

        $conn = new mysqli("localhost", "superfun", "lamp", "Manager");
        if ($conn->connect_error)
        {
                returnError( $conn->connect_error );
        }
        else
        {
                $stmt = $conn->prepare("UPDATE Contacts SET phone = ?, email = ?, firstName = ?, lastName = ? WHERE parent_id = ? AND contact_id = ?;");
                $stmt->bind_param("ssssss", $phone, $email, $firstName, $lastName, $userId,  $id);
                $stmt->execute();
                $stmt->close();
		$conn->close();

		http_response_code(200);
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
