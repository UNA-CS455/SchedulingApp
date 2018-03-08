<?php session_start();

	if (!isset($_SESSION['username'])){
			$_SESSION['username'] = "jcrabtree@una.edu";
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

//if($owneremail = filter_var($owneremail, FILTER_VALIDATE_EMAIL)) {
//	echo "Valid email accepted";
//}

//else {
//	echo "Error making reservation: Invalid email " . $conn->error;
//	exit;
//	$conn->close();
//}

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

//variable for start date of reservation
$startdate = ($_POST['startdate']);

//hour reservation ends
$endhour = ($_POST['endhour']);
$endhour = trim($endhour);
$endhour = filter_var($endhour, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}$/")));

//minute reservation ends
$endminute = ($_POST['endminute']);
$endminute = trim($endminute);
$endminute = filter_var($endminute, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}$/")));

//variable for end date of reservation
$enddate = ($_POST['enddate']);

//dropdown menu for how often the reservation should occur
$occur = ($_POST['occur']);

//comment variable
$comment = ($_POST['comment']);
$comment = trim($comment);
$comment = filter_var($comment, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z''-'\s]{1,250}$/")));
//$comment = str_replace("'","\'", $comment);

//submit button variable
//probably don't need this?
//$reserve = ($_POST['reserve']);

//We must validate the times and constraints given 
require_once 'ValidateReservation.php'; // gain access to validation functions


if(checkValidTime(true, $starthour . ":" . $startminute, $endhour . ":" . $endminute, $roomnumber)){
	//connect to database
	$conn = new mysqli($servername, $username, $password, $dbname);

	//if connection to database fails, die
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	//if connection is success, insert data into database and echo to user result
	$sql = "INSERT INTO reservations (roomnumber, owneremail, allowshare, headcount, startdate, enddate, starttime, endtime, occur, comment, res_email) VALUES ('$roomnumber', '$owneremail', '$allowshare', '$numberOfSeats', '$startdate', '$enddate', '$starthour:$startminute', '$endhour:$endminute', '$occur', '$comment', '$logged_in_user')";
		
		if ($conn->query($sql) === TRUE) {
			echo "Reservation made successfully";
			//include 'mail.php'; uncomment when on deployed version
			} else {
				echo "Error making reservation: " . $conn->error;
			}

			$conn->close();


		}
}
?>
