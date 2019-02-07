<?php
session_start ();

if (! isset ( $_SESSION ['username'] ))
{
	header ( 'location: ../../login.html' );
}
// only admin can view this page
if ($_SESSION ['permission'] != 1)
{
	header ( 'location: ../../login.html' );
}

require "db_conf.php";
$conn = new mysqli ( $servername, $username, $password, $dbname );
if ($conn->connect_error)
{
	die ( "Connection failed: " . $conn->connect_error );
}

// ////////////////////////////////////////////////////////////////////////////////////
// /////////SELECT PASSED THROUGH ROOM
// ////////////////////////////////////////////////////////////////////////////////////

if (isset ( $_GET ['roomid'] ))
{
	$beingEdited = true;
	$gotRoom = $_GET ['roomid'];
	$_editRoomSql = "SELECT * FROM `rooms` WHERE `rooms`.`roomid` = '$gotRoom'";

	$_editRoomRes = $conn->query ( $_editRoomSql );

	$roomToEdit = $_editRoomRes->fetch_assoc ();
} else
{
	// echo "being edited";
	$roomToEdit = null;
	$beingEdited = false;
}

if (isset ( $_POST ['submit'] ))
{
	
	$roomid = $_POST ['roomid'];
	$type = $_POST ['type'];
	$floor = $_POST ['floor'];
	$seats = ( int ) $_POST ['seats'];
// 	$hasComputers = $_POST ['hascomputers'];
	$numComputers = ( int ) $_POST ['numcomputers'];
	if ($_POST ['hascomputers'] == "on")
	{
		// echo "made it into the if statement";
		$hasComputers = 1;
		$numComputers = ( int ) $_POST ['numcomputers'];
// 		header('Location: userSettings.php');
	} 
	else if($_POST['hascomputers'] == "off")
	{
		// echo "else statement";
		// var_dump($_POST);
		$hasComputers = 0;
		$numComputers = 0;
		
// 		header('Location: userSettings.php');
	}

// 	var_dump ( $_POST );

	if ($beingEdited)
	{
		echo "editing now";
		$_updateSql = "UPDATE `rooms` SET `rooms`.`type` = '$type', `rooms`.`floor` = '$floor', `rooms`.`seats` = '$seats', `rooms`.`hascomputers` = '$hasComputers', `rooms`.`numcomputers` = '$numComputers' WHERE `rooms`.`roomid` = '$roomid'";

		$conn->query ( $_updateSql );
		header ( "Location: userSettings.php" );
    var_dump($_updateSql);
	} else
	{
		$_createSql = "INSERT INTO `rooms` (`roomid`, `type`, `floor`, `seats`, `hascomputers`, `numcomputers`) VALUES ('$roomid', '$type', '$floor', '$seats', '$hasComputers', '$numComputers')";
		$conn->query ( $_createSql );
		header ( "Location: userSettings.php" );
	}
}

?>
<!DOCTYPE html>
<html class="gr__localhost">

<head>
<script type="text/javascript"
	src="chrome-extension://aadgmnobpdmgmigaicncghmmoeflnamj/ng-inspector.js"></script>
</head>

<body onload="populateBlacklistRooms(null); populateGroupList();"
	data-gr-c-s-loaded="true">
	<div id="shader" onclick="shaderClicked()"></div>
	<!-- Jquery -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<!-- Local scripts -->
	<script src="../JS/popup.js"></script>
	<script src="../JS/rooms.js"></script>
	<script src="../JS/settingsDisplay.js"></script>
	<!-- Include FontAwesome -->
	<link rel="stylesheet"
		href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
		integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt"
		crossorigin="anonymous">
	<!-- Include Bootstrap -->
	<link rel="stylesheet"
		href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script
		src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<!-- Jquery -->
	<script type="text/javascript"
		src="http://code.jquery.com/jquery-latest.min.js"></script>
	<!-- Stylesheets -->
	<link rel="stylesheet" href="../../styles/rooms.css">
	<link rel="stylesheet" href="../../styles/Reservation.css">
	<link rel="stylesheet" href="../../styles/calendar.css">
	<!-- Add? <link rel="stylesheet" href="styles/links.css"> <!--Taylor-->
	<link rel="stylesheet" href="../../styles/popup.css">
	<title>Edit user</title>
	<div class="jumbotron-fluid">
		<img src="../../images/una.png" id="logo" onclick="window.location.href = ''">
	</div>
	<nav class="navbar navbar-default" style="margin-bottom: 0px;">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#"></a>
				<!-- Adrianne -->
				<p id="welcomeText">Welcome, super@una.edu</p>
				<br>
			</div>
			<button class="btn btn-default navbar-btn" id="makeResButton"
				onclick="window.location.href = '../../'; showCreateResForm();">Make
				Reservation</button>
			<button class="btn btn-default navbar-btn" id="monthViewButton"
				onclick="window.location.href = '../../#calView'; showCalendarView();">Month
				View</button>
			<button class="btn btn-default navbar-btn" onclick="dropdownRes();"
				id="monthViewButton">My Reservations</button>
			<button class="btn btn-default navbar-btn" id="settingsButton"
				onclick="window.location.href = 'userSettings.php'">Settings</button>
			<!--Taylor-->
			<button onclick="logoutUser();"
				class="signOut btn btn-default navbar-btn pull-right">Logout</button>
		</div>
	</nav>
	<div class="container">
		<br />
		<h1><?php (($beingEdited == true) ? print "Edit Room" : print "Create Room") ?></h1>
		<br />
		<div class="row">
			<form name="roomForm" method="POST" action="">
				<div class="row">
					<div class="col-md-3 form-group">
						<label for="roomid"> Building and room number </label>
						<input type="text" name="roomid" class="form-control"
							placeholder="Ex. Keller 122"
							<?php echo($roomToEdit['roomid']) ? ' value="'.$roomToEdit['roomid'].'" readonly="readonly" ' : "" ?>>
					</div>
					<div class="col-md-3 form-group">
						<label for="type"> Room Type </label>
						<select class="form-control" id="type" name="type">
							<option value="">Select One</option>
							<option value="Classroom"
								<?php echo ($roomToEdit['type'] == 'Classroom' ? "selected" : "") ?>>Classroom</option>
							<option value="Computer Lab"
								<?php echo ($roomToEdit['type'] == 'Computer Lab' ? "selected" : "") ?>>Computer
								Lab</option>
							<option value="Conference Room"
								<?php echo ($roomToEdit['type'] == 'Conference Room' ? "selected" : "") ?>>Conference
								Room</option>
						</select>
					</div>
					<div class="col-md-1 form-group">
						<label for="floor">Floor</label>
						<input type="text" name="floor" class="form-control"
							<?php echo($roomToEdit['floor']) ? 'value=" '.$roomToEdit['floor'].' "' : '' ?>>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-md-1 form-group">
						<label for="seats">Seats</label>
						<input type="text" name="seats" class="form-control"
							<?php echo($roomToEdit['seats']) ? 'value=" '.$roomToEdit['seats'].' "' : '' ?>>
					</div>
					<div class="col-md-2 form-check"
						style="position: relative; top: .5vh; left: 5vh;">
						<!-- hidden field for if checkbox is not checked -->
						<input type="hidden" name="hascomputers" value="off">
						<input class="form-check-input" name="hascomputers" id="hasComputersCheck" type="checkbox" <?php echo($roomToEdit['hascomputers'] == 1) ? 'checked value="1"' : '' ?>>
							<!-- For the php in the previous line, the 'checked value' part is part of the form itself.
								 The script itself is simply asking if the room is set to have computers in the database, then
								 make the box checked by default. Else, do nothing (have it not checked) -->
						<label for="hasComputers">Has Computers</label>
					</div>
					<div class="col-md-2 form-group">
						<label for="numComputers">Number of Computers</label>
						<input type="text" id="numComputers" name="numcomputers"
							class="form-control" readonly
							<?php echo($roomToEdit['hascomputers'] == 1) ? (($roomToEdit['numcomputers']) ? 'value=" '.$roomToEdit['numcomputers'].' "' : 'value="0"') : '' ?>>
					</div>
				</div>
				<div class="row">
					<div class="col-md-1">
						<br />
						<button class="btn btn-secondary" id="submit" name="submit" type="submit"><?php (($beingEdited == true) ? print "Edit Room" : print "Create Room") ?></button>
					</div>
                    <div class="col-md-2 form-check"
						style="position: relative; top: .5vh; left: 5vh;">
						<input type="hidden" name="limit" value="off">
						<input class="form-check-input" name="limit" id="limitCheck" type="checkbox">
						<label for="limit">Limit Reservations</label>
					</div>
					<!-- I'm thinking we use a responsive table for the whitelisted users.
						 Maybe we can set an arbitrary maximum amount of users for it, as I don't see a way to increase
						 the table dynamically as of right now (1/28). -->
					<!--
						Issues:
							Responsive table not halting at a set number of items
					-->
					<b>Email</b>
					<div class="col-md-2" style="overflow-y:auto; max-height: 96px;">
						<table>
						    <tr>
						      <td>user@una.edu</td>
						    </tr>
						    <tr>
						    	<td>bcornelius@una.edu</td>
						    </tr>
						    <tr>
						      <td>tnelson3@una.edu</td>
						    </tr>
						    <tr>
						      <td>fjager@una.edu</td>
						    </tr>
						    <tr>
						      <td>dhayter@una.edu</td>
						    </tr>
						    <tr>
						      <td>otacon3@una.edu</td>
						    </tr>
						    <tr>
						      <td>ssnake@una.edu</td>
						    </tr>
						    <tr>
						      <td>rocelot@una.edu</td>
						    </tr>
						    <tr>
						      <td>bboss@una.edu</td>
						    </tr>
						    <tr>
						      <td>thepain@una.edu</td>
						    </tr>
						    <tr>
						      <td>thefear@una.edu</td>
						    </tr>
						    <tr>
						      <td>thesorrow@una.edu</td>
						    </tr>
						    <tr>
						      <td>theboss@una.edu</td>
						    </tr>
						    <tr>
						      <td>nsnake@una.edu</td>
						    </tr>
						  </table>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>

</html>

<script>

	$('#hasComputersCheck').change(function()
	{
		if(this.checked)
		{
			$('#numComputers').removeAttr('readonly');
		}
		else
		{
			$('#numComputers').prop('readonly', true);
			$('#numComputers').val(null);
		}
	})
</script>
