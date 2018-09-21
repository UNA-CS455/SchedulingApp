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
	
<script>

function findRoom(str) {
    if (str.length == 0) {
        document.getElementById("roomInfo").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("roomInfo").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "getRooms.php?q=" + str, true);
        xmlhttp.send();
    }
}
</script>

<title>Settings</title>
</head>
<body>
<?php require '../../modal.php';
?>
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
	  </tr>
	  <tr>
		<td><br><button class = "settingsButton" onclick="location.href='groupSettings.php';">Group Settings</button></td>
		<br>
	  </tr>
	</table>
	</div>

	<div id = "room"><h1> Room Settings </h1><br>
	<form>
		<p><b>Search Room:</b></p>
		<input type="text" onkeyup="findRoom(this.value)">
		</form>
		<p>  <span id="roomInfo"></span></p>
		<br><br>
		<?php
			if(isset($_SESSION['msg'])){
				echo "<br>";
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
				
			}
		?>
	</div>
</body>
</html>

