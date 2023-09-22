<?php

        $inData = getRequest();

        $searchResults = "";
        $searchCount = 0;

        $conn = new mysqli("localhost", "lisa", "saxophone", "ContactManager");
        if ($conn->connect_error)
        {
                returnError( $conn->connect_error );
        }
        else
        {
                $stmt = $conn->prepare("SELECT * FROM Contacts WHERE (firstName like ? ||  lastName like ? ||  email like ? ||  phone like ?) and parent_id=?");
                $contactInfo = "%" . $inData["search"] . "%";
                $stmt->bind_param("sssss", $contactInfo, $contactInfo, $contactInfo,  $contactInfo, $inData["userId"]);
                $stmt->execute();

                $result = $stmt->get_result();

                while($row = $result->fetch_assoc())
                {
                        if( $searchCount > 0 )
                        {
                                $searchResults .= ",";
                        }
                        $searchCount++;
                        $searchResults .= '{"firstName" : "' . $row["firstName"].'", "lastName" : "' . $row["lastName"].'", "phone" : "' .$row["phone"].'", "email" : "' .$row["email"].'", "contact_id" : "' .$row["contact_id"].'"}' ;

                }
if( $searchCount == 0 )
                {
                        returnError( "No Records Found" );
                }
                else
                {
                        returnInfo( $searchResults );
                }

                $stmt->close();
                $conn->close();
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
                $retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
                sendResult( $retValue );
        }

        function returnInfo( $searchResults )
        {
                $retValue = '{"results":[' . $searchResults . '],"error":""}';
                sendResult( $retValue );
        }

?>
