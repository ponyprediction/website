/******************************************************************************
* UploadManager class
******************************************************************************/

function RegisterManager(sizeMinTitle, sizeMaxTitle, minCategories)
{
	//this.run();
}

RegisterManager.prototype.run = function()
{
	document.getElementById("submit").addEventListener("click", this, false);
	document.getElementById("username").addEventListener("blur", this, false);
	document.getElementById("email-1").addEventListener("blur", this, false);
	document.getElementById("email-2").addEventListener("blur", this, false);
	document.getElementById("password-1").addEventListener("blur", this, false);
	document.getElementById("password-2").addEventListener("blur", this, false);
}

RegisterManager.prototype.handleEvent = function(event)
{
	var id = event.target.id;
	var target = event.target;
	if(id == "submit")
	{
		this.checkForm(event);
	}
	else if(id == "username")
	{
		this.checkUsername();
	}
	else if(id == "email-1")
	{
		this.checkEmail1();
	}
	else if(id == "email-2")
	{
		this.checkEmail2();
	}
	else if(id == "password-1")
	{
		this.checkPassword1();
	}
	else if(id == "password-2")
	{
		this.checkPassword2();
	}
	else
	{
		alert("event not implemented");
	}
}

RegisterManager.prototype.checkUsername = function()
{
	var ok = true;
	document.getElementById("error-username-empty").classList.add("invisible");
	if(document.getElementById("username").value.length == 0)
	{
		ok = false;
		document.getElementById("error-username-empty").classList.remove("invisible");
	}
	return ok;
}

RegisterManager.prototype.checkEmail1 = function()
{
	var ok = true;
	var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	document.getElementById("error-email-1-empty").classList.add("invisible");
	if(document.getElementById("email-1").value.length == 0)
	{
		ok = false;
		document.getElementById("error-email-1-empty").classList.remove("invisible");
	}
	document.getElementById("error-email-1-invalid").classList.add("invisible");
	if(!regex.test(document.getElementById("email-1").value))
	{
		ok = false;
		document.getElementById("error-email-1-invalid").classList.remove("invisible");
	}
	document.getElementById("error-email-different").classList.add("invisible");
	if(document.getElementById("email-1").value != document.getElementById("email-2").value)
	{
		ok = false;
		document.getElementById("error-email-different").classList.remove("invisible");
	}
	return ok;
}

RegisterManager.prototype.checkEmail2 = function()
{
	var ok = true;
	var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	document.getElementById("error-email-2-empty").classList.add("invisible");
	if(document.getElementById("email-2").value.length == 0)
	{
		ok = false;
		document.getElementById("error-email-2-empty").classList.remove("invisible");
	}
	
	document.getElementById("error-email-2-invalid").classList.add("invisible");
	if(!regex.test(document.getElementById("email-2").value))
	{
		ok = false;
		document.getElementById("error-email-2-invalid").classList.remove("invisible");
	}
	document.getElementById("error-email-different").classList.add("invisible");
	if(document.getElementById("email-1").value != document.getElementById("email-2").value)
	{
		ok = false;
		document.getElementById("error-email-different").classList.remove("invisible");
	}
	return ok;
}

RegisterManager.prototype.checkPassword1 = function()
{
	var ok = true;
	document.getElementById("error-password-1-empty").classList.add("invisible");
	if(document.getElementById("password-1").value.length == 0)
	{
		ok = false;
		document.getElementById("error-password-1-empty").classList.remove("invisible");
	}
	document.getElementById("error-password-different").classList.add("invisible");
	if(document.getElementById("password-1").value != document.getElementById("password-2").value)
	{
		ok = false;
		document.getElementById("error-password-different").classList.remove("invisible");
	}
	return ok;
}

RegisterManager.prototype.checkPassword2 = function()
{
	var ok = true;
	document.getElementById("error-password-2-empty").classList.add("invisible");
	if(document.getElementById("password-2").value.length == 0)
	{
		ok = false;
		document.getElementById("error-password-2-empty").classList.remove("invisible");
	}
	document.getElementById("error-password-different").classList.add("invisible");
	if(document.getElementById("password-1").value != document.getElementById("password-2").value)
	{
		ok = false;
		document.getElementById("error-password-different").classList.remove("invisible");
	}
	return ok;
}

RegisterManager.prototype.checkForm = function(event)
{	
	this.hideErrors();
	this.hideSuccess();
	var ok = true;
	if(!this.checkUsername())
		ok = false;
	if(!this.checkEmail1())
		ok = false;
	if(!this.checkEmail2())
		ok = false;
	if(!this.checkPassword1())
		ok = false;
	if(!this.checkPassword2())
		ok = false;
	if(!ok)
	{
		event.preventDefault();
	}
	return ok;
}

RegisterManager.prototype.hideErrors = function()
{
	var errors = document.getElementsByClassName("error");
	for (var i = 0 ; i < errors.length; i++)
	{
		errors[i].classList.add("invisible");
	}
}

RegisterManager.prototype.hideSuccess = function()
{
	var errors = document.getElementsByClassName("success");
	for (var i = 0 ; i < errors.length; i++)
	{
		errors[i].classList.add("invisible");
	}
}
