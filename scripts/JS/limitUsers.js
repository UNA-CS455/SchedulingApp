








function openConfirmCreateUser(name, roomid, beingEdited)
{
	// xhttp send is structured like this:
		// xhttp.send("variable=" + variable + "&variable2=" + variable2 + ...)
		
	if(beingEdited){
		beingEdited = 1;
	}
	else{
		beingEdited = 0;
	}
		
	if(document.getElementById('limitCheck') == 'on'){
		var limit = 1;
	}
	else{
		var limit = 0;
	}
	
	if(document.getElementById('hasComputersCheck') == 'on'){
		var hasComputers = 1;
	}
	else{
		var hasComputers = 0;
	}
	
	if(hasComputers == 1){
		var numComputers = document.getElementById('numComputers');
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
		alert(hasComputers);
		saveChanges(roomid, roomType, floorNum, seats, numComputers, limit, beingEdited);
		addWL(name, roomid);

		//save changes
	};
	
	
	
}

function addWL(name, roomid){
	var xhttp = new XMLHttpRequest();


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

function saveChanges(roomid, roomType, floorNum, seats, numComputers, limit, beingEdited){
	var xhttp = new XMLHttpRequest();

	if (window.location.href.includes('PHP'))
	{
		xhttp.open("POST", "../../scripts/PHP/wlSaveChanges.php", true);
	}
	else
	{
		xhttp.open("POST", "scripts/PHP/wlSaveChanges.php", true);
	}
	
	
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("roomid=" + roomid + "&roomType=" + roomType + "&floorNum=" + floorNum + "&seats=" + seats + "&numComputers=" + numComputers + "&limit=" + limit + "&beingEdited=" + beingEdited);// send stuff
	
}