<?php
	session_start();

if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page
if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}
	
	$room = $_REQUEST["q"];
	require "db_conf.php";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$room = $conn->real_escape_string($room);
	$sql = "SELECT * FROM rooms WHERE roomid LIKE '$room%'";
	$result = $conn->query($sql);
	
	if ($result->num_rows === 1){
		$row = $result->fetch_assoc();
		$room = $row['roomid'];
		//added to create space from room settings search bar
		// ADD THIS AND STYLE TO YOUR LIKING 
		echo "<form action='updateRoom.php' METHOD='POST'>";
		echo "<table>";
		echo "<tr><th></th><th></th><th></th></tr>";
		echo "<tr><td>Current Room: </td><td>" . $row['roomid'] . "</td></tr>";
		echo "<input type='text' value='" . $row['roomid'] . "' name='currRoom' hidden>";
		echo "<tr><td> New room number: </td><td><input type='text' value='" . $row['roomid'] . "'name='roomNumber'></td></tr>";
		echo "<tr><td><font id='typeText'>Type: </font> 
			</td><td><select name='type'>";
		if ($row['type'] == "Classroom"){
			echo "<option value='Classroom' selected='selected' >Classroom</option>
				<option value='Conference'>Conference Room</option>
				<option value='Computer Lab'>Computer Lab</option>
				</select></td></tr>";
		} else if ($row['type'] == "Computer Lab"){
			echo "<option value='Classroom' >Classroom</option>
				<option value='Conference'>Conference Room</option>
				<option value='Computer Lab' selected='selected'>Computer Lab</option>
				</select></td></tr>";
		} else {
			echo "<option value='Classroom' >Classroom</option>
				<option value='Conference' selected='selected'>Conference Room</option>
				<option value='Computer Lab'>Computer Lab</option>
				</select></td></tr>";
		}
		echo "<tr><td> New floor number: </td><td><input type='text' value='" . $row['floor'] . "'name='floor'></td></tr>";
		echo "<tr><td> Seats: </td><td><input type='text' value='" . $row['seats'] . "'name='seats'></td></tr>";
		echo "<tr><td> <input type='submit' value='Save changes'></form></td></tr></table>";
		// ADD THIS FOR STYLING 
		
		$sql = "SELECT * FROM reservations WHERE startdate >= CURDATE() AND roomnumber='$room' order by startdate, starttime";
        $result = $conn->query($sql);
		echo "<h1> <br> Current Bookings <br></h1>";

		if ($result->num_rows < 1){
			echo "There are no current bookings for this room";
		}
	    else{
			echo "<table><tr><th>Reserving Email</th><th>Owner Email</th><th>Room Number</th><th>Sharing Allowed</th><th>Head Count</th>
				<th>Start Date</th><th>End Date</th><th>Start Time</th><th>End Time</th><th>Occurrence</th></tr>";
		
			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>" . $row['res_email'] . "</td><td>" . $row['owneremail'] . "</td><td>" 
					. $row['roomnumber'] . "</td><td>" . $row['allowshare'] . "</td><td>" . $row['headcount'] . "</td><td>"
					. $row['startdate'] . "</td><td>" . $row['enddate'] . "</td><td>" . $row['starttime'] . "</td><td>"
					. $row['endtime'] . "</td><td>" . $row['occur'] . "</td>";
			}

		}
	}
	else if ($result->num_rows > 1) 
	{
		echo "<br>Continue entering room name or click below to add this room.";
		echo "<form action='addRoom.php' method='POST'>";
		echo "<input type='text' value='$room' name='roomid' hidden>";
		echo "<input type='submit' value='Add Room'>";
	}
	else {
		echo "<br>Error: No room matching current name. Click below to add a room with this name.";
		echo "<form action='addRoom.php' method='POST'>";
		echo "<input type='text' value='$room' name='roomid' hidden>";
		echo "<input type='submit' value='Add Room'>";
	}
	$conn->close();
	
?>