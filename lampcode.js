const urlBase = 'http://superfunlamp.xyz';
const extension = 'php';

let userId = 0;
let firstName = "";
let lastName = "";
const ids = [];

function doLogin()
{
userId = 0;
        let username = document.getElementById("Username").value;
        let password = document.getElementById("Password").value;
        //var hash = md5( password );

        document.getElementById("loginResult").innerHTML = "";

        let tmp = {login:username,password:password};
        //var tmp = {login:login,password:password};
        let jsonPayload = JSON.stringify( tmp );

        let url = urlBase + '/login.' + extension;

        let xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
        try
        {
                xhr.onreadystatechange = function()
                {
                        if (this.readyState == 4 && this.status == 200)
                        {
                                let jsonObject = JSON.parse( xhr.responseText );
                                //userId = jsonObject.id;
                                userId = multiJson(jsonObject.id);

                                if(userId < 1)
                                {
                                        document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
                                        return;
                                }

                                firstName = jsonObject.firstName;
                                lastName = jsonObject.lastName;

                                saveCookie();

                                window.location.href = "contact_page.html";
                        }
                };
                xhr.send(jsonPayload);
        }
        catch(err)
        {
                document.getElementById("loginResult").innerHTML = err.message;
        }

}

function saveCookie()
{
        let minutes = 20;
        let date = new Date();
        date.setTime(date.getTime()+(minutes*60*1000));
        document.cookie = "firstName=" + firstName + ",lastName=" + lastName + ",userId=" + userId + ";expires=" + date.toGMTString();
}

function readCookie()
{
        userId = -1;
        let data = document.cookie;
        let splits = data.split(",");
        for(var i = 0; i < splits.length; i++)
        {
                let thisOne = splits[i].trim();
                let tokens = thisOne.split("=");
                if( tokens[0] == "firstName" )
                {
                        firstName = tokens[1];
                }
                else if( tokens[0] == "lastName" )
                {
                        lastName = tokens[1];
                }
                else if( tokens[0] == "userId" )
                {
                        userId = parseInt( tokens[1].trim() );
                }
        }

        if( userId < 0 )
        {
                window.location.href = "index.html";
        }
        else
        {
                document.getElementById("userName").innerHTML = "Logged in as " + firstName + " " + lastName;
        }
}

function doLogout()
{
        userId = 0;
        firstName = "";
        lastName = "";
        document.cookie = "firstName= ; expires = Thu, 01 Jan 2025 00:00:00 GMT";
        window.location.href = "index.html";
}

function doRegister()
{
    firstName = document.getElementById("firstName").value;
    lastName = document.getElementById("lastName").value;

    let login = document.getElementById("login").value;
    let password = document.getElementById("password").value;

    document.getElementById("registrationResult").innerHTML = "";

 //   var hash = md5 (password);

    let tmp = {
        firstName: firstName,
        lastName: lastName,
        login: login,
        password: password
    };

    let jsonPayload = JSON.stringify(tmp);

    let url = urlBase + '/signup.' + extension;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

    try {
        xhr.onreadystatechange = function () {

            if (this.readyState != 4) {
                return;
            }

            if (this.status == 409) {
                document.getElementById("registrationResult").innerHTML = "User already exists";
                return;
            }

            if (this.status == 200) {

                let jsonObject = JSON.parse(xhr.responseText);
                userId = multiJson(jsonObject.id);
                document.getElementById("registrationResult").innerHTML = "User added";
                firstName = jsonObject.firstName;
                lastName = jsonObject.lastName;
                saveCookie();
                        window.location.href = "index.html";
            }
        };

        xhr.send(jsonPayload);
    } catch (err) {
        document.getElementById("registrationResult").innerHTML = err.message;
    }
}

//functions to correctly parse json objects
function *multiJson(str) {
    while (str) {
        try {
            yield JSON.parse(str);
            str = '';
        } catch(e) {
            var m = String(e).match(/position\s+(\d+)/);
            yield JSON.parse(str.slice(0, m[1]));
            str = str.slice(m[1]);
        }
    }
}
root@cop4331c-crud:/var/www/superfunlamp.xyz/superfunlamp# ^C
root@cop4331c-crud:/var/www/superfunlamp.xyz/superfunlamp# vi lampcode.js
root@cop4331c-crud:/var/www/superfunlamp.xyz/superfunlamp# vi signup.php
root@cop4331c-crud:/var/www/superfunlamp.xyz/superfunlamp# vi lampcode.js
root@cop4331c-crud:/var/www/superfunlamp.xyz/superfunlamp# cat lampcode.js
const urlBase = 'http://superfunlamp.xyz';
const extension = 'php';

let userId = 0;
let firstName = "";
let lastName = "";
const ids = [];

function doLogin()
{
userId = 0;
        let username = document.getElementById("Username").value;
        let password = document.getElementById("Password").value;
        //var hash = md5( password );

        document.getElementById("loginResult").innerHTML = "";

        let tmp = {login:username,password:password};
        //var tmp = {login:login,password:password};
        let jsonPayload = JSON.stringify( tmp );

        let url = urlBase + '/login.' + extension;

        let xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
        try
        {
                xhr.onreadystatechange = function()
                {
                        if (this.readyState == 4 && this.status == 200)
                        {
                                let jsonObject = JSON.parse( xhr.responseText );
                                //userId = jsonObject.id;
                                userId = multiJson(jsonObject.id);

                                if(userId < 1)
                                {
                                        document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
                                        return;
                                }

                                firstName = jsonObject.firstName;
                                lastName = jsonObject.lastName;

                                saveCookie();

                                window.location.href = "contact_page.html";
                        }
                };
                xhr.send(jsonPayload);
        }
        catch(err)
        {
                document.getElementById("loginResult").innerHTML = err.message;
        }

}

function saveCookie()
{
        let minutes = 20;
        let date = new Date();
        date.setTime(date.getTime()+(minutes*60*1000));
        document.cookie = "firstName=" + firstName + ",lastName=" + lastName + ",userId=" + userId + ";expires=" + date.toGMTString();
}

function readCookie()
{
        userId = -1;
        let data = document.cookie;
        let splits = data.split(",");
        for(var i = 0; i < splits.length; i++)
        {
                let thisOne = splits[i].trim();
                let tokens = thisOne.split("=");
                if( tokens[0] == "firstName" )
                {
                        firstName = tokens[1];
                }
                else if( tokens[0] == "lastName" )
                {
                        lastName = tokens[1];
                }
                else if( tokens[0] == "userId" )
                {
                        userId = parseInt( tokens[1].trim() );
                }
        }

        if( userId < 0 )
        {
                window.location.href = "index.html";
        }
        else
        {
                document.getElementById("userName").innerHTML = "Logged in as " + firstName + " " + lastName;
        }
}

function doLogout()
{
        userId = 0;
        firstName = "";
        lastName = "";
        document.cookie = "firstName= ; expires = Thu, 01 Jan 2025 00:00:00 GMT";
        window.location.href = "index.html";
}

function doRegister()
{
    firstName = document.getElementById("firstName").value;
    lastName = document.getElementById("lastName").value;

    let login  = document.getElementById("username").value;
    let password = document.getElementById("passWord").value;

    document.getElementById("registrationResult").innerHTML = "";

 //   var hash = md5 (password);

    let tmp = {
        firstName: firstName,
        lastName: lastName,
        login: username,
        password: passWord
    };

    let jsonPayload = JSON.stringify(tmp);

    let url = urlBase + '/signup.' + extension;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

    try {
        xhr.onreadystatechange = function () {

            if (this.readyState != 4) {
                return;
            }

            if (this.status == 409) {
                document.getElementById("registrationResult").innerHTML = "User already exists";
                return;
            }

            if (this.status == 200) {

                let jsonObject = JSON.parse(xhr.responseText);
                userId = multiJson(jsonObject.id);
                document.getElementById("registrationResult").innerHTML = "User added";
                firstName = jsonObject.firstName;
                lastName = jsonObject.lastName;
                saveCookie();
                        window.location.href = "index.html";
            }
        };

        xhr.send(jsonPayload);
    } catch (err) {
        document.getElementById("registrationResult").innerHTML = err.message;
    }
}

//functions to correctly parse json objects
function *multiJson(str) {
    while (str) {
        try {
            yield JSON.parse(str);
            str = '';
        } catch(e) {
            var m = String(e).match(/position\s+(\d+)/);
            yield JSON.parse(str.slice(0, m[1]));
            str = str.slice(m[1]);
        }
    }
}
