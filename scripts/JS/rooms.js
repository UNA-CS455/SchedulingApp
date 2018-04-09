
/*
Needed globals
*/

var showres = false;
var roomSelected = null;
selectRoom(null);
var view = "res"; // or "cal" for calendar view.


//Leaves the number of seats text box grey and disabled if allowshare is not checked.
function changeSheet(){
	var checkbox = document.getElementById('allowshare').checked;
	if(checkbox == true){
		document.getElementById('numseatstext').style.visibility = "visible";
	}
	else {
		document.getElementById('numseatstext').style.visibility = "hidden";
		

	}
}

/*
Function that will update the room currently selected. Updates include changing the coloration of the 
respective box in the room selection area of the page to reflect the changes.

Authors: Derek, Dillon, Earl
April 2018

*/
function selectRoom(id){

	var notAvailableColor = '#1e1e1e';
	var availableUnselectedColor = "ghostwhite";
	var availableSelectedColor = "gray";
	if (roomSelected != null){
		var normalVersion = document.getElementById(roomSelected);
		var favoriteVersion = document.getElementById('fav_'+roomSelected);

		if(favoriteVersion != null){
			if(favoriteVersion.className.includes("notfound")){
				favoriteVersion.style.backgroundColor = notAvailableColor;
			} else
				favoriteVersion.style.backgroundColor = availableUnselectedColor;
		}
		if(normalVersion != null){
			normalVersion.style.backgroundColor = availableUnselectedColor;
		}
	} 
	if(normalVersion == null){
		var bookAreaParent = document.getElementById("bookArea");
		id = null;
		if(bookAreaParent != null){
			var firstRoom = bookAreaParent.childNodes[0];
			if(firstRoom != null){
				id = (firstRoom.className.includes("roombox")) ? firstRoom.id : null; 
				// only set the id if the firstRoom is in fact a room, not some other item such as the "No Results" text.
			}
				

		}
	}
	
	if(id != null && id.substring(0, 4) == "fav_"){
		id = id.substring(4);
	}


	
	roomSelected = id;
	
	var normalVersion = document.getElementById(id);
	var favoriteVersion = document.getElementById('fav_'+id);

	if(favoriteVersion != null){
		favoriteVersion.style.backgroundColor = availableSelectedColor;
	}
	if(normalVersion != null){
		normalVersion.style.backgroundColor = availableSelectedColor;
	}
	
	if(view == "cal")
		updateCalendar();
	else
		updateReserveButtonText();


}

/*
A function whose purpose is to populate the agenda table with the user's
current reservations with a given email address.
Author: Derek Brown
Spring 2018
*/
function getAgendaReservations() {

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			//console.error(this.responseText);
			var reservation = JSON.parse(this.responseText);
			
			var runString = "<h2 style='text-align:center' >Active Reservations</h2>";
			runString+= "<br><table id = 'agendaTable' >\n<th>Room</th><th>From</th><th>To</th><th>Details</th>\n";
			for(var i = 0; i < reservation.length; i++){

				runString += "<tr id=" + i + ">\n";
				runString += "<td id=" + reservation[i].id + ">" + reservation[i].roomnumber + "</td>";
				runString += "<td>" + reservation[i].startdate + "<br>" + reservation[i].starttime +reservation[i].start + "</td>";
				runString += "<td>" + reservation[i].enddate + "<br>" + reservation[i].endtime + reservation[i].end +"</td>";
				runString += "<td><a >Edit</a><br><a style='color: blue' onclick=openConfirmDelete(this.parentElement.parentElement)><u>Remove</u></a></td>";
				runString += "</tr>\n"; 
			}
			runString += "</table>";
			document.getElementById("agendaReservations").innerHTML = runString;
		}
	};

	if (window.location.href.includes('PHP')){
		xmlhttp.open("GET", "res_user.php", true);
	}
	else{
		xmlhttp.open("GET", "./scripts/PHP/res_user.php", true);
	}
	
	
	xmlhttp.send();

    
}

window.addEventListener('click', function(e){
	handleClick(e);
});

var switchDelete = false;
var switchCreate = false;

function handleClick(e){

}

/*
Function to perform the deletion of a reservation from the My Reservations table.
*/
function deleteClicked(id, id2){

	if (id == "yesDelete"){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//alert(this.responseText);
				buttonhtml =  "<button class='modal-button' onclick='closeModal()'>Ok</button>"
				showMessageBox(this.responseText ,"Delete Reservation",buttonhtml, false);
				document.getElementById('deleteRes').style.display = "none";
				document.body.style.backgroundColor = "rgba(0,0,0,0)";
				switchDelete = false;
				getAgendaReservations();
			}
		};

		let temp = new Date();
		

		xmlhttp.open("POST", "scripts/PHP/room_remove.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("id=" + id2);
		//loadCalendar(); // reload the calendar to reflect new reservations.
	}
	else{
		document.getElementById('deleteRes').style.display = "none";
		document.body.style.backgroundColor = "rgba(0,0,0,0)";
		switchDelete = false;
	}
}

let lastDeleteClicked = null;

function openConfirmDelete(ele){
	// first display the modal using display: block (by default should be none)
	// set id of info tag to append this info below.

	lastDeleteClicked = ele;
	buttonhtml =  "<button class='modal-button' onclick='closeModal()'>Ok</button>"
	showMessageBox("<br><br>Are you sure you want to delete reservation:<br><br>" + ele.children[0].innerHTML + "<br>From:<br>" + ele.children[1].innerHTML + "<br>To:<br>" + ele.children[2].innerHTML + "<br><br><button class = 'modal-button' id='yesDelete' onclick='deleteClicked(this.id," + String(ele.children[0].id) + ")'>Yes</button><button class='modal-button' id='noDelete' onclick='closeModal()'>No</button>" ,"Delete Reservation","", false);

}

/*
Function that will update the reserve button to display text that reflects the currently selected room.

Author: Derek Brown
April 7, 2018
*/
function updateReserveButtonText(){

	
	if(document.getElementById('reserveButton') != null){
		if(roomSelected != null){
			document.getElementById('reserveButton').disabled = false;
			document.getElementById('reserveButton').value = "Reserve " + roomSelected;
		} else {
			document.getElementById('reserveButton').value = "No Room Selected";
			document.getElementById('reserveButton').disabled = true;
		}
	}
}

/*
Function that will be called when a desire to swap views to calendar view exists.
We call this function when swapping to the view because if you just called updateCalendar()
by itself, the calendar shown would not have the correct data within it, since at the point of
swapping between some views, such as redirection from the settings page, roomSelected might be
null before the updateCalendar function is called and the calendar will instead show all reservations
while incorrectly having a specific room selected.

Author: Derek Brown.
Date: 4/7/2018
*/
function showCalendarView(){
	view = "cal"; // change views
	fieldChanged(true); // load all rooms
	updateCalendar(); // produce the calendar.
}

/*
AJAX call to display and update the calendar within the rightmost area of index.php.
Author: Derek Brown
Date: 4/7/2018
*/
function updateCalendar(){
	var area = document.getElementById('createZone');
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			area.innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "scripts/PHP/calendarLoad.php?room="+roomSelected, true);
	xhttp.send();
}

/*
AJAX call to update rightmost area of index.php with the create reservation form fields.
Author: Derek Brown
Date: 4/7/2018
Edits: 
	-4/8/2018 by Dillon Borden
		- add a check to determine if a redirect to index.php should instead display the 
		calendar view, such as redirecting from settings.php.

*/
function showCreateResForm(){
	if (window.location.hash === "#calView"){
		showCalendarView();
		window.location.hash = "";
		var clean_uri = location.protocol + "//" + location.host + location.pathname;
		window.history.replaceState({}, document.title, clean_uri);
		return;
	}
	
	var area = document.getElementById('createZone');
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			area.innerHTML = this.responseText;
			updateReserveButtonText();
			view = "res";
		}
	};
	xhttp.open("GET", "scripts/PHP/resFormView.php", true);
	xhttp.send();
	
}

/*
Handles any change of input field for the "Make Reservation" area. Should be called as the onchange event
for each input field. This function will filter the rooms based on the content currently in all fields.

Author: Derek Brown
March 2018
*/
function fieldChanged(getAll){
	var GETString = "?q=";
	
	//Get variables from fields
	// if getAll is true, then we skip this part and just return all rooms. Otherwise a call to
	// fieldChanged() or fieldChanged(false) will assume we are looking at the make reservation
	// screen and will probe those fields for data to use during the room retrieval.
	if(getAll == null || !getAll){
		if(document.getElementById('responseText')!= null)
			document.getElementById('responseText').innerHTML = "";
		updateReserveButtonText();
		var checkbox = false;
		if(document.getElementById('allowshare') != null){
			var checkbox = document.getElementById('allowshare').checked;
		}
		var type = document.getElementById('typeSelect');
		var starttime = document.getElementById('timeStart');
		var endtime = document.getElementById('timeEnd');
		var recurring = document.getElementById('occur');
		var seats = document.getElementById('numberOfSeats');
		var date = document.getElementById('date');
		

		if(type !== null && type.selectedIndex != 0){
			GETString += ("&type=" + type.options[type.selectedIndex].value);
		}
		if((starttime !== null && starttime.value.length > 0) && (endtime !== null && endtime.value.length > 0) && (date !== null && date.value.length > 0)){
			GETString += ("&starttime='"+starttime.value+"'&endtime='"+endtime.value+"'&date='"+date.value+"'");
		}
		if(recurring !== null && recurring.selectedIndex != 0){
			GETString += ("&recur=" + recurring.selectedIndex); // pass the index, which will be our enumerated type.
		}

		if(seats !== null && seats.value.length > 0 && checkbox == true){
			if (!(/^\+?(0|[1-9]\d*)$/.test(seats.value)) || seats.value <=0) {
				document.getElementById('responseText').style.color = "red";
				document.getElementById('responseText').innerHTML = "Please only enter positive numbers as a headcount!";
				return;
			}
			else {
				GETString += ("&headcount=" + seats.value);
			}

		}
	}

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState === 4 && this.status === 200) {
			document.getElementById("roomContainer").innerHTML = this.responseText;
			if(document.getElementById("allroomsheader") != null && document.getElementById("favsheader") != null){
				document.getElementById("allroomsheader").innerHTML = "<h1 style='font-size: 19;'>All Rooms<h1>"
				document.getElementById("favsheader").innerHTML = "<h1 style='font-size: 19;'>Favorites<h1>"
			}
			selectRoom(roomSelected);
		}
	};
	xhttp.open("GET", "scripts/PHP/retrieveRooms.php" + GETString, true);
	xhttp.send();


}




/*
Function to be called when the intention is to perform an insert into the database of a new reservation.
will perform sanity checks and acquire variables needed to pass to CreateReservation.php. Any values obtained here
should also be checked on the server side for sanitation.
*/
function createClicked(){
// sanity checks first.
	document.getElementById('responseText').innerHTML = "";
	if (roomSelected == null)
	{
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Select a room to the left and ensure all fields are complete.";
		return;
	}

	var email = document.getElementById("owneremail").value;
	var startTime = document.getElementById("timeStart").value;
	var endTime = document.getElementById("timeEnd").value;
	var date = document.getElementById("date").value;
	var sharing = Number( document.getElementById("allowshare").checked);
	var startHour = startTime.charAt(0) + startTime.charAt(1);
	var startMin = startTime.charAt(3) + startTime.charAt(4);
	var endHour = endTime.charAt(0) + endTime.charAt(1);
	var endMin = endTime.charAt(3) + endTime.charAt(4);
	var numSeats = document.getElementById("numberOfSeats").value;
	var comment = document.getElementById("comment").value;
	var occur = document.getElementById("occur");

	occur = occur[occur.selectedIndex].value;
	if (email == ""){
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Please enter an email first!";
		return;
	}

	if (startHour == "" || startMin == ""){
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Please enter a full start time first!";
		return;
	}

	if (endHour == "" || endMin == ""){
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Please enter a full end time first!";
		return;
	}

	if (/^\d+$/.test(startHour) && /^\d+$/.test(startMin)) {
	// Contain numbers only
	}
	else {
	// Contain other characters also
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Please only enter numbers in start time boxes!";
		return;
	}

	// check headcount
	if(sharing){
		if (!(/^\+?(0|[1-9]\d*)$/.test(numSeats)) || numSeats <=0) {
			document.getElementById('responseText').style.color = "red";
			document.getElementById('responseText').innerHTML = "Please only enter positive numbers as a headcount!";
			return;
		}
	}

	if (startMin.length > 2 || endMin.length > 2){
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Times can only be 2 numbers in length!";
		return;
	}



	if (/^\d+$/.test(endHour) && /^\d+$/.test(endMin)) {
	// Contain numbers only
	}
	else {
	// Contain other characters also
	document.getElementById('responseText').style.color = "red";
	document.getElementById('responseText').innerHTML = "Please only enter numbers in end time boxes!";
	return;
	}

	if (document.getElementById('allowshare').checked == true && numSeats == ""){
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Please specifiy a number of seats needed, or disable sharing.";
		return;
	}

	// ajax call to create script.
	console.log('here');

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			//document.getElementById('responseText').innerHTML = this.responseText;
			showMessageBoxOK(this.responseText,"Make Reservation", false);
			clearFields();
		}
	};
	xhttp.open("POST", "scripts/PHP/CreateReservation.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("roomnumber=" + roomSelected + "&owneremail=" + email + "&allowshare=" + sharing + "&numberOfSeats=" + numSeats + "&starthour=" + startHour + "&startminute=" + startMin + "&date=" + date + "&endhour=" + endHour + "&endminute=" + endMin + "&occur=" + occur + "&comment=" + comment);

}



/*
Should be called whenever a star is clicked, will update UI and perform necessary insertions or removals
from the favorites table for the currently logged in user.
*/
function favoriteClicked(parentEle){
	let star = document.getElementById(parentEle.id);
	var roomId = parentEle.id;
	if(roomId.substring(0,4) == "fav_"){
		roomId = roomId.substring(4);
	}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			fieldChanged();
		}
	};
	xhttp.open("POST", "scripts/PHP/favorite.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	if (star.children[0].src.includes("images/fav-unselect.png")){
		// add a favorite.
		xhttp.send("add=yes&roomid=" + roomId);
	}
	else{
		// remove a favorite.
		xhttp.send("add=no&roomid=" + roomId);
	}
}

// Dillon Borden
function shaderClicked(){
	showres = false;
		//document.body.style.backgroundColor = "rgba(0,0,0,1)";
		document.getElementById('agendaReservations').style.display = "none";
		document.getElementById('deleteRes').style.display = "none";
		document.getElementById('shader').style.display = "none";
}	

// Dillon Borden
function dropdownRes() {
	getAgendaReservations();
    //
	if (showres == false){
		showres = true;
		//document.body.style.backgroundColor = "rgba(0,0,0,0.5)";
		document.getElementById('agendaReservations').style.display = "block";
		document.getElementById('shader').style.display = "block";
	}
	else{
		showres = false;
		//document.body.style.backgroundColor = "rgba(0,0,0,1)";
		document.getElementById('agendaReservations').style.display = "none";
		document.getElementById('deleteRes').style.display = "none";
		document.getElementById('shader').style.display = "none";
	}
	
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

/*
Funciton to be called when the user desires to log out manually.

*/
function logoutUser(){
	
	
	if(window.location.href.includes('scripts/PHP/')){
		window.location.href = 'logout.php';
	}
	else{
		if (window.location.href.includes('index.php')){
			window.location.href += '/scripts/PHP/logout.php';
		}
		else{
			window.location.href += 'scripts/PHP/logout.php';
		}
		
	}
}

/*
Function to be called when the make reservation button has been clicked. Opens a confirmation dialog to
ask the user to confirm their reservation details.
Author: Derek Brown
Date: 4/2/2018 
*/


function openConfirmCreate(){
	if (roomSelected == null){
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Select a room to the left and ensure all fields are complete.";
		return;
	}

	buttonhtml =  "<button class='modal-button' onclick='closeModal(); createClicked();'>Book it!</button><button class='modal-button' onclick='closeModal()'>Cancel</button>"
	showMessageBox("Are you sure you want to reserve " + roomSelected + "?" ,"Confirm",buttonhtml, false);

	
}



/*
Function to be called when the make reservation button has been clicked. Opens a confirmation dialog to
ask the user to confirm their reservation details.
Author: Derek Brown
Date: 4/2/2018


function openConfirmCreate(){
	if (roomSelected == null){
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Select a room to the left and ensure all fields are complete.";
		return;
	}
	
	var details = "";
	var xhttp = new XMLHttpRequest();
	console.error("here");
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			
			details = this.responseText;
				buttonhtml =  "<button class='modal-button' onclick='closeModal(); createClicked();'>Book it!</button><button class='modal-button' onclick='closeModal()'>Cancel</button>"
				showMessageBox("Are you sure you want to reserve " + roomSelected + "?<br>" + details ,"Confirm",buttonhtml, false);
		}
		console.error(this);
	};
	
	xhttp.open("GET", "scripts/PHP/Confirmation.php?resEmail=" + email + "&allowshare=" + sharing + "&numberOfSeats=" + numSeats + "&timeStart=" + startHour + ":" + startMin + "&date=" + date + "&timeEnd=" + endHour + ":" + endMin + "&occur=" + occur + "&comment=" + comment);
	xhttp.send();

	
}

*/

/*
Function to clear input fields under the Make Reservation section.
Author: Derek Brown
Date: 4/2/2018

*/
function clearFields(){

	document.getElementById('responseText').innerHTML = "";
	document.getElementById("occur").selectedIndex= 0;
	document.getElementById("typeSelect").selectedIndex= 0;
	document.getElementById("timeStart").value= '';
	document.getElementById("timeEnd").value= '';
	//document.getElementById("date").value= '';
	changeSheet();
	//document.getElementById("allowshare").checked= false;
	document.getElementById("numberOfSeats").value = '';
	document.getElementById("comment").value= '';
	fieldChanged();
	
}


function showDayViewModal(date, room){

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			//document.getElementById("").innerHTML = this.responseText;
			showMessageBox(this.responseText,"Day View - " + roomSelected + " for " + date,"", true);
		}
	};
	xhttp.open("GET", "scripts/PHP/dayView.php?date=" + date + "&room=" + room, true);
	xhttp.send();

}


function calendarDateClicked(date){
	showDayViewModal(date.substring(3),roomSelected);
}




function calendarNavi(month, year){
	var area = document.getElementById('createZone');
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			area.innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "scripts/PHP/calendarLoad.php?month=" + month + "&year=" + year + "&room=" + roomSelected, true);
	xhttp.send();
}


function findDay(dayNum){
	switch (dayNum){
		case "01":
			return "January";
		case "02":
			return "February";
		case "03":
			return "March";
		case "04":
			return "April";
		case "05":
			return "May";
		case "06":
			return "June";
		case "07":
			return "July";
		case "08":
			return "August";
		case "09":
			return "September";
		case "10":
			return "October";
		case "11":
			return "November";
		case "12":
			return "December";	
	}
}

/*
function openCreateRes(id){
	if (id.length < 5){
		return;
	}
	
	let date = id.substr(3);
	let year = date.slice(0, 4);
	let month = date.slice(5, 7);
	month = findDay(month);
	let day = date.slice(8,10);
	let roomChoice = roomSelected;
	if (roomChoice == null){
		roomChoice = "All Rooms";
	}
	let formattedLabel = day + " " + month + " " + year + " - " + roomChoice;
	

	document.getElementById('createRes').style.display = "inline";
	document.body.style.backgroundColor = "rgba(0,0,0,0.5)";
	document.getElementById('createRes').innerHTML = "";
	// AJAX CALL HERE.
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("createRes").innerHTML = this.responseText;
			document.getElementById('createLabel').innerHTML = formattedLabel;
		}
	};
	xhttp.open("POST", "scripts/PHP/Reservations.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	console.error(roomChoice);
	xhttp.send("date=" + date + "&room=" + roomChoice);
}

function typeChanged(id){
	var e = document.getElementById('compSelect');
	var f = document.getElementById('floorSelect');
	if (id == "Any" && e.options[e.selectedIndex].value == "Any" && f.options[f.selectedIndex].value == "Any"){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("roominsert").innerHTML = this.responseText;
		}
		};
		xhttp.open("GET", "scripts/PHP/allrooms.php", true);
		xhttp.send();
	}
	else{
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("roominsert").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "scripts/PHP/roombytype.php?type=" + id + "&floor=" + f.options[f.selectedIndex].value + "&comp=" + e.options[e.selectedIndex].value, true);
		xhttp.send();
	}
	

}

function floorChanged(id){
	var e = document.getElementById('typeSelect');
	var f = document.getElementById('compSelect');
	if (id == "Any" && e.options[e.selectedIndex].value == "Any" && f.options[f.selectedIndex].value == "Any"){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("roominsert").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "scripts/PHP/allrooms.php", true);
		xhttp.send();
	}
	else{
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("roominsert").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "scripts/PHP/roombytype.php?type=" + e.options[e.selectedIndex].value + "&floor=" + id + "&comp=" + f.options[f.selectedIndex].value, true);
		xhttp.send();
	}
	
}

function compChanged(id){
	var e = document.getElementById('typeSelect');
	var f = document.getElementById('floorSelect');
	if (id == "Any" && e.options[e.selectedIndex].value == "Any" && f.options[f.selectedIndex].value == "Any"){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("roominsert").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "scripts/PHP/allrooms.php", true);
		xhttp.send();
	}
	else{
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("roominsert").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "scripts/PHP/roombytype.php?type=" + e.options[e.selectedIndex].value + "&floor=" + f.options[f.selectedIndex].value + "&comp=" + id, true);
		xhttp.send();
	}
	
}

function toggleRoomView()
{
	if (showrooms == false)
	{
		showrooms = true;
		document.getElementById('roomMenu').style.display = "inline";
		document.getElementById('roomSelect').style.top = "88%";
		document.getElementById('roomWrapper').style.display = "none";
		document.getElementById('selectedRoom').style.top = "88%";
		document.getElementById('roomSelect').src = "images/up_arrow.png";
		document.body.style.backgroundColor = "rgba(0,0,0,0.5)";
	}
	else
	{
		showrooms = false;
		document.getElementById('roomMenu').style.display = "none";
		document.getElementById('roomSelect').style.top = "14%";
		document.getElementById('roomWrapper').style.display = "inline";
		document.getElementById('selectedRoom').style.top = "14%";
		document.getElementById('roomSelect').src = "images/down_arrow.png";
		document.body.style.backgroundColor = "rgba(0,0,0,0)";
	}
}


*/


