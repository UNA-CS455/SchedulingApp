<?php session_start();

if (!isset($_SESSION['username'])) {
	header("location:login.html");
	exit;
}
 
?>

<!DOCTYPE html>
<html>
	<head><link rel="stylesheet" href="styles/rooms.css">
		<link rel="stylesheet" href="styles/calendar.css">
		<link rel="stylesheet" href="styles/Reservation.css">
		<title></title>
	</head>
	<body onload="getAgendaReservations()">  	
	<script src="scripts/JS/rooms.js"></script>
		<img src="images/down_arrow.png" id="roomSelect" onclick="toggleRoomView()"></img>
		<div id="banner">
			<img src="images/una.png" id="logo">
			</div>
		</div>
		<div id="roomWrapper"></div>
		<font id="selectedRoom"><b>No Room Preference/All</b></font>
		<div id="roomMenu">
			<div id="filterArea">
				<font id="filtersText">Filters</font>
				<font id="typeText">Type: </font>
				<select id="typeSelect" onchange="typeChanged(this.value)">
					<option value="Any">Any</option>
					<option value="Classroom">Classroom</option>
					<option value="Conference">Conference Room</option>
					<option value="Computer Lab">Computer Lab</option>
				</select>
				<font id="floorText">Floor: </font>
				<select id="floorSelect" onchange="floorChanged(this.value)">
					<option value="Any">Any</option>
					<option value="first">First</option>
					<option value="second">Second</option>
					<option value="third">Third</option>
				</select>
				<font id="compText">Has Computers: </font>
				<select id="compSelect" onchange="compChanged(this.value)">
					<option value="Any">Any</option>
					<option value="yes">Yes</option>
					<option value="no">No</option>
				</select>
			</div>
			<div id="bookArea">
				<table id="allRooms">
					<tbody id="roominsert">
					
					</tbody>
				</table>
			</div>
		</div>


		<div id="createRes">
		</div>
		<div id="editRes">
		</div>
		<div id="deleteRes">
			<br><br><h3>Are you sure you want to delete reservation:</h3><br><br><br><br>
			<button id="yesDelete" onclick="deleteClicked(this.id)">Yes</button>
			<button id="noDelete" onclick="deleteClicked(this.id)">No</button>
		</div>

		<div id="master-content">
			<div id="agenda">
				<span id="agenda-head">
					<h2 style="text-align:center; color:white; left:10px;"  > Agenda</h2><br>
				</span>
				<br>
				<span id="agendaReservations"></span>
			</div>
			<div id="mainCalendar">
			
			</div>
		</div> <? //TODO: add me me ?>

		
	</body>
</html>
