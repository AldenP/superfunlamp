<?php
        $inData = getRequest();

        $firstName = $inData["firstName"];
        $lastName = $inData["lastName"];
        $phone = $inData["phone"];
        $email = $inData["email"];
        $userId = $inData["parent_id"];
        $id = $inData["contact_id"];
        $name = $firstName . ' ' . $lastName;

        $conn = new mysqli("localhost", "lisa", "saxophone", "ContactManager");
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
