<?php
//POST



//to do: fix the functions below so they use these instead of having to locally define them
$dayStart = DateTime::createFromFormat('H:i', '7:00');
$dayEnd = DateTime::createFromFormat('H:i', '23:00'); // checks up to this date. So if you want the 10 hour block to
// be open, then set this to 11 as closing time
//*************************************************************************************
//This function checks a number of requirements on a new reservation being made.
//If the reservation being made is before or after the start day and end day time
//it returns FALSE and the correct error message to the user. If the reservation 
//made is not on a fifteen minute interval, then it returns FALSE and the correct 
//message is displayed to the user. If the reservation start time occurs after the
//end time then return FALSE and display correct message to the user. If the reser-
//vation being made is good, the correct message is displayed and returnsVal = TRUE.
//************************************************************************************

function checkDateTime($outputError, $startToCheck, $endToCheck) {
    //msg variables to indicate the problem that occurred 
    $returnVal = FALSE;

    $dayStart = DateTime::createFromFormat('H:i', '7:00');
    $dayEnd = DateTime::createFromFormat('H:i', '23:00');
    // use the dayStart and dayEnd times
    $startToCheck = DateTime::createFromFormat('H:i', $startToCheck);
    $endToCheck = DateTime::createFromFormat('H:i', $endToCheck);
    $startDayErrMsg = "Your reservation cannot be made before 7 AM!";
    $endDayErrMsg = "Your reservation cannot be made after 11 PM!";
    $minuteErrMsg = "Your reservation must be made on 15 minute increments!";
    $startTimeErrMsg = "Your reservation start time is occurring after your end time!";




    //returns false if reservation made is before the valid start day time
    if ($startToCheck < $dayStart) {
        $retValue = FALSE;
        if ($outputError) {
            echo $startDayErrMsg;
        }
    }
    //returns false if reservation made is after the valid end day time
    else if ($endToCheck > $dayEnd) {

        $retValue = FALSE;
        if ($outputError) {
            echo $endDayErrMsg;
        }
    }

    //returns false if reservation made has a start time that is after the end time
    else if ($startToCheck > $endToCheck) {
        $retValue = FALSE;
        if ($outputError) {
            echo $startTimeErrMsg;
        }
    }
    //returns true if reservation made has no conflicting reservations times already made
    else {
        $retValue = TRUE;
        if ($outputError) {
            //echo $goodMsg;
        }
    }


    return $retValue;
}

//****************************************************************************
//This function checks the database for reservations that are made or
//updated to the system that conflict with another reservation already
//made and doesnt allow roomsharing. It will also be used to give the 
//user a visual representation of the rooms that are allowing sharing
//and the rooms who do not on the Agenda screen (red and green highlight)
//****************************************************************************
function checkAllowSharing($outputError, $newResStart, $newResEnd, $room) {
    //error message diplayed when false
    $errMsg = "Given times overlap with another reservation made by a user who opted not to share the room.";
    //default set to false
    $returnVal = FALSE;
    //global $dayStart, $dayEnd; this doesn't work for some reason
    $dayStart = DateTime::createFromFormat('H:i', '7:00');
    $dayEnd = DateTime::createFromFormat('H:i', '23:00');
    $newResStart = DateTime::createFromFormat('H:i', $newResStart);
    $newResEnd = DateTime::createFromFormat('H:i', $newResEnd);
    require "db_conf.php";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //Locates a conflicting reservation made that overlaps times of another reservation that doesn't allow sharing 

    $newResStart = $newResStart->format('H:i');
    $newResEnd = $newResEnd->format('H:i');
    $sql = "SELECT * FROM reservations WHERE roomnumber = '$room' AND allowshare = '0'
				AND((starttime > '$newResStart' AND endtime <= '$newResEnd')
				OR(endtime >= '$newResEnd' AND starttime < '$newResEnd')
				OR(starttime < '$newResStart' AND endtime >= '$newResStart'))";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $returnVal = FALSE;
        //if false, display error message
        if ($outputError) {
            echo $errMsg;
        }
    } else {
        $returnVal = TRUE;
    }

    //close database connection
    $conn->close();

    //Return the boolean value
    return $returnVal;
}

//****************************************************************************
// Overload
//This function checks the database for reservations that are made or
//updated to the system that conflict with another reservation already
//made and doesn't allow roomsharing. It will also be used to give the 
//user a visual representation of the rooms that are allowing sharing
//and the rooms who do not on the Agenda screen (red and green highlight)
//****************************************************************************
function checkAllowSharing_overload($outputError, $newResStart, $newResEnd, $date, $room) {
    //error message displayed when false
    $errMsg = "Given times overlap with another reservation made by a user who opted not to share the room.";
    //default set to false
    $returnVal = FALSE;
    //global $dayStart, $dayEnd; this doesn't work for some reason
    $dayStart = DateTime::createFromFormat('H:i', '7:00');
    $dayEnd = DateTime::createFromFormat('H:i', '23:00');
    $newResStart = DateTime::createFromFormat('H:i', $newResStart);
    $newResEnd = DateTime::createFromFormat('H:i', $newResEnd);
    require "db_conf.php";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //Locates a conflicting reservation made that overlaps times of another reservation that doesn't allow sharing 

    $newResStart = $newResStart->format('H:i');
    $newResEnd = $newResEnd->format('H:i');
    $sql = "SELECT * FROM reservations WHERE allowshare = '0' AND startdate = '$date' AND roomnumber = '$room'
				AND((starttime > '$newResStart' AND endtime <= '$newResEnd')
				OR(endtime >= '$newResEnd' AND starttime < '$newResEnd')
				OR(starttime < '$newResStart' AND endtime > '$newResStart'))";

	//echo $sql;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $returnVal = FALSE;
        //if false, display error message
        if ($outputError) {
            echo $errMsg;
        }
    } else {
        $returnVal = TRUE;
    }

    //close database connection
    $conn->close();

    //Return the boolean value
    return $returnVal;
}

//****************************************************************************
//Performs all checks to see if the particualar time slot is open.
//****************************************************************************
function checkValidTime($outputError, $newResStart, $newResEnd, $room) {
    //Return the boolean value
    return checkDateTime($outputError, $newResStart, $newResEnd) && checkAllowSharing($outputError, $newResStart, $newResEnd, $room);
}

//****************************************************************************
//Overload Performs all checks to see if the particualar time slot is open.
//****************************************************************************
function checkValidTime_overload($newResStart, $newResEnd, $date, $room) {
    //Return the boolean value
    return checkDateTime(false, $newResStart, $newResEnd) && checkAllowSharing_overload(true, $newResStart, $newResEnd, $date, $room);
}

//TODO:
/*
  Refactor, add a boolean value to the checkValidTime_overload function $outputError, similar
  to the boolean parameter in checkValidTime. I just added the function below to pass false to
  checkallowSharing_overload since I needed it for the day view, this was after writing the above one
  so we need to go back and just add that outputError parameter above and go to dayView.php and get rid
  of the below redundant function.
 */
//****************************************************************************
//Overload Performs all checks to see if the particualar time slot is open.
//****************************************************************************
function checkValidTime_overload_noerr($newResStart, $newResEnd, $date, $room) {
    //Return the boolean value
    return checkDateTime(false, $newResStart, $newResEnd) && checkAllowSharing_overload(false, $newResStart, $newResEnd, $date, $room);
}


function checkAnyCollision($newResStart, $newResEnd, $date, $room){
	$returnVal = true;
	$newResStart = DateTime::createFromFormat('H:i', $newResStart);
    $newResEnd = DateTime::createFromFormat('H:i', $newResEnd);
    require "db_conf.php";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //Locates any collision

    $newResStart = $newResStart->format('H:i');
    $newResEnd = $newResEnd->format('H:i');
    $sql = "SELECT * FROM reservations WHERE startdate = '$date' AND roomnumber = '$room'
				AND((starttime > '$newResStart' AND endtime <= '$newResEnd')
				OR(endtime >= '$newResEnd' AND starttime < '$newResEnd')
				OR(starttime < '$newResStart' AND endtime > '$newResStart')) LIMIT 1";
	
	//echo $sql . "<br><br>";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $returnVal = TRUE; // collision

    } else {
        $returnVal = FALSE; // no collision
    }

    //close database connection
    $conn->close();

    //Return the boolean value
    return $returnVal;

}

function checkEnoughSeats($outputError, $newResStart, $newResEnd, $newResDate, $room, $givenHeadcount) {
    //error message diplayed when false
    $errMsg = "There aren't enough seats left";
    //default set to false
    $returnVal = FALSE;
    //global $dayStart, $dayEnd; this doesn't work for some reason
    $dayStart = DateTime::createFromFormat('H:i', '7:00');
    $dayEnd = DateTime::createFromFormat('H:i', '23:00');
    $newResStart = DateTime::createFromFormat('H:i', $newResStart);
    $newResEnd = DateTime::createFromFormat('H:i', $newResEnd);
    require "db_conf.php";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //Locates a conflicting reservation made that overlaps times of another reservation that doesn't allow sharing 


    $newResStart = $newResStart->format('H:i');
    $newResEnd = $newResEnd->format('H:i');
    $sql = "SELECT rooms.roomid, reservations.id, sum(headcount) AS seats_taken, rooms.seats - sum(headcount) AS seats_remaining 
				FROM reservations LEFT JOIN rooms ON rooms.roomid = reservations.roomnumber WHERE allowshare = '1' AND 
				startdate = '$newResDate' AND roomnumber = '$room'
				AND((starttime > '$newResStart' AND endtime <= '$newResEnd')
				OR(endtime >= '$newResEnd' AND starttime < '$newResEnd')
				OR(starttime < '$newResStart' AND endtime >= '$newResStart') 
				OR (starttime = '$newResStart'))";

    //echo $sql . "<br><br><br><br>";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($result->num_rows == 0 || $row['seats_remaining'] == null) {
        // there are no overlapping reservations to begin with, so return true.
        $returnVal = TRUE;
    } else if ($givenHeadcount > $row['seats_remaining']) {
        // too many seats taken.
        $returnVal = FALSE;
        if ($outputError) {
            echo $errMsg;
        }
    } else {
        $returnVal = TRUE;
    }

    //close database connection
    $conn->close();

    //Return the boolean value
    return $returnVal;
}

function checkValidUpdate($outputError, $newStartTime, $newEndTime, $date, $room, $id) {
    //error message displayed when false
    $errMsg = "Given times overlap with another reservation made by a user who opted not to share the room.";
    //default set to false
    $returnVal = FALSE;
    //global $dayStart, $dayEnd; this doesn't work for some reason
    $dayStart = DateTime::createFromFormat('H:i', '7:00');
    $dayEnd = DateTime::createFromFormat('H:i', '23:00');
    require "db_conf.php";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //Locates a conflicting reservation made that overlaps times of another reservation that doesn't allow sharing 

    $newStartTime = $newStartTime->format('H:i');
    $newEndTime = $newEndTime->format('H:i');
    $sql = "SELECT * FROM reservations WHERE roomnumber = '$room' AND allowshare = '0'
                                AND id <> '$id'
                                AND startdate = '$date'
				AND((starttime >= '$newStartTime' AND endtime <= '$newEndTime')
				OR(endtime >= '$newEndTime' AND starttime < '$newEndTime')
				OR(starttime <= '$newStartTime' AND endtime > '$newStartTime'))";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $returnVal = FALSE;
        //if false, display error message
        if ($outputError) {
            echo $errMsg;
        }
    } else {
        $returnVal = TRUE;
    }

    //close database connection
    $conn->close();

    //Return the boolean value
    return $returnVal;
}

function checkReservation($starttime, $endtime, $date, $room, $id) {
    //error message diplayed when false
    $errMsg = "Given times overlap with another reservation made by a user who opted not to share the room.";
    //default set to false
    $returnVal = FALSE;
    //global $dayStart, $dayEnd; this doesn't work for some reason
    $dayStart = DateTime::createFromFormat('H:i', '7:00');
    $dayEnd = DateTime::createFromFormat('H:i', '23:00');
    require "db_conf.php";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //Locates a conflicting reservation made that overlaps times of another reservation that doesn't allow sharing 

    $starttime = $starttime->format('H:i');
    $endtime = $endtime->format('H:i');
    $sql = "SELECT * FROM reservations WHERE roomnumber = '$room'
                                AND id <> '$id'
                                AND startdate = '$date'
				AND((starttime >= '$starttime' AND endtime <= '$endtime')
				OR(endtime >= '$endtime' AND starttime < '$endtime')
				OR(starttime <= '$starttime' AND endtime > '$starttime'))";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $returnVal = FALSE;
        //if false, display error message
        echo $errMsg;
    } else {
        $returnVal = TRUE;
    }

    //close database connection
    $conn->close();

    //Return the boolean value
    return $returnVal;
}


//****************************************************************************
// Checks a recurring reservation request. Given a duration start to end, and 
// a room, this function will return any reservation that collides with 
// the particular time slot. A null value for headcount will assume sharing
// is not allowed, else reservations will be checked against sharing parameters.
// Interval is the recurring interval. 
// Return: Array of dates(YYYY/MM/DD) that can't be booked.
// Author: Derek Brown
// Date: 4/28/2018
//****************************************************************************
function checkReservationRecurring($starttime,$endtime, $dateStart, $dateEnd, $room, $interval, $headcount){
	$dateArray = array();
	for($i = clone $dateStart; $i < $dateEnd; $i->add($interval)){
		// first, we will check if numberOfSeats is set. If it was not, then they don't want to share, so we will just check for any
		// colliding reservationns with checkAnyCollision (coming from ValidateReservation.php). This function returns true if there
		// is any collision with a reservation at all. So we only allow the reservation to be made if this function returns false. We store
		// this return value in $collisionCheck and check it in the if statement that follows.
		$collisionCheck = false;
		if($headcount == null || $headcount == false){
			
			$collisionCheck = checkAnyCollision($starttime, $endtime, $i->format('Y-m-d'), $room);
		}

		if($collisionCheck || !checkValidTime_overload_noerr($starttime, $endtime, $i->format('Y-m-d'), $room) || (($headcount != null) && (!checkEnoughSeats(false, $starttime, $endtime, $i->format('Y-m-d'), $room, $headcount)))){
			
			$dateArray[] = clone $i;
		}
	}
	return $dateArray;
}

?>