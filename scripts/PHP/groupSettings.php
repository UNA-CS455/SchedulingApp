<?php
session_start();

if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page

if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="../../favicon.ico" />
 <link rel="stylesheet" href="../../styles/rooms.css">
  <link rel="stylesheet" href="../../styles/popup.css">
	


<title>Settings</title>
</head>
<body onload='populateBlacklistRooms(null); populateGroupList();'>
<?php require '../../modal.php';
?>
		<div id="shader" onclick="shaderClicked()"></div>
	<script src="../JS/popup.js"></script>
    <script src="../JS/rooms.js"></script>
	
	<?php include '../../modal.php'; ?>
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
	  </tr>
	  <tr>
		<td><br><button class = "settingsButton" onclick="location.href='groupSettings.php';">Group Settings</button></td>
		<br>
	  </tr>
	</table>
	</div>

	<div id = "room"><h1> Group Settings </h1><br>

		<div class='groupsFrame' id='groupsArea'>

		</div>
			<h1 id='groupheader'></h1>
		    <div id="roomContainer"> 
			<!--
				The rooms are populated here along with their blacklist status via the javascript function populateBlacklistRooms() which is fired onload in the body tag above.
			
			<span id="allroomsheader"></span>	
			<div id="bookArea"></div>-->
        </div>
		<span id='deleteGroupButtonArea'></span>
	</div>
</body>
</html>

