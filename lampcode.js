const urlBase = 'http://superfunlamp.xyz';
const extension = 'php';

let userId = 0;
let firstName = "";
let lastName = "";
let currentContactId = -1;
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
	console.log(jsonPayload);
	
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
				userId = jsonObject.id;
		
				if(userId < 1)
				{	
					console.log(xhr.responseText);
					console.log(jsonObject.firstName);
					console.log(userId);
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
	document.cookie = "firstName=" + firstName + ",lastName=" + lastName + ",userId=" + userId +",contactId="+ currentContactId + ";expires=" + date.toGMTString();
}

function readCookie()
{
	userId = -1;
	currentContactId = -1;
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
		else if (tokens[0] == "contactId") 
		{
			currentContactId = parseInt( tokens[1].trim() );
			console.log("CurrentContactId: " + currentContactId);
			console.log("tokens[1].trim() : " + tokens[1].trim() );
		}
	}

	if( userId < 0 )
	{
		window.location.href = "index.html";
	}
	else if( currentContactId < 0)
	{
		document.getElementById("userName").innerHTML = "Contact Manager for " + firstName + " " + lastName;
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
    let firstName = document.getElementById("firstName").value;
    let lastName = document.getElementById("lastName").value;

    let username  = document.getElementById("username").value;
    let passWord = document.getElementById("password").value;

    document.getElementById("registrationResult").innerHTML = "";

 //   var hash = md5 (password);

    let tmp = {
        firstName: firstName,
        lastName: lastName,
        username: username,
        password: passWord
    };

    let jsonPayload = JSON.stringify(tmp);

    let url = urlBase + '/signup.' + extension;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "text/html; charset=UTF-8");

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
                userId = jsonObject.id;
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

function addContact(){
    let firstname = document.getElementById("contactFirst").value;
    let lastname = document.getElementById("contactLast").value;
    let phone = document.getElementById("contactNumber").value;
    let email = document.getElementById("contactEmail").value;

    let tmp = {
        firstName: firstname,
        lastName: lastname,
        phone: phone,
        email: email,
        parent_id: userId
    };

	let jsonPayload = JSON.stringify( tmp );

	let url = urlBase + '/create.' + extension;
	
	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				console.log("Contact added");
				console.log(tmp);
//               		 document.getElementById("add-form").reset();

                loadContacts();
              //  restoreAfterAdd();
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		console.log(firstname);
		document.getElementById("contactAddResult").innerHTML = err.message;
	}
	
}
//Called from editContact.html which may not have the contact ID
function updateContact() {
	
	//Get information from the HTML form
    let firstname = document.getElementById("firstNameUp").value;
    let lastname = document.getElementById("lastNameUp").value;
    let phone = document.getElementById("phoneUp").value;
    let email = document.getElementById("emailUp").value;

	// Now get the contact ID and user ID!
	//userID is global variable, and contactID will be passed to the function
	
	if (currentContactId == -1)
	{
		console.log("Bad Contact ID: "+currentContactId);
		document.getElementById("updateResult").innerhtml = "Error Bad Contact ID";
		//window.location.href = "contact_page.html";
		return;
	}

    let tmp = {
        firstName: firstname,
        lastName: lastname,
        phone: phone,
        email: email,
        parent_id: userId,
	contact_id: currentContactId
    };

	let jsonPayload = JSON.stringify( tmp );

	let url = urlBase + '/update.' + extension;
	
	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				console.log("Contact Updated");
				console.log(tmp);
//               		 document.getElementById("add-form").reset();
				window.location.href = "contact_page.html";
              //  restoreAfterAdd();
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		console.log("Error updating: " + firstname);
		document.getElementById("updateResult").innerHTML = err.message;
	}

	//Housekeeping
	currentContactId = -1;
}

function loadContacts() {
    let searchValue = document.getElementById("searchContactButton").value;
    let tmp = {
        search: searchValue,
        userId: userId
    };

    let jsonPayload = JSON.stringify(tmp);

    let url = urlBase + '/read.' + extension;
    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
try {
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let jsonObject = JSON.parse(xhr.responseText);
		   // let json = multiJson(jsonObject.error);
		    var result =length(jsonObject.results);
                if (jsonObject.error) {
                    console.log(jsonObject.error);
                        let text = "<table border='1'></table>"
                        document.getElementById("tableBody").innerHTML = text;
                    return;
                }
                let text = "<table border='1'>"
                for (let i = 0; i < result; i++) {
                    ids[i] = jsonObject.results[i].id
                    text += "<tr id='row" + i + "'>"
                    text += "<td id='first_Name" + i + "'><span>" + jsonObject.results[i].firstName + "</span></td>";
                    text += "<td id='last_Name" + i + "'><span>" + jsonObject.results[i].lastName + "</span></td>";
                    text += "<td id='email" + i + "'><span>" + jsonObject.results[i].email + "</span></td>";
                    text += "<td id='phone" + i + "'><span>" + jsonObject.results[i].phone + "</span></td>";
                    text += "<td class='contactButtons'>" +
                        "<button type='button' id='edit_button" + i + "' class='editButton' onclick='showEditContact("+jsonObject.results[i].contact_id+")'>" +"<span class='material-symbols-outlined'>edit</span>"+ "</button>" +
                        "<button type='button' onclick='deleteContact(" + jsonObject.results[i].contact_id + ", row" + i + ")' class='deleteButton'>" +"<span class='material-symbols-outlined'>delete</span>"+ "</button>" + "</td>";
                     text += "<tr/>"
                     console.log(i);
                }
                text += "</table>"
                document.getElementById("tableBody").innerHTML = text;
            }
        };
        xhr.send(jsonPayload);
    } catch (err) {
        console.log(err.message);
    }
}

function deleteContact(contactId)
{
	console.log("Deleting contactId: " + contactId);


    let tmp = {
       // firstName: firstname,
       // lastName: lastname,
       // phone: phone,
       // email: email,
        parent_id: userId,
	contact_id: contactId
    };

	let jsonPayload = JSON.stringify( tmp );

	let url = urlBase + '/delete.' + extension;
	
	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				console.log("Contact Deleted");
				console.log(tmp);
//               		 document.getElementById("add-form").reset();
				window.location.href = "contact_page.html";
              //  restoreAfterAdd();
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		console.log("Error Deleting contactId: " + contactId);
		document.getElementById("updateResult").innerHTML = err.message;
	}

}
//does this run every time it is loaded? yes it does. Use a cookie
//let currentContactID = -1;

function showEditContact( contactID)
{
	//document.getElementById("").innerHTML = ;
	currentContactId = contactID;
	console.log("contactID: " + contactID +", currentConID: " + currentContactId);
	saveCookie();	//saves the currentContactId;
	window.location.href = "editContact.html";
}

function searchContact()
{
	let srch = document.getElementById("searchText").value;
	document.getElementById("contactSearchResult").innerHTML = "";

	let contactList = "";

	let tmp = {search:srch,userId:userId};
	let jsonPayload = JSON.stringify( tmp );

	let url = urlBase + '/read.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				document.getElementById("contactSearchResult").innerHTML = "Contact(s) has been retrieved";
				let jsonObject = JSON.parse( xhr.responseText );
				var count = multiJson(length(jsonObject.results));
				var result = length(jsonObject.results);

				if(jsonObject.error) {
					console.log(jsonObject.error);
					let text = "<table border='1'></table>";
					document.getElementById("tableBody").innerHTML = text;
					return;
				}
				let text = "<table border='1'>";

				for( let i=0; i<result; i++ )
				{
					/*contactList += jsonObject.results[i];
					if( i < count - 1 )
					{
						contactList += "<br />\r\n";
					}*/
				    ids[i] = jsonObject.results[i].id
		                    text += "<tr id='row" + i + "'>"
		                    text += "<td id='first_Name" + i + "'><span>" + jsonObject.results[i].firstName + "</span></td>";
		                    text += "<td id='last_Name" + i + "'><span>" + jsonObject.results[i].lastName + "</span></td>";
		                    text += "<td id='email" + i + "'><span>" + jsonObject.results[i].email + "</span></td>";
		                    text += "<td id='phone" + i + "'><span>" + jsonObject.results[i].phone + "</span></td>";
		                    text += "<td class='contactButtons'>" +
		                        "<button type='button' id='edit_button" + i + "' class='editButton' onclick='showEditContact("+jsonObject.results[i].contact_id+")'>" +"<span class='material-symbols-outlined'>edit</span>"+ "</button>" +
		                        "<button type='button' onclick='deleteContact(" + jsonObject.results[i].contact_id + ", row" + i + ")' class='deleteButton'>" +"<span class='material-symbols-outlined'>delete</span>"+ "</button>" + "</td>";
		                     text += "<tr/>"
		                     console.log(i+ jsonObject.results[i].firstName);
				}

				document.getElementById("tableBody").innerHTML = text;
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("contactSearchResult").innerHTML = err.message;
	}

}

function showAddContact() {
    var add = document.getElementById("addContact");
    var contacts = document.getElementById("contactTable");
    var search = document.getElementById("searchText");

    add.style.display = "block";
    contacts.style.display = "none";
    search.style.display = "none";
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

function length(obj){
  var i=0;
  for (var x in obj){
    if(obj.hasOwnProperty(x)){
      i++;
    }
  } 
  return i;
}

