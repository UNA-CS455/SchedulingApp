
<?php 
	$user = $_REQUEST['q'];
	require "db_conf.php";

	echo "<form action='updatePermissions.php' method='POST'>";
	echo "<table><tr><th></th><th></th></tr>";
	echo "<tr><td>Current user:</td><td> $user </td></tr>";
	echo "<tr><td>Group: </td>";
	require_once('retrieveGroups_listview.php');
	echo "<input type='hidden' name='currUser' value='$user'></br>";
	echo "<tr><td><input type='submit' value='Save Changes'></td></tr>";
	echo "</form>";
	echo "</table>";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM reservations WHERE startdate >= CURDATE() AND res_email='$user' order by startdate, starttime";
    $result = $conn->query($sql);
	echo "<h1> <br> Current Bookings <br></h1>";

	if ($result->num_rows < 1){
		echo "There are no current bookings for this user";
	} else{
		echo "<table><tr><th>Reserving Email</th><th>Owner Email</th><th>Room Number</th><th>Sharing Allowed</th><th>Head Count</th>
			<th>Start Date</th><th>End Date</th><th>Start Time</th><th>End Time</th><th>Occurrence</th></tr>";
		
		while ($row = $result->fetch_assoc()) {
			echo "<tr><td>" . $row['res_email'] . "</td><td>" . $row['owneremail'] . "</td><td>" 
				. $row['roomnumber'] . "</td><td>" . $row['allowshare'] . "</td><td>" . $row['headcount'] . "</td><td>"
				. $row['startdate'] . "</td><td>" . $row['enddate'] . "</td><td>" . $row['starttime'] . "</td><td>"
				. $row['endtime'] . "</td><td>" . $row['occur'] . "</td>";
			echo "<td><form action=room_remove_user.php METHOD='POST'>";
			echo "<input type='text' value='" . $row['id'] . "' name='id' hidden>";
			echo "<input type='submit' value='Delete'>";
			echo "</form></td></tr>";
		}

	}
	$conn->close();
	
?>