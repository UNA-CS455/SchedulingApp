<?php session_start();
require "ValidateReservation.php";
if(isset($_SESSION['username'])){
	$user= $_SESSION['username'];
}
	/*=========================================================================
		Retrieve Rooms PHP Script
		Purpose: Generates the rooms table that is shown on the primary page.
		constraints are given via GET, and the table generated will provide only
		those rooms who meet those constraints.
		Constraints are:
		1. Start time and end time and date - note that we need both of these to validate
		if a room can be booked or not. The range is checked for each room. If a room
		is taken during that range of time, then the room will note be returned from 
		the query.

		2. Room Type - the type of room as defined in the database. If this constraint
		is specified, then we will query only for those rooms that are defined to be
		that type. For example, if $_GET['roomtype'] == 'Classroom', then only rooms
		with a type of 'classroom' will be shown.

		3. Roomsharing and headcount - if this is roomsharing is true, then we check 
		the headcount field. Computations are performed to ensure that headcount doesn't
		exceed the number of open seats in each room. Only those rooms which have enough
		seats (even with other professors who choose to share and give their headcount)
		will be shown. Note that we will only be posting a headcount. They can only type
		a headcount when allow room sharing is checked, meaning a headcount is what we will
		be waiting for. If we get headcount, we know they selected allow room sharing.

		4. recur - recur is an enumerated type, a check will be performed to ensure 
		the user's preference on recurring reservations doesn't conflict with another
		reservation somewhere down the line in the semester (recall that recurring 
		reservations will be valid for only the length of the semester.

		The variables for these are 'starttime', 'endtime', 'type', 'headcount', 
		'recur'.


		Note that we also check the current group the $_SESSION['username'] is 
		in to ensure they only see rooms they are allowed to book.


	=========================================================================*/

	//////////////////////////////////////////////////////////////////////////
	// GET GET VARIABLES
	$starttime = (isset($_GET['starttime'])) ? $_GET['starttime'] : null; // format as 'H:i' (24-hr format)
	$endtime = (isset($_GET['endtime'])) ? $_GET['endtime'] : null;     // format as 'H:i' (24-hr format)
	$type = (isset($_GET['type'])) ? $_GET['type'] : null;
	$headcount = (isset($_GET['headcount'])) ? $_GET['headcount'] : null;
	$recur_enum = (isset($_GET['recur'])) ? $_GET['recur'] : null;
	$date = (isset($_GET['date'])) ? $_GET['date'] : null; // format as 'Y/d/m'

	
	//VALIDATION
	//////////////////////////////////////////////////////////////////////////

	//echo "starttime is $starttime and endtime is $endtime";
	if ($starttime != null){
		$starttime = filter_var($starttime, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^'[0-9]{1,2}:[0-9]{1,2}'$/")));
		//var_dump($starttime);
		
	}
	
	if ($endtime != null){
		$endtime = filter_var($endtime, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^'[0-9]{1,2}:[0-9]{1,2}'$/")));
		//var_dump($endtime);
	}

	
	if ($type != null){
		if ($type != "Classroom" and $type != "Conference" and $type != "Computer Lab"){
			$type = null;
		}
		//var_dump($type);
	}

	if ($headcount != null){
		$headcount = filter_var($headcount, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}$/")));
	}

	if ($date != null){
		$date = filter_var($date, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^'[0-9]{1,4}-[0-9]{1,2}-[0-9]{1,2}'$/")));

	}
	

	//obtain datbase metadata
    require "db_conf.php";

	//perform conneciton to database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
	

	$sql = "";
	$additional = "";

	//TODO: Future work - see if we can refactor these sql statements to prepared statements for security

	if($starttime != null || $endtime != null || $type != null || $headcount != null || $recur_enum != null){

		//if user provides times
		if($starttime != null && $endtime != null && $date != null){
			//ensure user gives valid time first
			if(!checkDateTime(true, substr($starttime,1,-1), substr($endtime,1,-1))){
				
				exit;
			}

			if($headcount == null){
				$additional = $additional . "LEFT JOIN (SELECT DISTINCT roomid, seats, type FROM rooms RIGHT JOIN reservations ON rooms.roomid = reservations.roomnumber 
					WHERE startdate = $date AND (($starttime >= starttime AND $starttime < endtime) OR ($starttime < starttime AND $endtime > starttime)))
					AS subquery ON rooms.roomid = subquery.roomid WHERE subquery.roomid IS NULL AND ";
			} else {
				// if a headcount has been provided, then sharing is allowed. special conditions must be considered:
				/*
					1. if there exist a collision with another reservation, then we must check if that colliding reservation has its allow sharing bit set to 1.
						if this is true, then we won't consider it a conflict. We must check the headcount of this reservation and any other conflicting reservation
						and sum their headcount field. We then compare this to the room number of seats. If this sum is greater than the number of seats available in a room,
						then the headcount is too large, and the reservation cannot be made for this particular room.
					2. if the allow sharing bit is set to 0, then we know that we must treat that room as unavailable as we did above.
				
				
				*/
				
				$sql = $sql . "SELECT t1.roomid, t1.seats, t1.type FROM (";
				$additional = $additional . "LEFT JOIN (SELECT SUM(reservations.headcount) AS roomSUM, reservations.allowshare, roomid, rooms.seats,
				rooms.type FROM rooms RIGHT JOIN reservations ON rooms.roomid = reservations.roomnumber WHERE allowshare = 0 AND startdate = $date AND 
				(($starttime >= starttime AND $starttime < endtime) OR ($starttime < starttime AND $endtime > starttime))) AS subquery ON rooms.roomid = 
				subquery.roomid WHERE (subquery.roomid IS NULL)) AS t1

				INNER JOIN

				(SELECT DISTINCT rooms.roomid, rooms.seats, rooms.type FROM rooms LEFT JOIN (SELECT SUM(reservations.headcount) AS roomSUM, 
				reservations.allowshare, roomid, rooms.seats, rooms.type FROM rooms RIGHT JOIN reservations ON rooms.roomid = reservations.roomnumber 
				WHERE startdate = $date AND (($starttime >= starttime AND $starttime < endtime) OR ($starttime < starttime AND $endtime > starttime))) AS 
				subquery ON rooms.roomid = subquery.roomid WHERE (subquery.roomid IS NULL) OR ((subquery.roomSUM + $headcount) <= rooms.seats)) AS rooms

				USING(roomid) WHERE $headcount <= rooms.seats AND ";
				
				
			}
		} else {
			
			
			$additional = "WHERE ";
			
			

		}
		
		//user provided type for room
		if($type != null){ 
			$additional = $additional . "rooms.type = '$type' AND ";
		}

		//if user doesn't provide times but wishes to query on headcount:
		if($headcount != null){
			//$additional TODO: add headcount query here
			$additional = $additional . "$headcount <= rooms.seats AND ";
		}


		$additional = $additional . '1'; // we are done appending on clauses. All previous statements before this and with 'AND', so we terminate with '1'.
	}

	$sql = $sql . "SELECT DISTINCT rooms.roomid, rooms.seats, rooms.type FROM rooms "; // the final table columns that we want.
	$sql = $sql . $additional ;					// construction of the full query along with ordering
	//echo $sql; // used for testing purposes 
	
    $result = $conn->query($sql); // run the query

	//get all rooms first
	$room_array = array();
	while ($rowItem = $result->fetch_assoc()) {

		$rowResult = array(
			"roomid" => $rowItem['roomid'],
			"seats" => $rowItem['seats'],
			"type" => $rowItem['type']
		);
		$room_array[] = $rowResult; // append row to result.
	}


	///////////////////////////////////////////////////////////////////////////
	// Generate Blacklist
	///////////////////////////////////////////////////////////////////////////
	
	$permissions_SQL = "SELECT rooms.roomid, rooms.seats FROM `rooms` LEFT JOIN `users` ON users.permissions = rooms.blacklist WHERE users.email = '$user'";
	$permissionsRes = $conn->query($permissions_SQL);
	//place in array
	$room_BlacklistArray = array();
	while ($blacklistRowItem = $permissionsRes->fetch_assoc()) {
		$room_BlacklistArray[] = $blacklistRowItem['roomid']; // append row to result.
	}

	///////////////////////////////////////////////////////////////////////////
	// Generate favorites area
	///////////////////////////////////////////////////////////////////////////
	echo "<span id='favsheader'></span>";
	echo "<div id='favsbookArea' class='favBookArea'>";
	
	$favoritesSQL = "SELECT DISTINCT rooms.roomid,rooms.seats,rooms.type FROM favorites LEFT JOIN rooms on favorites.roomid = rooms.roomid WHERE email='" . $_SESSION['username'] . "' ORDER BY rooms.roomid";
    $favoritesResult = $conn->query($favoritesSQL);
	
	while ($favRow = $favoritesResult->fetch_assoc()) 
	{

		$imgName = "images/fav-select.png";


		$inArray = false;
		foreach ($room_array as $row) 
		{
			if($row['roomid'] == $favRow['roomid'] && !in_array($favRow['roomid'],$room_BlacklistArray)){
				$inArray = true;
				break;
			}
		}
		if($inArray){
			echo "<div onclick='selectRoom(this.id)' class = 'roombox' id = 'fav_".$favRow['roomid']."'><img src='" . $imgName . "' onclick='favoriteClicked(this.parentElement); event.stopPropagation();' class='favoriteIcon'><font class='roomboxcontent' id = 'p_".$favRow['roomid']."' ><br><b>" . $favRow['roomid'] ."</b><br>". $favRow['seats'] ."<br>" . $favRow['type'] . "</font></div>";
		} else {
			// not found in all rooms, so cut favorites
			echo "<div onclick='' class = 'roomboxnotfound' id = 'fav_".$favRow['roomid']."'><img src='" . $imgName . "' onclick='favoriteClicked(this.parentElement); event.stopPropagation();' class='favoriteIcon'><font class='roomboxcontent' style='color:white' id = 'p_".$favRow['roomid']."' ><br><b>" . $favRow['roomid'] ."</b><br>". $favRow['seats'] ."<br>" . $favRow['type'] . "</font></div>";
		}
	}
	/*
	if($result->num_rows == 0){
		echo "<h4> No Results </h4>";
	} */
	echo "</div>";
	
	///////////////////////////////////////////////////////////////////////////
	// Generate all rooms area
	///////////////////////////////////////////////////////////////////////////

	echo "<span id='allroomsheader'></span>";
	echo "<div id='bookArea' class='bookArea'>";
	
	foreach ($room_array as $row) 
	{
		if(!in_array($row['roomid'],$room_BlacklistArray)){ // blacklist rooms are excluded
			$imgName = "images/fav-unselect.png";
			$sql = "SELECT * FROM favorites WHERE roomid='" . $row['roomid'] . "' AND email='" . $_SESSION['username'] . "'";
			$result2 = $conn->query($sql);
			while ($row2 = $result2->fetch_assoc()) {
				// there is a favorite.
				$imgName = "images/fav-select.png"; //color in star if this room is a favorite 
			}

			
			echo "<div onclick='selectRoom(this.id)' class = 'roombox' id = '".$row['roomid']."'><img src='" . $imgName . "' onclick='favoriteClicked(this.parentElement); event.stopPropagation();' class='favoriteIcon'><font class='roomboxcontent' id = 'p_".$row['roomid']."' ><br><b>" . $row['roomid'] ."</b><br>". $row['seats'] ."<br>" . $row['type'] . "</font></div>";
		}
	}
	if($result->num_rows == 0){
		echo "<h4> No Results </h4>";
	}
	
	echo "</div>";
	
$conn->close();


/*
//*************************************************************************************
//This function checks a number of requirements on a new reservation being made.
//If the reservation being made is before or after the start day and end day time
//it returns FALSE and the correct error message to the user. If the reservation 
//made is not on a fifteen minute interval, then it returns FALSE and the correct 
//message is displayed to the user. If the reservation start time occurs after the
//end time then return FALSE and display correct message to the user. If the reser-
//vation being made is good, the correct message is displayed and returnsVal = TRUE.
//************************************************************************************
function checkDateTime($outputError, $startToCheck, $endToCheck)
{
	//msg variables to indicate the problem that occurred 
	$returnVal = FALSE;

	$dayStart = DateTime::createFromFormat('H:i', '7:00');
	$dayEnd  = DateTime::createFromFormat('H:i', '23:00');
	// use the dayStart and dayEnd times
	$startToCheck = DateTime::createFromFormat('H:i', $startToCheck);
	$endToCheck = DateTime::createFromFormat('H:i', $endToCheck);
	$startDayErrMsg = "Your reservation cannot be made before 7 AM!";
	$endDayErrMsg = "Your reservation cannot be made after 10 PM!";
	//$minuteErrMsg = "Your reservation must be made on 15 minute increments!";
	$startTimeErrMsg = "Your reservation start time is occurring after your end time!";

	

	//returns false if reservation made is before the valid start day time
	if($startToCheck < $dayStart)
	{
		$retValue = FALSE;
		if($outputError)
		{
			echo $startDayErrMsg;
		}

	}
	//returns false if reservation made is after the valid end day time
	else if($endToCheck > $dayEnd)
	{
		
	//	echo $endToCheck->format('H:i') . " is greater than " . $dayEnd->format('H:i');
		$retValue = FALSE;
		if($outputError)
		{
			echo $endDayErrMsg;
		}
	}

	//returns false if reservation made has a start time that is after the end time
	else if($startToCheck > $endToCheck)
	{
		$retValue = FALSE;
		if($outputError)
		{
			echo $startTimeErrMsg;
		}
	}
	//returns true if reservation made has no conflicting reservations times already made
	else
	{
		$retValue = TRUE;
	}
	
	
	return $retValue;
}
*/
?>
