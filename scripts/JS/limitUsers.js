























function openConfirmCreateUser(asdf)
{
	// xhttp send is structured like this:
		// xhttp.send("variable=" + variable + "&variable2=" + variable2 + ...)
		
	//var name = data.allowedUser;
	//var name = document.getElementById(asdf).value;
	var name = asdf.value;
	
    buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='yesAddWL' onclick='insertUserWhitelist()'>Yes</button> <button class='modal-button btn btn-danger' id='noAddWL' onclick='closeModal()'>No</button>";
	showMessageBox("<br><br>Are you sure you want to add:<br><br>" + name, "Add user", buttonhtml, false);
	
	xhttp.open("POST", "scripts/PHP/addUserWhitelist.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();// send stuff
}