<?php
	$room = $_REQUEST["q"];
	require "db_conf.php";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT * FROM rooms WHERE roomid LIKE '$room%'";
	$result = $conn->query($sql);
	
	if ($result->num_rows === 1){
		$row = $result->fetch_assoc();
		$room = $row['roomid'];
		echo "<form action='updateRoom.php' METHOD='POST'>";
		echo "<br> Current Room: " . $row['roomid'];
		echo "<input type='text' value='" . $row['roomid'] . "' name='currRoom' hidden>";
		echo "<br> New room number: <input type='text' value='" . $row['roomid'] . "'name='roomNumber'>";
		echo "<br><font id='typeText'>Type:  </font> 
			<select name='type' placeholder='" . $row['type'] . "'>
				<option value='Any'>Any</option>
				<option value='Classroom'>Classroom</option>
				<option value='Conference'>Conference Room</option>
				<option value='Computer Lab'>Computer Lab</option>
			</select>";
		echo "<br> New floor number: <input type='text' value='" . $row['floor'] . "'name='floor'>";
		echo "<br> Seats: <input type='text' value='" . $row['seats'] . "'name='seats'>";
		echo "<br> Number of computers: <input type='text' value='" . $row['numcomputers'] . "' name='numcomputers'>";
		echo "<br> <input type='submit' value='Save changes'></form>";
		
		$sql = "SELECT * FROM reservations WHERE startdate >= CURDATE() AND roomnumber='$room' order by startdate, starttime";
        $result = $conn->query($sql);
		echo "<h1> <br> Current Bookings <br></h1>";

		if ($result->num_rows < 1){
			echo "There are no current bookings for this room";
		}
	    else{
			echo "<table><tr><th>Reserving Email</th><th>Owner Email</th><th>Room Number</th><th>Sharing Allowed</th><th>Head Count</th>
				<th>Start Date</th><th>End Date</th><th>Start Time</th><th>End Time</th><th>Occurrance</th></tr>";
		
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
		echo "<br>Continue entering room name.";
	}
	else {
		echo "<br>Error: No room matching current name.";
	}
	$conn->close();
	
?>