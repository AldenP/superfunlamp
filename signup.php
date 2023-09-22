<?php

        $inData = getRequest();

        $firstName = $inData["firstName"];
        $lastName = $inData["lastName"];
        $username = $inData["username"];
        $password = $inData["passWord"];
        $existingPassword = "";

        $database = "UserDatabase"; // ini_get("database")
        $connection = new mysqli("localhost", "lisa", "saxophone", "ContactManager");
        // $connection->select_db($database);
        $err = $connection->connect_error;
        if ($err)
        {
        returnError($err);
        //return;
        }
        elseif ($firstName == "" ||  $username == "" ||  $password == "")
        {
                returnError("Please fill in the required field");
        }

        elseif (userExists($conn, $username, $existingPassword))
        {
                http_response_code(409);
                returnError("Username already exists with password: $existingPassword");
        }
        else
        {
                $stmt = $conn->prepare("INSERT into Users (firstName,lastName,username,passWord) VALUES(?,?,?,?)");
                $stmt->bind_param("ssss", $firstName, $lastName, $username, $password);
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

        function userExists($conn, $username, &$existingPass)
        {
                $stmt = $conn->prepare("select * from Users where username like ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc())
                {
                        $existingPass = $row["Password"];
                        return true;
                }

                return false;
        }


?>
