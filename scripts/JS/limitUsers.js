//************************************************************************************************
// Method Name: openConfirmAddUser
//
// Incoming params: name (String), roomid (String), beingEdited (int bool)
//
// Purpose: Opens the modal box to have the user confirm if they really want to add the user
//*************************************************************************************************
function openConfirmAddUser(name, roomid, beingEdited)
{
	if(beingEdited){
		beingEdited = 1;
	}
	else{
		beingEdited = 0;
	}

    var buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='yesAddWL' >Yes</button> <button class='modal-button btn btn-danger' id='noAddWL' onclick='closeModal()'>No</button>";
	showMessageBox("<br><br>Are you sure you want to add:<br><br>" + name, "Add user", buttonhtml, false);

	
	document.getElementById('yesAddWL').onclick = function() {
		closeModal();
		addWL(name, roomid, beingEdited);
	};

}


//************************************************************************************************
// Method Name: addWL
//
// Incoming params: name (String), roomid (String)
//
// Purpose: Checks the int/bool userExists and sees if we need to add the user to the whitelist
//			or not. If we do, it will call addUserWhitelist.php, which actually adds the user
//			to the whitelist.
//*************************************************************************************************
function addWL(name, roomid, beingEdited){
	var xhttp = new XMLHttpRequest();
	var userExists = 0;
	var inserted = false;
	
	if (window.location.href.includes('PHP')){ // Set up checking if user exists
		xhttp.open("POST", "../../scripts/PHP/userExistsCheck.php", true);
	}
	else{
		xhttp.open("POST", "scripts/PHP/userExistsCheck.php", true);
	}
	
	xhttp.onreadystatechange = function(){ // When we get a response from checking if users exist
		if(xhttp.readyState == 4 && this.status == 200){ // If the response was "200 OK" http
	        userExists = xhttp.responseText; // userExists is returned from the php file here
	        
        	if (window.location.href.includes('PHP')){ // Set up addition to whitelist
				xhttp.open("POST", "../../scripts/PHP/addUserWhitelist.php", true);
			}
			else{
				xhttp.open("POST", "scripts/PHP/addUserWhitelist.php", true);
			}
	        
	        if(!inserted){ // If user has not been inserted yet
	        	if(userExists == 1){ // If user exists
	        		inserted = true;
		    		userExists = 0;
		    		
		    		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("allowedUser=" + name + "&roomid=" + roomid); // Add user to whitelist for this room
	        	}
	        	else{
					showMessageBoxOK("User does not exist!", "Error", false);
	        	}
	        }
	        else{ // User was inserted
         	    var buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='okAdd' >Ok</button>";
	        	showMessageBox("", "Success!", buttonhtml, false);
	        	inserted = true;
	        	
	        	var addUserElement = document.getElementById('okAdd');

				addUserElement.addEventListener('click', function() {
		   			saveChanges(name, roomid, beingEdited);
				}, false);
	        	
	        }
	        
		}
	};
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("allowedUser=" + name);// Send name to userExistsCheck.php
}



//************************************************************************************************
// Method Name: saveChanges
//
// Incoming params: roomid (String), roomType (String), floorNum (int), seats (int),
//					numComputers (int), limit (int bool), beingEdited (int bool), 
//					hasComputers (int bool)
//
// Purpose: Saves the changes made to the room. Called in openConfirmAddUser if the user hits yes.
//*************************************************************************************************
function saveChanges(name, roomid, beingEdited){

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
	
	var xhttp = new XMLHttpRequest();
	

	if (window.location.href.includes('PHP'))
	{
		xhttp.open("POST", "../../scripts/PHP/wlSaveChanges.php", true);
	}
	else
	{
		xhttp.open("POST", "scripts/PHP/wlSaveChanges.php", true);
	}

	
	// var saveObject = {
	// 	numComp : numComputers,
	// 	hasComp : hasComputers,
	// 	lim : limit,
	// 	seatNum : seats,
	// 	floor : floorNum,
	// 	roomT : roomType,
	//  roomID : roomid,
	//  edit : beingEdited
	// };
	
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && this.status == 200){
			window.location.reload();
		}
	};
	
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	// xhttp.send("roomid=" + saveObject.roomID + "&roomType=" + saveObject.roomT + "&floorNum=" + saveObject.floor + "&seats=" + saveObject.seatNum + "&numComputers=" + saveObject.numComp + "&limit=" + saveObject.lim + "&beingEdited=" + saveObject.edit + "&hasComputers=" + saveObject.hasComp);// send stuff
	xhttp.send("roomid=" + roomid + "&roomType=" + roomType + "&floorNum=" + floorNum + "&seats=" + seats + "&numComputers=" + numComputers + "&limit=" + limit + "&beingEdited=" + beingEdited + "&hasComputers=" + hasComputers);// send stuff

}