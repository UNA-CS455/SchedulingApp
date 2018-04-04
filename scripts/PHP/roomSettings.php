<?php
session_start();
/*
if (!isset($_SESSION['username'])){
	header('location: login.html');
}
*/
?>
<!DOCTYPE html>
<html>
<head>
 <link rel="stylesheet" href="../../styles/rooms.css">
 
	
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
		<div id="shader" onclick="shaderClicked()"></div>
	<script src="../JS/popup.js"></script>
    <script src="../JS/rooms.js"></script>
		
	<div id="banner">
	
        <img src="../../images/una.png" id="logo" onclick="window.location.href = '../../'">
        <button onclick="dropdownRes();"id="myResButton">My Reservations</button>
		<button id="settingsButton" onclick="window.location.href = 'roomSettings.php'">Settings</button> 
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
		<td><br><button class = "settingsButton">User Settings</button></td>
	  </tr>
	  <tr>
		<td><br><button class = "settingsButton">Room Settings</button></td>
		<br>
	  </tr>
	</table>
	</div>

	<div id = "room"><h2> Room Settings: </h2><br>
	<form>
		<p><b>Search Room:</b></p><br> <br>
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

