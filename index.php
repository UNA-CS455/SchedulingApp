<?php
session_start();
?>

<html>
	<head><link rel="stylesheet" href="styles/rooms.css">
		<link rel="stylesheet" href="styles/Reservation.css">
		<link rel="stylesheet" href="styles/links.css">
		<title></title>
	
	</head>
	<body>  	
	<script src="scripts/JS/rooms.js"></script>
		<div id="banner">
			<img src="images/una.png" id="logo">
		</div>
		</div>
		<div class = "welcome">
        <?php
			if (isset($_SESSION['username'])) {
				echo "Welcome, " . $_SESSION['username'] ."<br>";
			}
        ?>
		</div>

	<a href="url" class="home" >Home</a>
	<a href="url" class="myReservations" >My Reservations</a>
	<a href="url" class="settings" >Settings</a>
	<a href="url" class="signOut" >Sign Out</a>

<div class="makeReservation" id="createZone">
  <div class="test">
  <h1>Make Reservation</h1>
    Reserving email*:
    <input type="text" id="owneremail" required>

	<div id="filterArea">
		<font id="typeText">Type:  </font> 
		<select id="typeSelect" onchange="fieldChanged()">
			<option value="Any">Any</option>
			<option value="Classroom">Classroom</option>
			<option value="Conference">Conference Room</option>
			<option value="Computer Lab">Computer Lab</option>
		</select>
	</div>

    <p>Duration*:</p>
	Date:
	<input id = 'date' name = 'date' type = 'date' onchange = "fieldChanged()"><br><br>
    Start time:
    <input id = "timeStart"  name = "startTime "type = "time" step = "900" width = "48" onchange = "fieldChanged()" required><br><br>

    End time:	
   <input id = "timeEnd" name = "endTime" type = "time" step = "900" width = "48" onchange = "fieldChanged()" required><br><br>
		
    Recurring:
    <select id="occur">
    <option value="Once">Just Once</option>
    <option value="Weekly">Weekly</option>
    <option value="Monthly">Monthly</option>
  </select><br><br>

    <input type="checkbox" onclick="changeSheet()" id="allowshare">Allow room sharing<br><br>

    <span id="numseatstext" style="visibility:hidden"> Expected number of seats needed: <input type="text" id="numberOfSeats" style="width: 48px;" onchange = "fieldChanged()"></span> <br><br>

    <!-- add css for this boi -->
    Comments<br>
    <textarea rows="10" cols="50" id="comment"></textarea><br><br><br><br><br><br><br><br><br>
	<input type="hidden" id = "startdate" value = <?php echo "'$date'"; ?>>
	<input type="hidden" id = "enddate" value = <?php echo "'$date'"; ?>>
	<br><br>
    <button onclick="createClicked()">Make reservation</button><br><br>
	<font id="responseText"></font>
</div>
</div>

<div class="calendar">
		<div id="createRes">
		
				<div id="roomMenu">
					
			<div id="bookArea">
				<table id="allRooms">
					<tbody id="roominsert">
					
					</tbody>
				</table>
			</div>
		</div>
		</div>

  <table style="width:100%">
		</div>		

	</body>
</html>
