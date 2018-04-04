
<?php 
	$user = $_REQUEST['q'];
	require "db_conf.php";
	$conn = new mysqli($servername, $username, $password, $dbname);
	echo "<form action='updatePermissions.php' method='POST'>";
	echo "Current user: $user </br>";
	echo "Group:<input type='text' name='permissions'></br>";
	echo "<input type='hidden' name='currUser' value='$user'></br>";
	echo "<input type='submit' name='submit'>";
	echo "</form>";
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM reservations WHERE startdate >= CURDATE() AND res_email='$user' order by startdate, starttime";
    $result = $conn->query($sql);
	echo "<h1> <br> Current Bookings <br></h1>";

	if ($result->num_rows < 1){
		echo "There are no current bookings for this room";
	} else{
		echo "<table><tr><th>Reserving Email</th><th>Owner Email</th><th>Room Number</th><th>Sharing Allowed</th><th>Head Count</th>
			<th>Start Date</th><th>End Date</th><th>Start Time</th><th>End Time</th><th>Occurrance</th></tr>";
		
		while ($row = $result->fetch_assoc()) {
			echo "<tr><td>" . $row['res_email'] . "</td><td>" . $row['owneremail'] . "</td><td>" 
				. $row['roomnumber'] . "</td><td>" . $row['allowshare'] . "</td><td>" . $row['headcount'] . "</td><td>"
				. $row['startdate'] . "</td><td>" . $row['enddate'] . "</td><td>" . $row['starttime'] . "</td><td>"
				. $row['endtime'] . "</td><td>" . $row['occur'] . "</td>";
		}

	}
	$conn->close();
	
?>