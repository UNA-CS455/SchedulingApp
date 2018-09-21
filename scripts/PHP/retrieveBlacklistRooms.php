<?php session_start();
if(isset($_SESSION['username'])){
	$user= $_SESSION['username'];
}
	/*=========================================================================
		Retrieve Blacklist Page Rooms PHP Script
		Purpose: Gets all rooms, marking those that have been blacklisted for the
		given groupid (obtained below via GET).

		Author: Derek Brown
		Date: 4/27/2018


	=========================================================================*/

	//////////////////////////////////////////////////////////////////////////
	// GET GET VARIABLES

	$groupid = (isset($_GET['groupID'])) ? ($_GET['groupID']) : null;


	
	//VALIDATION
	//////////////////////////////////////////////////////////////////////////

	if ($groupid != null){
		$groupid = filter_var($groupid, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,3}$/")));
	}
	if($groupid == null|| $groupid == false){
		echo "<h4> Select a group to edit its properties. </h4>";
		exit;
	}



	//obtain datbase metadata
    require "db_conf.php";

	//perform conneciton to database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	$sql = "SELECT DISTINCT rooms.roomid, rooms.seats, rooms.numeric_id, rooms.type FROM rooms "; // the final table columns that we want.				// construction of the full query along with ordering
	//echo $sql; // used for testing purposes 
	
    $result = $conn->query($sql); // run the query

	//get all rooms first
	$room_array = array();
	while ($rowItem = $result->fetch_assoc()) {

		$rowResult = array(
			"roomid" => $rowItem['roomid'],
			"seats" => $rowItem['seats'],
			"type" => $rowItem['type'],
			"numeric_id" => $rowItem['numeric_id']
		);
		$room_array[] = $rowResult; // append row to result.
	}


	///////////////////////////////////////////////////////////////////////////
	// Generate Blacklist
	///////////////////////////////////////////////////////////////////////////
	
	//$permissions_SQL = "SELECT rooms.roomid, rooms.seats FROM `rooms` LEFT JOIN `users` ON users.permissions = rooms.blacklist WHERE users.email = '$user'";
	$permissions_SQL = "SELECT rooms.roomid, rooms.seats, rooms.numeric_id FROM `blacklist` LEFT JOIN `rooms` ON blacklist.numeric_room_id = rooms.numeric_id WHERE blacklist.group_id = '$groupid'";
	//echo $permissions_SQL;
	$permissionsRes = $conn->query($permissions_SQL);
	//place in array
	$room_BlacklistArray = array();
	while ($blacklistRowItem = $permissionsRes->fetch_assoc()) {
		$room_BlacklistArray[] = $blacklistRowItem['roomid']; // append row to result.
	}

	
	///////////////////////////////////////////////////////////////////////////
	// Generate all rooms area
	///////////////////////////////////////////////////////////////////////////

	echo "<div id='bookAreaBlacklist' class='bookAreaFrame'>";
	
	foreach ($room_array as $row) 
	{
		if(in_array($row['roomid'],$room_BlacklistArray)){ // blacklist rooms are excluded
			
			echo "<div onclick='updateBlacklist($groupid,".$row['numeric_id'].",false)' class = 'blacklistedroombox' id = '".$row['numeric_id']."'><font class='roomboxcontent' id = 'p_".$row['roomid']."' ><br><b>" . $row['roomid'] ."</b><br>". $row['seats'] ."<br>" . $row['type'] . "</font></div>";
		} else{
			echo "<div onclick='updateBlacklist($groupid,".$row['numeric_id'].",true)' class = 'nonblacklistroombox' id = '".$row['numeric_id']."'><font class='roomboxcontent' id = 'p_".$row['roomid']."' ><br><b>" . $row['roomid'] ."</b><br>". $row['seats'] ."<br>" . $row['type'] . "</font></div>";
		}
	}
	if($result->num_rows == 0){
		echo "<h4> Select a group to edit its properties. </h4>";
	}
	
	echo "</div>";
	
$conn->close();

?>
