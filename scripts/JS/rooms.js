
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
	}
	else
	{
		showrooms = false;
		document.getElementById('roomMenu').style.display = "none";
		document.getElementById('roomSelect').style.top = "13%";
		document.getElementById('roomWrapper').style.display = "inline";
		document.getElementById('selectedRoom').style.top = "14%";
	}
}

function selectRoom(id){
	document.getElementById('selectedRoom').innerHTML = "<b>" + id + "</b>";
	console.log(roomSelected);
	if (roomSelected != null){
		document.getElementById(roomSelected).style.backgroundColor = "white";
	}
	roomSelected = id;
	document.getElementById(id).style.backgroundColor = "gray";
	showrooms = false;
	document.getElementById('roomMenu').style.display = "none";
	document.getElementById('roomSelect').style.top = "13%";
	document.getElementById('roomWrapper').style.display = "inline";
	document.getElementById('selectedRoom').style.top = "14%";

	// HERE IS WHERE AJAX CALL TO MAIN CALENDAR GOES! updateCalendar()?
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
			var reservation = JSON.parse(this.responseText);
			var runString = "<h2>Your Active Reservations</h2>";
			runString+= "<br><table id = 'agendaTable' >\n<th>Room</th><th>From</th><th>To</th><th>Details</th>\n";
			for(var i = 0; i < reservation.length; i++){
				runString += "<tr id=" + i + ">\n";
				runString += "<td>" + reservation[i].roomnumber + "</td>";
				runString += "<td>" + reservation[i].start + "</td>";
				runString += "<td>"  + reservation[i].end + "</td>";
				runString += "<td><a >Edit</a><br><a onclick=openConfirmDelete(this.parentElement.parentElement)>Remove</a></td>";
				runString += "</tr>\n"; 
			}
			runString += "</table>";
			document.getElementById("agenda").innerHTML += runString;
		}
	};

	xmlhttp.open("GET", "scripts/PHP/res_user.php", true);
	xmlhttp.send();

    
}

function openConfirmDelete(ele){
	// first display the modal using display: block (by default should be none)
	// set id of info tag to append this info below.
	alert(ele.children[0].innerHTML + " " + ele.children[1].innerHTML + " " + ele.children[2].innerHTML);
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
	console.error(temp.getMonth() + " " + temp.getFullYear());

	xmlhttp.open("GET", "scripts/PHP/calendarLoad.php?month=" + temp.getMonth() + "&year=" + temp.getFullYear(), true);
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

function calendarNavi(month, year){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("mainCalendar").innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "scripts/PHP/calendarLoad.php?month=" + month + "&year=" + year, true);
	xhttp.send();
}