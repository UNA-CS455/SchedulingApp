<?php session_start();
/******************************************************************************
Create Reservation Script

Description: Script that, when POST to, will pull variables from POST array
and use these to insert into the reservations table.
roomnumber, owneremail,numberOfSeats(as in headcount field),starthour, startminute,
endhour,endminute, allowshare, date, and occur (as in recurring enumerated type)
should be sent via POST.

Spring 2018
******************************************************************************/
	if (!isset($_SESSION['username'])){
		//TODO redirect to login.
			$_SESSION['username'] = "admin@una.edu";
	}
	//$_SESSION['logged_in_useremail']
    //$roomnumber = $_POST['roomnumber'];
/*	displayReservationForm();

	if (isset($_POST['reserve'])) //if reserve clicked
	{

		processReservation();
	}*/

	processReservation();


//-------------------------------------------------------------------------------------------------------------
//Function to process the reservation into the database once reserve is clicked
//-------------------------------------------------------------------------------------------------------------
function processReservation()
{
	$logged_in_user = $_SESSION['username'];
		
	require "db_conf.php"; // set servername,username,password,and dbname

	//roomnumber should come from index page....?????
	$roomnumber = ($_POST['roomnumber']);

	//email that owns the reservation
	$owneremail = ($_POST['owneremail']);
	$owneremail = trim($owneremail);
	$owneremail = filter_var($owneremail, FILTER_SANITIZE_EMAIL);
	//$owneremail = filter_var($owneremail, FILTER_VALIDATE_EMAIL, array("options"=>array("regexp"=>"/^[a-zA-Z \.\-!,]{1,64}$/")));


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
	$date = ($_POST['date']);

	//dropdown menu for how often the reservation should occur
	$occur = ($_POST['occur']);


	//comment variable
	$comment = ($_POST['comment']);
	$comment = trim($comment);
	$comment = filter_var($comment, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z''-'\s]{1,250}$/")));
	$comment = str_replace("'","\'", $comment);
	// TODO: strip " character


	//We must validate the times and constraints given 
	require_once 'ValidateReservation.php'; // gain access to validation functions

	if(checkValidTime_overload($starthour . ":" . $startminute, $endhour . ":" . $endminute, $date, $roomnumber)){
		if($occur === "Once" || $occur == null){
			//connect to database
			$conn = new mysqli($servername, $username, $password, $dbname);

			//if connection to database fails, die
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			//if connection is success, insert data into database and echo to user result
			//$sql = "INSERT INTO reservations (roomnumber, owneremail, allowshare, headcount, startdate, enddate, starttime, endtime, occur, comment, res_email) VALUES ('$roomnumber', '$owneremail', '$allowshare', '$numberOfSeats', '$date', '$date', '$starthour:$startminute', '$endhour:$endminute', '$occur', '$comment', '$logged_in_user')";
			$stmt = $conn->prepare("INSERT INTO reservations (roomnumber, owneremail, allowshare, headcount, startdate, enddate, starttime, endtime, occur, comment, res_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$startAssist = date('H:i', strtotime($starthour . ":" . $startminute));
			$endAssist = date('H:i', strtotime($endhour . ":" . $endminute));
			$stmt->bind_param("ssissssssss", $roomnumber, $owneremail, $allowshare, $numberOfSeats, $date, $date, $startAssist, $endAssist, $occur, $comment, $logged_in_user);
			$check = $stmt->execute();
			//$mResult = $stmt->get_result();
			
			if(isset($_POST['sendEmail'])){
				if ($check === TRUE && $_POST['sendEmail'] === "true") {
					include 'mail.php'; // uncomment when on deployed version
					
					sendMail();
				} 
			}
			if (!$check) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			else{
				echo "Reservation made successfully";
			}

			
		} else {
			//if reservation is weekly
			if ($occur === "Weekly"){
				//Date is incremented by 1 week each iteration
				$interval = new DateInterval('P1W');
			} else {
				//Date is incremented by 4 weeks each iteration
				$interval = new DateInterval('P4W');
			}

			//connect to database
			$conn = new mysqli($servername, $username, $password, $dbname);

			//if connection to database fails, die
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			//Used to determine success message at the end of the loop
			$success = FALSE;
			
			$begin = new DateTime($date);
			$end = new DateTime(date('Y-m-d', strtotime($date . '+ 6 months')));
			
			$daterange = new DatePeriod($begin, $interval, $end);
			
			foreach ($daterange as $date) {
				//format the date
				$fDate = $date->format("Y-m-d"); 
				
				//if connection is success, insert data into database and echo to user result
				//$sql = "INSERT INTO reservations (roomnumber, owneremail, allowshare, headcount, startdate, enddate, starttime, endtime, occur, comment, res_email) VALUES ('$roomnumber', '$owneremail', '$allowshare', '$numberOfSeats', '$date', '$date', '$starthour:$startminute', '$endhour:$endminute', '$occur', '$comment', '$logged_in_user')";
				$stmt = $conn->prepare("INSERT INTO reservations (roomnumber, owneremail, allowshare, headcount, startdate, enddate, starttime, endtime, occur, comment, res_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$startAssist = date('H:i', strtotime($starthour . ":" . $startminute));
				$endAssist = date('H:i', strtotime($endhour . ":" . $endminute));
				$stmt->bind_param("ssissssssss", $roomnumber, $owneremail, $allowshare, $numberOfSeats, $fDate, $fDate, $startAssist, $endAssist, $occur, $comment, $logged_in_user);
				$check = $stmt->execute();
				//$mResult = $stmt->get_result();
				
				if (!$check) {
					echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				else{
					$success = TRUE;
				}
			}
			if ($success === TRUE){
				echo "Reservations made successfully";
				//include 'mail.php'; uncomment when on deployed version
			}
		}
		$conn->close();
	} else{
		echo "Error making reservation.";
	}
	
	
}

?>
