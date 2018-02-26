
var showrooms = false;

var roomSelected = null;

var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
	document.getElementById("roominsert").innerHTML = this.responseText;
   }
};
xhttp.open("GET", "scripts/PHP/allrooms.php", true);
xhttp.send();

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


function selectRoom(id){
	document.getElementById('selectedRoom').innerHTML = "<b>" + id + "</b>";
	console.log(roomSelected);
	if (roomSelected == null){
		document.getElementById('No Room Preference/All').style.backgroundColor = "white";
	}
	else{
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
	document.getElementById('roomMenu').style.display = "none";
	document.getElementById('roomSelect').style.top = "14%";
	document.getElementById('roomWrapper').style.display = "inline";
	document.getElementById('selectedRoom').style.top = "14%";
	document.getElementById('roomMenu').style.display = "none";
	document.getElementById('roomSelect').src = "images/down_arrow.png";
	
	document.body.style.backgroundColor = "rgba(0,0,0,0)";

	// HERE IS WHERE AJAX CALL TO MAIN CALENDAR GOES! updateCalendar()?
	loadCalendar();
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
			
			var runString = ""//"<h2 style='text-align:center' >Agenda</h2><br><hr><br><h2>Your Active Reservations</h2>";
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
	if (document.getElementById('deleteRes').style.display == "inline" && switchDelete == true){
		if (!document.getElementById('deleteRes').contains(e.target)){
			document.getElementById('deleteRes').style.display = "none";
			document.body.style.backgroundColor = "rgba(0,0,0,0)";
			switchDelete = false;
		}
	}
	if (document.getElementById('createRes').style.display == "inline" && switchCreate == true){
		if (!document.getElementById('createRes').contains(e.target)){
			document.getElementById('createRes').style.display = "none";
			document.body.style.backgroundColor = "rgba(0,0,0,0)";
			switchCreate = false;
		}
		
	}
	if (document.getElementById('deleteRes').style.display == "inline"){
		switchDelete = true;
	}
	if (document.getElementById('createRes').style.display == "inline"){
		switchCreate = true;
	}
}

function deleteClicked(id, id2){

	if (id == "yesDelete"){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				alert(this.responseText);
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
	document.getElementById('deleteRes').style.display = "inline";
	document.body.style.backgroundColor = "rgba(0,0,0,0.5)";
	document.getElementById('deleteRes').innerHTML = "<div id='delview'></div><br><br><h2>Are you sure you want to delete reservation:</h2><br><br><br><button id='yesDelete' onclick='deleteClicked(this.id," + String(ele.children[0].id) + ")'>Yes</button><button id='noDelete' onclick='deleteClicked(this.id, " + String(ele.children[0].id) + ")'>No</button>";
	document.getElementById('deleteRes').innerHTML += "<h3>" + ele.children[0].innerHTML + "</h2>";
	document.getElementById('deleteRes').innerHTML += "<h3>From:" + ele.children[1].innerHTML + "</h2>";
	document.getElementById('deleteRes').innerHTML += "<h3>To:" + ele.children[2].innerHTML + "</h2>";
	//alert(ele.children[0].innerHTML + " " + ele.children[1].innerHTML + " " + ele.children[2].innerHTML);

}


function openCreateRes(id){
	if (id.length < 5){
		return;
	}
	
	let date = id.substr(3);

	
	document.getElementById('createRes').style.display = "inline";
	document.body.style.backgroundColor = "rgba(0,0,0,0.5)";
	document.getElementById('createRes').innerHTML = "";
	// AJAX CALL HERE.
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("createRes").innerHTML = this.responseText;
		}
	};
	xhttp.open("POST", "scripts/PHP/Reservations.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("&date=" + date);
}


loadCalendar();

function loadCalendar(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("mainCalendar").innerHTML = this.responseText;
		}
	};

	let temp = new Date();
	//console.error(temp.getMonth() + " " + temp.getFullYear());

	xmlhttp.open("GET", "scripts/PHP/calendarLoad.php?room=" + roomSelected, true);
	xmlhttp.send();
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

function createClicked(){
	// sanity checks first.
	if (roomSelected == null)
	{
		document.getElementById('responseText').style.color = "red";
		document.getElementById('responseText').innerHTML = "Please choose a room first (at the top)!";
		return;
	}
	
	var email = document.getElementById("owneremail").value;
	var startHour = document.getElementById("startHour").value;
	var startMin = document.getElementById("startMinute").value;
	var endHour = document.getElementById("endHour").value;
	var endMin = document.getElementById("endMinute").value;
	var startDate = document.getElementById("startdate").value;
	var endDate = document.getElementById("enddate").value;
	var sharing = document.getElementById("allowshare").value;
	var numSeats = document.getElementById("numberOfSeats").value;
	var comment = document.getElementById("comment").value;
	var start = document.getElementById("start");
	var end = document.getElementById("end");
	var occur = document.getElementById("occur");
	end = end[end.selectedIndex].value;
	start = start[start.selectedIndex].value;
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
			document.getElementById('responseText').innerHTML = this.responseText;
			if (this.responseText == "Reservation made successfully"){
				document.getElementById('responseText').style.color = "green";
			}
			else{
				document.getElementById('responseText').style.color = "red";
			}
			setTimeout(function(){
				document.getElementById('createRes').style.display = "none";
				document.body.style.backgroundColor = "rgba(0,0,0,0)";
				switchCreate = false;
			}, 1500);
		}
		getAgendaReservations();
	};
	xhttp.open("POST", "scripts/PHP/CreateReservation.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("roomnumber=" + roomSelected + "&owneremail=" + email + "&allowshare=" + sharing + "&numberOfSeats=" + numSeats + "&starthour=" + startHour + "&startminute=" + startMin + "&startdate=" + startDate + "&enddate=" + endDate + "&endhour=" + endHour + "&endminute=" + endMin + "&start=" + start + "&end=" + end + "&occur=" + occur + "&comment=" + comment);
}

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
