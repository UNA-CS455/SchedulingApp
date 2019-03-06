








function openConfirmCreateUser(name, roomid)
{
	// xhttp send is structured like this:
		// xhttp.send("variable=" + variable + "&variable2=" + variable2 + ...)

    var buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='yesAddWL'' >Yes</button> <button class='modal-button btn btn-danger' id='noAddWL' onclick='closeModal()'>No</button>";
    // var buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='yesAddWL' onclick='addToWhiteList('user@una.edu', 'Keller 233')' >Yes</button> <button class='modal-button btn btn-danger' id='noAddWL' onclick='closeModal()'>No</button>";
	showMessageBox("<br><br>Are you sure you want to add:<br><br>" + name, "Add user", buttonhtml, false);
	
	document.getElementById('yesAddWL').onclick = function() {
		closeModal();
		addToWhiteList(name, roomid);
	};
	
	
	
}

function addToWhiteList(name, roomid){
	

	if (window.location.href.includes('PHP'))
	{
		xhttp.open("POST", "../../scripts/PHP/addUserWhitelist.php", true);
	}
	else
	{
		xhttp.open("POST", "scripts/PHP/addUserWhitelist.php", true);
	}
	
	
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("allowedUser=" + name + "&roomid=" + roomid);// send stuff
}