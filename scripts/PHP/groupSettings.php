<?php
session_start();

if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page
$_SESSION['permission'] = "A"; // todo: remove this line
if ($_SESSION['permission']!= "A"){
	header('location: ../../login.html');
}

?>
<!DOCTYPE html>
<html>
<head>
 <link rel="stylesheet" href="../../styles/rooms.css">
 
	


<title>Settings</title>
</head>
<body onload='populateBlacklistRooms(null); populateGroupList();'>
		<div id="shader" onclick="shaderClicked()"></div>
	<script src="../JS/popup.js"></script>
    <script src="../JS/rooms.js"></script>
		
	<div id="banner">
	
        <img src="../../images/una.png" id="logo" onclick="window.location.href = '../../'">
		<button id="makeResButton" onclick="window.location.href = '../../'; showCreateResForm();">Make Reservation</button>
		<button id="monthViewButton" onclick="window.location.href = '../../#calView'; showCalendarView();">Month View</button>
        <button onclick="dropdownRes();"id="myResButton">My Reservations</button>
		<button id="settingsButton" onclick="window.location.href = 'userSettings.php'">Settings</button> 
		<div class = "welcome">
            <?php
            if (isset($_SESSION['username'])) {
				echo "<p id='welcomeText'>Welcome, " . $_SESSION['username'] ."</p><br>";
				$logged_in_user = $_SESSION['username']; //used for default in reserving email field.
            }
            ?>
			<button onclick="logoutUser();" class="signOut" >Logout</button>
		</div>
    </div>
	
	        <div style="position:absolute" id="agendaReservations"></div>

        <div id="deleteRes"></div>
	
	<div class = "d";
	<table id = "pages">
	  <tr>
		<th>Pages</th>
	  </tr>
	  <tr>
		<td><br><button class = "settingsButton" onclick="location.href='userSettings.php';">User Settings</button></td>
	  </tr>
	  <tr>
		<td><br><button class = "settingsButton" onclick="location.href='roomSettings.php';">Room Settings</button></td>
		<br>
	  </tr>
	</table>
	</div>

	<div id = "room"><h1> Group Settings </h1><br>

		<div class='groupsFrame' id='groupsArea'>
			<button style='width:100%'> Test </button>
			<button style='width:100%'> Test </button>
						<button style='width:100%'> Test </button>
			<button style='width:100%'> Test </button>
		</div>
			<h2 id='groupheader'></h2>
		    <div id="roomContainer"> 
			<!--
				This is the leftmost area of the page. Content is updated upon page load with the function fieldChanged().
				This area serves as the room selector.
			-->
			<span id="allroomsheader"></span>	
			<div id="bookArea"></div>
        </div>

	</div>
</body>
</html>

