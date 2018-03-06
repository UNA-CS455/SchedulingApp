<?php

$dayStart = 7;
$dayEnd = 22;




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
	global $dayStart, $dayEnd;
	$startDayErrMsg = "Your Reservation cannot be made before 7 AM!";
	$endDayErrMsg = "Your reservation cannot be made after 10 PM!";
	$minuteErrMsg = "Your reservation must be made on 15 minute increments!";
	$startTimeErrMsg = "Your reservation start time is occurring after your end time!";
	$goodMsg = "Reservation Time Valid!";

	

	//returns false if reservation made is before the valid start day time equal to 7
	if($startToCheck < $dayStart)
	{
		$retValue = FALSE;
		if($outputError)
		{
			echo $startDayErrMsg;
		}

	}
	//returns false if reservation made is after the valid end day time equal to 22 (10PM)
	else if($endToCheck > $dayEnd+1)
	{
		$retValue = FALSE;
		if($outputError)
		{
			echo $endDayErrMsg;
		}
	}
	//returns false if reservation made has a minute value that is not on the required fifteen minute interval
	/*
	else if($startToCheck%15 != 0)
	{
		$retValue = FALSE;
		if($outputError)
		{
			echo $startToCheck%15;
			echo $minuteErrMsg;
		}
	} */
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
		if($outputError)
		{
			echo $goodMsg;
		}
	}
	
	
	return $retValue;
}

/*
function checkHeadcount()
{



}
*/

//****************************************************************************
//This function checks the database for reservations that are made or
//updated to the system that conflict with another reservation already
//made and doesnt allow roomsharing. It will also be used to give the 
//user a visual representation of the rooms that are allowing sharing
//and the rooms who do not on the Agenda screen (red and green highlight)
//****************************************************************************
function checkAllowSharing($outputError, $newResStart, $newResEnd, $room)
{
	//error message diplayed when false
	$errMsg = "This Reservation overlaps with another reservation who doesn't allow sharing";
	//default set to false
	$returnVal=FALSE;
	global $dayStart, $dayEnd;
	require "db_conf.php";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
	}

	//Locates a conflicting reservation made that overlaps times of another reservation that doesn't allow sharing 
	$sql = "SELECT * FROM reservations WHERE roomnumber = '$room' AND allowshare = '0'
				AND((starttime > '$newResStart' AND endtime < '$newResEnd')
				OR(endtime > '$newResEnd' AND starttime < '$newResEnd')
				OR(starttime < '$newResStart' AND endtime > '$newResStart'))";

	$result = $conn->query($sql);

	if($result->num_rows > 0)
	{
		$returnVal = FALSE;
		//if false, display error message
		if($outputError)
		{
			echo $errMsg;
		}
	}
	else
	{
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
function checkValidTime($outputError, $newResStart, $newResEnd, $room)
{
	//Return the boolean value
	return checkAllowSharing($outputError, $newResStart, $newResEnd, $room) && checkDateTime($outputError, $newResStart, $newResEnd);

}




















?>