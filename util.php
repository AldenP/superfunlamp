<?php

const userIDKey = "userID";
const phoneNumberKey = "phoneNumber";
const emailKey = "email";
const firstNameKey = "firstName";
const lastNameKey = "lastName";
const idKey = "ID";
const pageKey = "page";
const countsPerPageKey = "countsPerPage";
const usernameKey = "username";
const passwordKey = "password";

class Login{
    public int $id;
    public string $firstName;
    public string $lastName;
}

function getRequest()
{
    // return json_decode(file_get_contents('php://input'));
    return json_decode(readline());
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

function returnError(string $err)
{
    class Error{
        public string $error;
    }
    $error = new Error();
    $error -> error = $err;
    $value = json_encode($error);
    if ($value == false)
    {
        returnEmpty();
    }
    else 
    {
        sendResponse($value);
    }
}

function returnResult(mixed $results)
{
    class Result{
        public mixed $result;
    }
    $result = new Result();
    $result -> result = $results;
    $value = json_encode($results);
    if ($value == false)
    {
        returnEmpty();
    }
    else 
    {
        sendResponse($value);
    }
}
?>
