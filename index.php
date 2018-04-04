<?php
session_start();
/*
if (!isset($_SESSION['username'])){
header('location: login.html');
}*/
?>

<html>
    <head><link rel="stylesheet" href="styles/rooms.css">
        <link rel="stylesheet" href="styles/Reservation.css">
        <!-- Add? <link rel="stylesheet" href="styles/links.css"> <!--Taylor-->
        <link rel="stylesheet" href="styles/popup.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		
        <title></title>

    </head>
    <body>
		<div id="shader" onclick="shaderClicked()"></div>
	
        <?php include 'modal.php'; ?>
        <script src="scripts/JS/popup.js"></script>
        <script src="scripts/JS/rooms.js"></script>
        <div id="banner">

            <img src="images/una.png" id="logo" onclick="window.location.href = ''">
            <button onclick="dropdownRes();"id="myResButton">My Reservations</button>
			<button id="settingsButton" onclick="window.location.href += 'scripts/PHP/roomSettings.php'">Settings</button> 

			
			<div class = "welcome">
                <!--Adrianne-->
                <?php
                if (isset($_SESSION['username'])) {
					echo "<p id='welcomeText'>Welcome, " . $_SESSION['username'] ."</p><br>";
					$logged_in_user = $_SESSION['username']; //used for default in reserving email field.
                }
                ?>

                <!--Taylor-->


                <button onclick="logoutUser();" class="signOut" >Logout</button>

            </div>
        </div>

        <div style="position:absolute" id="agendaReservations"></div>

        <div id="deleteRes"></div>

        <div class="makeReservation" id="createZone">

            <form class="test" onsubmit='openConfirmCreate(); return false;'>

                <h1>Make Reservation</h1>

                Reserving For*:
					<?php 
						if (isset($_SESSION['username'])) {
							echo "<input type='text' id='owneremail' value='$logged_in_user' required><br>";
						}
					?>
                <!--<div id="filterArea"> -->
                <!--<font id="typeText">-->
                <br>Type: <!--</font> -->
					<select id="typeSelect" onchange="fieldChanged()">
						<option value="Any">Any</option>
						<option value="Classroom">Classroom</option>
						<option value="Conference">Conference Room</option>
						<option value="Computer Lab">Computer Lab</option>
					</select>
                <!--</div> -->

                <p>Duration*:</p>
					Date:
					<input id = 'date' name = 'date' type = 'date' onchange = "fieldChanged()" value=<?php echo date('Y-m-d'); ?>><br><br>
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

				<input type="checkbox" onclick="changeSheet(); fieldChanged();" id="allowshare">Allow room sharing<br><br>

				<span id="numseatstext" style="visibility:hidden"> Expected number of seats needed: <input type="text" id="numberOfSeats" style="width: 48px;" onchange = "fieldChanged()"></span> <br><br>

                Comments:<br>
					<textarea rows="10" cols="50" id="comment"></textarea><br>
                <br><br>
				<input type="submit" value="Make Reservation">
                <!-- <button onclick="openConfirmCreate()">Make reservation</button><br><br> -->
				<br>
                <font id="responseText"></font>
            </form>

        </div>

        <div class="outerBookArea" id="roomContainer"> 
			<span id="favsheader"></span>	
			<div id="favsbookArea"></div>
			<span id="allroomsheader"></span>	
			<div id="bookArea"></div>
        </div>		

    </body>
</html>