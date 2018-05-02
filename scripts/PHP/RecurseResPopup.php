<?php session_start();

	require_once 'ValidateReservation.php'; // gain access to validation functions

	//roomnumber should come from index page....?????
	$roomnumber = ($_POST['roomnumber']);

	//checkbox type
	$allowshare=($_POST['allowshare']);


	//headcount
	$numberOfSeats = ($_POST['numberOfSeats']);
	$numberOfSeats = trim($numberOfSeats);
	$numberOfSeats = filter_var($numberOfSeats, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}$/")));

	//Hour reservation starts
	$starthour = ($_POST['starthour']);
	$starthour = trim($starthour);
	$starthour = filter_var($starthour, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}$/")));

	//minute reservation starts
	$startminute = ($_POST['startminute']);
	$startminute = trim($startminute);
	$startminute = filter_var($startminute, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}$/")));

	//hour reservation ends
	$endhour = ($_POST['endhour']);
	$endhour = trim($endhour);
	$endhour = filter_var($endhour, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}$/")));

	//minute reservation ends
	$endminute = ($_POST['endminute']);
	$endminute = trim($endminute);
	$endminute = filter_var($endminute, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}$/")));

	//variable for end date of reservation
	$dateStart = ($_POST['date']);
	$begin = new DateTime($dateStart);
	$end = new DateTime(date('Y-m-d', strtotime($dateStart . '+ 6 months')));

	//dropdown menu for how often the reservation should occur
	$occur = ($_POST['occur']);
	
	switch($occur){
		case "Weekly":
			$interval = new DateInterval('P1W');
			break;
		case "Monthly":
			$interval = new DateInterval('P1M');
			break;
	}
	
	$starttime = date('H:i', strtotime($starthour . ":" . $startminute));
	$endtime = date('H:i', strtotime($endhour . ":" . $endminute));
	
	
	$badRes = checkReservationRecurring($starttime,$endtime, $begin, $end, $roomnumber, $interval, $numberOfSeats);
	if(count($badRes) > 0){
		echo "The following day(s) conflict with your ($occur) time selection:<br>";
		echo "<div id='badresarea' style='overflow-y:scroll;max-height: 150px;'>";
		foreach($badRes as $res){
			echo "<span>" . $res->format('Y-m-d') . "</span><br>";
 		}
		echo "</div>";
		$badRes = json_encode($badRes);
		echo "These reservations will not be made due to conflicts with other reservations. Would you still like to reserve the available days?<br>";
		echo "<button onclick='bulkReserve($badRes)'>Yes</button> <button onclick='closeModal()'>No</button>";
	} else{
		echo "This reservation will be made $occur. You have no conflicts!<br> Please confirm your reservation(s) below to reserve $roomnumber starting<br> " . $begin->format('Y-m-d') ." through " .$end->format('Y-m-d') ." $occur.<br><br>";
		echo "<button onclick='bulkReserve()'>Confirm</button> <button onclick='closeModal()'>Cancel</button>";
	}
?>