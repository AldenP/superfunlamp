<?php

const userIDKey = "userID";
const phoneNumberKey = "phoneNumber";
const emailKey = "email";
const firstNameKey = "firstName";
const lastNameKey = "lastName";
const idKey = "ID";

function getRequest()
{
    $file = file_get_contents('php://input');
    return json_decode($file);
}

function sendResponse($obj)
{
    header('Content-type: application/json');
    echo $obj;
}

function returnEmpty()
{
    $value = '{}';
    sendResponse($value);
}

function returnError($err)
{
    $value = '{"error":"' . $err . '"}';
    sendResponse($value);
}

function returnResult($results)
{
    $value = '{"results":[' . $results . ']}';
    sendResponse($value);
}

?>