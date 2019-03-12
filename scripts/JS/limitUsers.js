
function openConfirmAddUser(name, roomid, beingEdited)
{
	if(beingEdited){
		beingEdited = 1;
	}
	else{
		beingEdited = 0;
	}
		
	if(document.getElementById('limitCheck').value == 'on' || document.getElementById('limitCheck').value == 1){
		var limit = 1;
	}
	else{
		var limit = 0;
	}
	
	if(document.getElementById('hasComputersCheck').value == 'on' || document.getElementById('hasComputersCheck').value == 1){
		var hasComputers = 1;
	}
	else{
		var hasComputers = 0;
	}
	
	if(hasComputers == 1){
		var numComputers = document.getElementById('numComputers').value;
	}	
	else{
		var numComputers = null;
	}

	
	var roomType = document.getElementById('type').value;
	var floorNum = document.getElementById('floor').value;
	var seats = document.getElementById('seats').value;

    var buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='yesAddWL' >Yes</button> <button class='modal-button btn btn-danger' id='noAddWL' onclick='closeModal()'>No</button>";
    // var buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='yesAddWL' onclick='addToWhiteList('user@una.edu', 'Keller 233')' >Yes</button> <button class='modal-button btn btn-danger' id='noAddWL' onclick='closeModal()'>No</button>";
	showMessageBox("<br><br>Are you sure you want to add:<br><br>" + name, "Add user", buttonhtml, false);
	
	document.getElementById('yesAddWL').onclick = function() {
		closeModal();
		// alert(roomid + roomType + floorNum + seats + numComputers + limit + beingEdited);
		// alert('hasComputersCheck= ' + document.getElementById('hasComputersCheck').value + ' hasComputers=' + hasComputers + ' beingEdited=' + beingEdited + ' limit= ' + limit);
		
		alert('name=' + name + ' roomid=' + roomid);
	//	addWL(checkUserExists(name), name, roomid);
	//	saveChanges(roomid, roomType, floorNum, seats, numComputers, limit, beingEdited, hasComputers);
		
		//save changes
	};
}

function checkUserExists(name){
	var xhttp = new XMLHttpRequest();
	
	if (window.location.href.includes('PHP'))
	{
		xhttp.open("POST", "../../scripts/PHP/userExistsCheck.php", true);
	}
	else
	{
		xhttp.open("POST", "scripts/PHP/userExistsCheck.php", true);
	}
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("allowedUser=" + name);// send stuff
}



function addWL(userExists, name, roomid){
	// xhttp send is structured like this:
		// xhttp.send("variable=" + variable + "&variable2=" + variable2 + ...)
		
	var xhttp = new XMLHttpRequest();

	if(userExists){
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
	else{
		showMessageBoxOk("User does not exist!", "ERROR", true); // Error finding person, they don't exist!
	}
}



function saveChanges(roomid, roomType, floorNum, seats, numComputers, limit, beingEdited, hasComputers){
	var xhttp = new XMLHttpRequest();

	if (window.location.href.includes('PHP'))
	{
		xhttp.open("POST", "../../scripts/PHP/wlSaveChanges.php", true);
	}
	else
	{
		xhttp.open("POST", "scripts/PHP/wlSaveChanges.php", true);
	}
	
	alert("This is in saveChanges");
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("roomid=" + roomid + "&roomType=" + roomType + "&floorNum=" + floorNum + "&seats=" + seats + "&numComputers=" + numComputers + "&limit=" + limit + "&beingEdited=" + beingEdited + "&hasComputers=" + hasComputers);// send stuff
	
}