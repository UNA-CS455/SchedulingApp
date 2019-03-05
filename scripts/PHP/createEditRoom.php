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
	
	$getAllowedUsers = "SELECT * FROM `whitelist` WHERE `whitelist`.`roomid` = '$gotRoom'";
	$allowedUsersRes = $conn->query($getAllowedUsers);
	
} else
{
	$roomToEdit = null;
	$beingEdited = false;
}

if (isset ( $_POST ['submit'] ))
{
	
	$roomid = $_POST ['roomid'];
	$type = $_POST ['type'];
	$floor = $_POST ['floor'];
	$seats = ( int ) $_POST ['seats'];
	$numComputers = ( int ) $_POST ['numcomputers'];
	$limit = $_POST['limit'];

	saveChanges($conn, $beingEdited, $_POST);
	header("Location: userSettings.php");
	
}
// Here is where we need to make our call to the "Who can reserve" boxes. We will check if the button is pressed, then update accordingly.
// We also can go ahead and call our other SQL call to get the list of allowed users

// if(isset($_POST['addUser'])){
// 	// We need to set the limit check to whatever "on" is here as well. That way we don't have to have them check the box, then hit "save changes"
// 		// and then add the user. We can do it in one fell swoop.
		
// 	if($_POST['limit'] != "off"){
// 		// insert new user to list
// 		$email = $_POST['allowedUser'];
// 		$roomid = $_POST['roomid'];
		
// 		// Here is where the modal box needs to confirm the user wants to add the person
		
// 		$_allowedSql = "INSERT INTO `whitelist` (`email`, `roomid`) VALUES ('$email', '$roomid')";
// 		$conn->query ( $_allowedSql );
		
// 		if(isset($conn->error)){
// 			// display error
// 			$sqlError = $conn->error;
// 		}
		
// 		saveChanges($conn, $beingEdited, $_POST);
// 		header("Refresh: 0");
// 	}
// }

function insertUserWhitelist(){
	$email = $_POST['allowedUser'];
	$roomid = $_POST['roomid'];

	$_allowedSql = "INSERT INTO `whitelist` (`email`, `roomid`) VALUES ('$email', '$roomid')";
	$conn->query ( $_allowedSql ) or die($conn->error);
		
	if(isset($conn->error)){
		// display error
		$sqlError = $conn->error;
	}
}



// if(isset($_POST['ourDeleteUserButton'])){
	
// 	$sql = "DELETE 'user' FROM `whitelist` WHERE 'email' = '$email' AND 'room' = '$roomid'";
	
// }


// Performs the actions associated with the save changes button.

function saveChanges($conn, $beingEdited, $post_vars){
	$roomid = $post_vars ['roomid'];
	$type = $post_vars ['type'];
	$floor = $post_vars ['floor'];
	$seats = ( int ) $post_vars ['seats'];
	$numComputers = ( int ) $post_vars ['numcomputers'];
	$limit = $post_vars['limit'];
	
	if($numComputers <= 0){
		$hasComputers = 0;
	}
	else{
		$hasComputers = 1;
	}
	
	
	if($limit == "off")
	{
		// If the checkbox "Limit Reservations" has been checked, set the flag to 1 (true)
		$areLimiting = 0;
	}
	else
	{
		// If the checkbox is unchecked, set the flag to 0
		$areLimiting = 1;
	}


	if ($beingEdited)
	{
		$_updateSql = "UPDATE `rooms` SET `rooms`.`type` = '$type', `rooms`.`floor` = '$floor', `rooms`.`seats` = '$seats', `rooms`.`hascomputers` = '$hasComputers',
			`rooms`.`numcomputers` = '$numComputers', `rooms`.`limit` = '$areLimiting' WHERE `rooms`.`roomid` = '$roomid'";

		$conn->query ( $_updateSql );
	} else
	{
		$_createSql = "INSERT INTO `rooms` (`roomid`, `type`, `floor`, `seats`, `hascomputers`, `numcomputers`) VALUES ('$roomid', '$type', '$floor', '$seats', '$hasComputers', '$numComputers')";
		$conn->query ( $_createSql );
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
	
	<?php include '../../modal.php'; ?>
	<script src="../JS/popup.js"></script>
	<link rel="stylesheet" href="../../styles/popup.css">
	
	<div id="shader" onclick="shaderClicked()"></div>
	<!-- Jquery -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<!-- Local scripts -->
	<script src="../JS/popup.js"></script>
	<script src="../JS/rooms.js"></script>
	<script src="../JS/limitUsers.js"></script>
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
						<label for="hasComputers">Has Computers</label>

						<div class="row-xs-0 form-group" id="computerBlock" style="min-width: 190px; <?php echo ($roomToEdit['hascomputers'] == 1) ? "display: run-in" : "display: none"?>">
	                    	<b>Number of Computers</b>
	                    	<div class="row-md-2" style="max-width: 175px">
								<input type="text" id="numComputers" name="numcomputers" class="form-control" <?php echo($roomToEdit['numcomputers']) ? 'value=" '.$roomToEdit['numcomputers'].' "' : '' ?>>
							</div>
						</div>
						
					</div>
					
					<div class="col-md-2 form-check"
						style="position: relative; top: .5vh; left: 5vh;">
						<input type="hidden" name="limit" value="off">
						<input class="form-check-input" name="limit" id="limitCheck" type="checkbox" <?php echo($roomToEdit['limit'] == 1) ? 'checked value="1"' : '' ?>>
						<label for="limit">Limit Reservations</label>
						<div class="row-md-1" id="email"  style="max-width: 175px; margin-top: 23px; <?php echo ($roomToEdit['limit'] == 1) ? "display: block" : "display: none"?>">
								<input type="text" name="allowedUser" class="form-control">
						</div>
						<div>
							<!--Put delete here-->
							<!--SQL goes up top-->
						</div>
					</div>
					<div class="col-xl-3" >
							<button class="btn btn-secondary" style="margin-top: 55px; margin-left: 50px; <?php echo ($roomToEdit['limit'] == 1) ? "display: run-in" : "display: none"?>" 
								id="addUser" name="addUser" onclick="openConfirmCreateUser('frank')" >Add User</button>
								<!--onclick="openConfirmCreate()"-->
					</div>
					<!--<div button class="btn btn-secondary" style="margin-top: 55px; margin-left: 50px"-->
					<!--			id="deleteUser" name="deleteUser" type="submit">Delete User</button>-->
						
					<!--		buttonhtml = "<button id='ConfirmDeleteUser' class='modal-button btn btn-success' >Delete</button><button class='modal-button btn btn-danger' onclick='closeModal()'>Cancel</button>"-->
					<!--		showMessageBox("Are you sure you want to delete this user?", "Confirm", buttonhtml, false);-->
					<!--		document.getElementById('ConfirmDeleteUser').onclick = function() {-->
					<!--		closeModal();-->
					<!--		createClicked(data);-->
					<!--		};-->
							
							<!--Put delete button here-->
							<!--SQL goes up top-->
							<!--Whenever button gets clicked, so an (onclick) field is needed, call showMessageBox function-->
					<!--</div>-->
				</div>
				
				
				<div class="row">
					<div class="col-md-1" style="visibility: hidden">
						<br />
						<b>Spacer, shouldn't be seen</b>
					</div>
					
                    <div class="col-md-1 form-group" style="min-width: 190px; margin-left: 45px; visibility: hidden">
                    	<b>Spacer, shouldn't be seen</b>
					</div>
					
					<div class="col-lg-1" id="allowedReserve" style="margin: 1px; min-width: 250px; <?php echo ($roomToEdit['limit'] == 1) ? "display: run-in" : "display: none" ?>">
						<b>Allowed Users</b>
						<div class="col-md-2" style="overflow-y:auto; min-height: 96px; min-width: 250px; max-height: 96px; border: 1px solid black">
							<table>
								<?php
									while($allowedUsers = $allowedUsersRes->fetch_assoc()){
										echo "<tr> <td>" . $allowedUsers['email'] . " </td> </tr>";
									}
								?>
							</table>
						</div>
					</div>
					
				</div>
				<div class="row">
					<button class="btn btn-secondary" id="submit" name="submit" type="submit"><?php (($beingEdited == true) ? print "Save Changes" : print "Create Room") ?></button>
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
			$('#computerBlock').show();
		}
		else
		{
			$('#computerBlock').hide();
		}
	})
</script>

<script>
	$('#limitCheck').change(function(){
		if(this.checked){
			//show some boxes, maybe some other stuff?
			$('#allowedReserve').show();
			$('#addUser').show();
			$('#email').show();
		}	
		else{
			//don't show some boxes
			$('#allowedReserve').hide();
			$('#addUser').hide();
			$('#email').hide();
		}
	})
</script>




