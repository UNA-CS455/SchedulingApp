
/*
Needed globals
*/
var showrooms = false;
var showres = false;
var roomSelected = null;


var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
	document.getElementById("roominsert").innerHTML = this.responseText;
   }
};
xhttp.open("GET", "scripts/PHP/allrooms.php", true);
xhttp.send();

/*
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


function selectRoom(id){
	if (roomSelected != null){
		document.getElementById(roomSelected).style.backgroundColor = "white";
	}
	
	if (id == "No Room Preference/All"){
		roomSelected = null;
	}
	else{
		roomSelected = id;
	}
	
	
	document.getElementById(id).style.backgroundColor = "gray";
	showrooms = false;
	

}

/*
	A function whose purpose is to populate the agenda table with the user's
	current reservations with a given email address.
	Author: Derek Brown
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

	xmlhttp.open("GET", "./scripts/PHP/res_user.php", true);
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
	/*
	document.getElementById('deleteRes').style.display = "inline";
	
	document.getElementById('deleteRes').innerHTML = "<div id='delview'></div><br><br><h2>Are you sure you want to delete reservation:</h2><br><br><br><button id='yesDelete' onclick='deleteClicked(this.id," + String(ele.children[0].id) + ")'>Yes</button><button id='noDelete' onclick='deleteClicked(this.id, " + String(ele.children[0].id) + ")'>No</button>";
	document.getElementById('deleteRes').innerHTML += "<h3>" + ele.children[0].innerHTML + "</h2>";
	document.getElementById('deleteRes').innerHTML += "<h3>From:" + ele.children[1].innerHTML + "</h2>";
	document.getElementById('deleteRes').innerHTML += "<h3>To:" + ele.children[2].innerHTML + "</h2>";
	//alert(ele.children[0].innerHTML + " " + ele.children[1].innerHTML + " " + ele.children[2].innerHTML);
	*/
	buttonhtml =  "<button class='modal-button' onclick='closeModal()'>Ok</button>"
	showMessageBox("<br><br>Are you sure you want to delete reservation:<br><br>" + ele.children[0].innerHTML + "<br>From:<br>" + ele.children[1].innerHTML + "<br>To:<br>" + ele.children[2].innerHTML + "<br><br><button class = 'modal-button' id='yesDelete' onclick='deleteClicked(this.id," + String(ele.children[0].id) + ")'>Yes</button><button class='modal-button' id='noDelete' onclick='closeModal()'>No</button>" ,"Delete Reservation","", false);

}

/*
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
*/
function fieldChanged(){
//Get variables from fields
var checkbox = document.getElementById('allowshare').checked;
var type = document.getElementById('typeSelect');
var starttime = document.getElementById('timeStart');
var endtime = document.getElementById('timeEnd');
var recurring = document.getElementById('occur');
var seats = document.getElementById('numberOfSeats');
var date = document.getElementById('date');
var GETString = "?q=";

if(type !== null && type.selectedIndex != 0){
	GETString += ("&type=" + type.options[type.selectedIndex].value);
}
if((starttime !== null && starttime.value.length > 0) && (endtime !== null && endtime.value.length > 0) && (date !== null && date.value.length > 0)){
	GETString += ("&starttime='"+starttime.value+"'&endtime='"+endtime.value+"'&date='"+date.value+"'");
}
if(recurring !== null && recurring.selectedIndex != 0){
	GETString += ("&recur=" + recurring.selectedIndex); // pass the index, which will be our enumerated type.
}
if(seats !== null && seats.value >0 && checkbox == true){
	GETString += ("&headcount=" + seats.value);
}


var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
	if (this.readyState === 4 && this.status === 200) {
		document.getElementById("roominsert").innerHTML = this.responseText;
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
	//var start = document.getElementById("start");
	//var end = document.getElementById("end");
	var occur = document.getElementById("occur");
	//end = end[end.selectedIndex].value;
	//start = start[start.selectedIndex].value;
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

	if (/^\d+$/.test(numSeats)) {
	// Contain numbers only
	}
	else {
	// Contain other characters also
	if (sharing){
	// Contain other characters also
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Please only enter numbers as a headcount!";
		return;
	}
	}

	if (Number(numSeats) > 60){
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Headcount cannot be bigger than 60!";
		return;
	}

	if (startMin.length > 2 || endMin.length > 2){
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Times can only be 2 numbers in length!";
		return;
	}

	if (Number(startMin) > 59 || Number(endMin) > 59){
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Times cannot be bigger than 60 minutes!";
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
		document.getElementById('responseText').innerHTML = "Please enter number of seats or do not share!";
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
			/*
			if (this.responseText == "Reservation made successfully"){
				document.getElementById('responseText').style.color = "green";
			}
		else
		{
			document.getElementById('responseText').style.color = "red";
		}
		*/
		}
	};
	xhttp.open("POST", "scripts/PHP/CreateReservation.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("roomnumber=" + roomSelected + "&owneremail=" + email + "&allowshare=" + sharing + "&numberOfSeats=" + numSeats + "&starthour=" + startHour + "&startminute=" + startMin + "&date=" + date + "&endhour=" + endHour + "&endminute=" + endMin + "&occur=" + occur + "&comment=" + comment);
}


/*
function calendarNavi(month, year){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("mainCalendar").innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "scripts/PHP/calendarLoad.php?month=" + month + "&year=" + year + "&room=" + roomSelected, true);
	xhttp.send();
}

*/

function favoriteClicked(parentEle){
	let star = document.getElementById(parentEle.id);
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("roominsert").innerHTML = this.responseText;
					}
				};
				xhttp.open("GET", "scripts/PHP/allrooms.php", true);
				xhttp.send();
		}
	};
	xhttp.open("POST", "scripts/PHP/favorite.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	if (star.children[0].src.includes("images/fav-unselect.png")){
		// add a favorite.
		xhttp.send("add=yes&roomid=" + parentEle.id);
	}
	else{
		// remove a favorite.
		xhttp.send("add=no&roomid=" + parentEle.id);
	}
}




function dropdownRes() {
	getAgendaReservations();
    //
	if (showres == false){
		showres = true;
		//document.body.style.backgroundColor = "rgba(0,0,0,0.5)";
		document.getElementById('agendaReservations').style.display = "block";
	}
	else{
		showres = false;
		//document.body.style.backgroundColor = "rgba(0,0,0,1)";
		document.getElementById('agendaReservations').style.display = "none";
		document.getElementById('deleteRes').style.display = "none";
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

function logoutUser(){
	window.location.href += './scripts/PHP/logout.php';
	//console.log('to be implemented....');
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
	document.getElementById("date").value= '';
	document.getElementById("allowshare").checked= false;
	document.getElementById("numberOfSeats").value = '';
	document.getElementById("comment").value= '';
	fieldChanged();
	
}
