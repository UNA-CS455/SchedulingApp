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
<script>
/*
Email search function
Performs AJAX to retrieve_emails.php that will perform a lookup from the database of emails
and return suggested emails as the user types.
*/
function search(partial) 
{
	var parser = new DOMParser();

    if (partial == null || partial.length == 0) { 
		//clear existing dropdown text if no text is entered
        document.getElementById("userInfo").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
		
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

				// accountArray - the suggestions that come from the retrive_emails.php call.
				var accountArray = JSON.parse(this.responseText);
				var runString = "";
				
				//construct the dropdown contents
				for(var i = 0; i < accountArray.length; i++){
					runString+= "<p id = 'account_" + i + "'onclick=setEmail(\'" + accountArray[i].email + "\')>" + accountArray[i].lastname + ", " + accountArray[i].firstname + "<br>" + accountArray[i].email+ " "+ accountArray[i].role +"</p>";
				}
				console.error(runString);
                document.getElementById("userInfo").innerHTML = runString; 
				// only toggle show when it is not showing and when the number of values returned from the database query is greater than 0
				if(accountArray.length > 0 && !document.getElementById("userInfo").classList.contains('show'))
				{
					document.getElementById("userInfo").classList.toggle("show");
				}
            }
        };
		
        xmlhttp.open("GET", "search.php?q=" + partial, true);
        xmlhttp.send();
		
    } 
}

/*
Do stuff with what the user clicked in the dropdown
*/
function setEmail(str){
	document.getElementById("userInfo").classList.toggle("show");
	if (str.length == 0) {
        document.getElementById("userData").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("userData").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "updateUser.php?q=" + str, true);
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
		<button id="makeResButton" onclick="window.location.href = '../../'; showCreateResForm();">Make Reservation</button>
		<button id="monthViewButton" onclick="window.location.href = '../../#calView'; showCalendarView();">Month View</button>
        <button onclick="dropdownRes();"id="myResButton">My Reservations</button>
		<button id="settingsButton" onclick="window.location.href = 'userSettings.php'">Settings</button> 
		<button onclick="logoutUser();" class="signOut" >Logout</button>
			
		<div class = "welcome">
            <!--Adrianne-->
                <?php
                if (isset($_SESSION['username'])) {
                echo "<p id='welcomeText'>Welcome, " . $_SESSION['username'] ."</p><br>";
                $logged_in_user = $_SESSION['username']; //used for default in reserving email field.
                }
                ?>

                <!--Taylor-->


                <!-- <button onclick="logoutUser();" class="signOut" >Logout</button> -->

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
	<div id = "room"><h1>User Settings</h1>
		<br>
		<div class="dropdown">
			<form> 
			Email: <input id="emailInput" type="text" onkeyup="search(this.value)"> 
			</form>
			<div id="userInfo" class="dropdown-content"></div>
			<div id="userData"></div>
			<?php
				if(isset($_SESSION['msg'])){
					echo "<br>";
					echo $_SESSION['msg'];
					unset($_SESSION['msg']);
				
				}
			?>
		</div>
	</div>
</body>
</html>