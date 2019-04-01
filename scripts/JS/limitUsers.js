//************************************************************************************************
// Method Name: openConfirmDelUser
//
// Incoming params: name (String), roomid (String), beingEdited (int bool)
//
// Purpose: Opens a modal box to have the user actually confirm if they want to delete the
//			selected user. If so, open delWL function. Else, close modal box.
//*************************************************************************************************
function openConfirmDelUser(name, roomid, beingEdited)
{
	if(beingEdited){
		beingEdited = 1;
	}
	else{
		beingEdited = 0;
	}

    var buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='yesDelWL' >Yes</button> <button class='modal-button btn btn-danger' id='noDelWl' onclick='closeModal()'>No</button>";
	showMessageBox("<br><br>Are you sure you want to delete:<br><br>" + name, "Delete user", buttonhtml, false);

	
	document.getElementById('yesDelWL').onclick = function() {
		closeModal();
		delWL(name, roomid, beingEdited);
	};

}


//************************************************************************************************
// Method Name: delWL
//
// Incoming params: name (String), roomid (String), beingEdited (int bool)
//
// Purpose: This method will call two php scripts: userExistsCheck.php (to check if the user
//          actually selected a user or left it at the default --SELECT USER-- option) and 
//			delUserWhitelist.php (which will handle actually deleting the user from the whitelist),
//			and will then give feedback on the success/failure of the action.
//*************************************************************************************************
function delWL(name, roomid, beingEdited){
	var xhttp = new XMLHttpRequest();
	var userExists = 0;
	var deleted = false;
	var success = false;
	
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
				xhttp.open("POST", "../../scripts/PHP/delUserWhitelist.php", true);
			}
			else{
				xhttp.open("POST", "scripts/PHP/delUserWhitelist.php", true);
			}
	        
	        if(!deleted){
		        if(userExists == 1){ // If user exists
		        	deleted = true;
			    	userExists = 0;
			    	success = true;
			    	
			    	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("allowedUser=" + name + "&roomid=" + roomid); // Add user to whitelist for this room
					
		        }
		        else{
					showMessageBoxOK("Please select a user.", "Error", false);
					success = false;
		        }
	        }
	        
	        if(success){ // User was deleted successfully
         	    var buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='okDel' >Ok</button>";
	        	showMessageBox("Successfully deleted " + name, "Success!", buttonhtml, false);
	        	deleted = true; // Keep it from going back into the deletion, which will force it to say false and give a blank user error
	        	
	        	var addUserElement = document.getElementById('okDel');

				addUserElement.addEventListener('click', function() {
		   			saveChanges(name, roomid, beingEdited); // Save changes to any forms that may have been filled in
				}, false);
	        	
	        }
	        
		}
	};
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("allowedUser=" + name);// Send name to userExistsCheck.php

}





//************************************************************************************************
// Method Name: openConfirmAddUser
//
// Incoming params: name (String), roomid (String), beingEdited (int bool)
//
// Purpose: Opens the modal box to have the user confirm if they really want to add the user.
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
// Incoming params: name (String), roomid (String), beingEdited (int Bool)
//
// Purpose: Checks if the given user (name) exists in the system. If so, insert them into the 
//			whitelist. If not, reject it.
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
	        	showMessageBox("Successfully added " + name, "Success!", buttonhtml, false);
	        	inserted = true;
	        	
	        	var addUserElement = document.getElementById('okAdd');

				addUserElement.addEventListener('click', function() {
		   			saveChanges(name, roomid, beingEdited); // Save changes to any forms that may have been filled in
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
// Incoming params: roomid (String), roomType (String), beingEdited (int bool)
//
// Purpose: Saves the changes made to the room. Called in openConfirmAddUser if the user hits yes.
//*************************************************************************************************
function saveChanges(name, roomid, beingEdited){

	
	// See if we want to even limit the room reservations
	if(document.getElementById('limitCheck').value == 'on' || document.getElementById('limitCheck').value == 1){
		var limit = 1;
	}
	else{
		var limit = 0;
	}
	
	// See if it has computers
	// Still giving hasComputers = 1 when it is clearly not
	if(document.getElementById('hasComputersCheck').value == 'on' || document.getElementById('hasComputersCheck').value == 1){
		var hasComputers = 1;
	}
	else{
		var hasComputers = 0;
	}
	
	
	// See how many, if any, computers there are
	if(hasComputers == 1){
		var numComputers = document.getElementById('numComputers').value;
	}	
	else{
		var numComputers = null;
	}

	
	var roomType = document.getElementById('type').value; // What room type is it?
	var floorNum = document.getElementById('floor').value; // What floor is it on?
	var seats = document.getElementById('seats').value; // How many seats are there?
	
	var xhttp = new XMLHttpRequest();
	

	if (window.location.href.includes('PHP')){ // Prepare to save changes
		xhttp.open("POST", "../../scripts/PHP/wlSaveChanges.php", true);
	}
	else{
		xhttp.open("POST", "scripts/PHP/wlSaveChanges.php", true);
	}
	
	xhttp.onreadystatechange = function(){ // Once we get a response, refresh the page
		if(xhttp.readyState == 4 && this.status == 200){
			window.location.reload();
		}
	};
	
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("roomid=" + roomid + "&roomType=" + roomType + "&floorNum=" + floorNum + "&seats=" + seats + "&numComputers=" + numComputers + "&limit=" + limit + "&beingEdited=" + beingEdited + "&hasComputers=" + hasComputers);// send stuff
	// Send the request to wlSaveChanges.php
	
}