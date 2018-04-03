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
<title>Settings</title>
</head>
<body>
	<div id="banner">

        <img src="images/una.png" id="logo" onclick="window.location.href = 'index.php'">
        <button onclick="dropdownRes();"id="myResButton">My Reservations</button>
		<button id="settingsButton" onclick="window.location.href = '/scripts/PHP/userSettings.php'">Settings</button> 
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
	<h1>User Settings:</h1>
	<br>
	<h3>Find Users by Email:</h3>
	<form action="/scripts/PHP/search.php" METHOD="POST">
		<input type="text" name="userid">
		<input type="submit" value="Search">
	</form>
	<br>
	<h3>Add Users by Email</h3>
	<form action="/scripts/PHP/addUser.php" METHOD="POST">
		<input type="text" name="userid">
		<input type="submit" value="Submit">
	</form>
	<br>
	<h3>Find Reservations by email</h3>
	<form action="/scripts/PHP/res_settings.php" METHOD="POST">
		<br>email:
		<input type="text" name="res_email">
		<input type="submit" value="search">
	</form>
	<h3>Currently Selected Reservations</h2>
	<table>
		<tr>
			<th>Room</th>
			<th>From</th>
			<th>To</th>
			<th>Details</th>
		</tr>
		
	</table>
</body>
</html>