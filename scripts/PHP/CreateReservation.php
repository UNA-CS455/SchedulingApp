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

//-----------------------------------------------------------------------------
//Function to display reservation form once a day is clicked in index.html
//-----------------------------------------------------------------------------
function displayReservationForm()
{

/*echo <<<HTMLBLOCK
<!DOCTYPE html>
<html>
<head>
<title>UNA Scheduling app</title>
</head>
<body>

<h1>Make Reservation</h1>
<form method="POST" action="CreateReservation.php">
  Reserving email*:
  <input type="email" name="owneremail"><br>

  Room Number:
  <input type="text" name="roomnumber"><br>

  <p>Duration*:</p>
  Start time:
  <input type="text" name="starthour" style="width: 48px">
  <input type="text" name="startminute" style="width: 48px">
  <select name="start">
  <option value="AM">AM</option>
  <option value="PM">PM</option>
  </select>
  <input id="date" type="date" name="startdate" placeholder="2018/01/26" required/><br>

  End time:
  <input type="text" name="endhour" style="width: 48px">
  <input type="text" name="endminute" style="width: 48px">
  <select name="end">
  <option value="AM">AM</option>
  <option value="PM">PM</option>
  </select>
  <input id="date" type="date" name="enddate" placeholder="2018/01/26" required/><br>

  Recurring:
  <select name="occur">
  <option value="Once">Just Once</option>
  <option value="Weekly">Weekly</option>
  <option value="Monthly">Monthly</option>
</select><br>

  <input type="checkbox" name="allowshare" value="1">Allow room sharing<br>

  Expected number of seats needed:
  <input type="text" name="numberOfSeats" style="width: 48px"><br>

  Comments<br>
  <input type = "text" textarea rows="10" cols="50" name="comment">
  </textarea><br>

  <button type="submit" name="reserve" value="Submit">Make reservation</button>
</form>

</body>
</html>
HTMLBLOCK;*/
}

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

//dropdown menu for start AM or PM select option
$start = ($_POST['start']);

//dropdown menu for end AM or PM select option
$end = ($_POST['end']);

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

//connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

//if connection to database fails, die
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//if connection is success, insert data into database and echo to user result
$sql = "INSERT INTO reservations (roomnumber, owneremail, allowshare, headcount, startdate, enddate, starttime, endtime, occur, comment, res_email) VALUES ('$roomnumber', '$owneremail', '$allowshare', '$numberOfSeats', '$startdate', '$enddate', '$starthour:$startminute $start', '$endhour:$endminute $end', '$occur', '$comment', '$logged_in_user')";

	if ($conn->query($sql) === TRUE) {
                echo "Reservation made successfully";
		include 'mail.php';
            } else {
                echo "Error making reservation: " . $conn->error;
            }

            $conn->close();



}
?>
