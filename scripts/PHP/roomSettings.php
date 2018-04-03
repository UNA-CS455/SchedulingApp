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
 <link rel="stylesheet" href="/styles/settings.css">
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
	<div id="banner">

        <img src="/images/una.png" id="logo" onclick="window.location.href = 'index.php'">
        <button onclick="dropdownRes();"id="myResButton">My Reservations</button>
		<button id="settingsButton" onclick="window.location.href = '/scripts/PHP/roomSettings.php'">Settings</button> 
		<div class = "welcome">
            <!--Adrianne-->
            <?php
            if (isset($_SESSION['username'])) {
				echo "<p id='welcomeText'>Welcome, " . $_SESSION['username'] ."</p><br>";
				$logged_in_user = $_SESSION['username']; //used for default in reserving email field.
            }
            ?>
		<button onclick="logoutUser();" class="welcome" >Logout</button>

            <!--Taylor-->


			<!-- <button onclick="logoutUser();" class="signOut" >Logout</button> -->

        </div>
    </div>
	<div class = "d";
	<table id = "pages">
	  <tr>
		<th>Pages<br></th>
	  </tr>
	  <tr>
		<td><br><button class = "settingsButton">User Settings</button><br></td>
	  </tr>
	  <tr>
		<td><br><button class = "settingsButton">Room Settings</button><br></td>
		<br>
	  </tr>
	</table>
	</div>

	<div id = "room"><h1> Room Settings </h1>
	<form>
		Search Room: <br>
		<input type="text" onkeyup="findRoom(this.value)">
		</form>
		<p>  <span id="roomInfo"></span></p>
		<?php
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
		?>
	</div>
</body>
</html>

