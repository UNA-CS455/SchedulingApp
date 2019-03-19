var xhttp;
var saveObject;


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
	
	var saveObject = {
		numComp : numComputers,
		hasComp : hasComputers,
		lim : limit,
		seatNum : seats,
		floor : floorNum,
		roomT : roomType,
		roomID : roomid,
		edit : beingEdited
	};
	

    var buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='yesAddWL' >Yes</button> <button class='modal-button btn btn-danger' id='noAddWL' onclick='closeModal()'>No</button>";
	showMessageBox("<br><br>Are you sure you want to add:<br><br>" + name, "Add user", buttonhtml, false);

	
	document.getElementById('yesAddWL').onclick = function() {
		closeModal();
		addWL(name, roomid, saveObject);
		
		//save changes
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
function addWL(name, roomid, saveObject){
	// xhttp send is structured like this:
		// xhttp.send("variable=" + variable + "&variable2=" + variable2 + ...)
		
	var xhttp = new XMLHttpRequest();
	var userExists = 0;
	var inserted = false;
	
	if (window.location.href.includes('PHP'))
	{
		xhttp.open("POST", "../../scripts/PHP/userExistsCheck.php", true);
	}
	else
	{
		xhttp.open("POST", "scripts/PHP/userExistsCheck.php", true);
	}
	
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && this.status == 200){
	        userExists = xhttp.responseText;
	        
        	if (window.location.href.includes('PHP')){
				xhttp.open("POST", "../../scripts/PHP/addUserWhitelist.php", true);
			}
			else{
				xhttp.open("POST", "scripts/PHP/addUserWhitelist.php", true);
			}
	        
	        if(!inserted){
	        	if(userExists == 1){
		    		//document.getElementById("reserveBox").innerHTML = xhttp.responseText;
		    		inserted = true;
		    		userExists = 0;
		    		
		    		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("allowedUser=" + name + "&roomid=" + roomid);
					
					document.getElementById("reserveBox").innerHTML += xhttp.responseText;
	        	}
	        	else{
					showMessageBoxOK("User does not exist!", "Error", false);
	        	}
	        }
	        else{
        	    var buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='yesAddWL' onclick='saveChanges(saveObject); window.location.reload();'>Ok</button>";
	        	showMessageBox("", "Success!", buttonhtml, false);
	        }
	        
		}
	};
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("allowedUser=" + name);// send stuff

	// }
	// else{
	// 	showMessageBoxOk("User does not exist!", "ERROR", true); // Error finding person, they don't exist!
	// }
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
function saveChanges(saveObject){
	
	// roomid, roomType, floorNum, seats, numComputers, limit, beingEdited, hasComputers
	
	var xhttp = new XMLHttpRequest();

	alert("In saveChanges");

	if (window.location.href.includes('PHP'))
	{
		xhttp.open("POST", "../../scripts/PHP/wlSaveChanges.php", true);
	}
	else
	{
		xhttp.open("POST", "scripts/PHP/wlSaveChanges.php", true);
	}
	
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && this.status == 200){
	        
		}
	};
	
	
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
	
	alert("saveObject.roomID = " + saveObject.roomID);
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("roomid=" + saveObject.roomID + "&roomType=" + saveObject.roomT + "&floorNum=" + saveObject.floor + "&seats=" + saveObject.seatNum + "&numComputers=" + saveObject.numComp + "&limit=" + saveObject.lim + "&beingEdited=" + saveObject.edit + "&hasComputers=" + saveObject.hasComp);// send stuff
}