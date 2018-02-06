<?php session_start();

/*
Name: Create Reservation Script
Description: Script to perform the create CRUD operation for new reservations
	into the reservation table of the database.
	Requires POST from the previous page sending data to be inserted:
	owneremail - varchar(100) that represents the email of the person who wants
				the reservation.
	roomnumber - varchar(100) that represents the name of the room.
	start - string representing the start time of the reservation in proper sql 
			datetime format: YYYY-MM-DD HH:MM:SS
	end - string representing the end time of the reservation in proper sql 
			datetime format: YYYY-MM-DD HH:MM:SS
	allowshare - a checkbox that will send a value of 1 if selected
	headcount - an integer
	comment - a varchar(500) for additional comments
	res_email - the email of the individual actually making the reservation.
	TODO: take res_email from the email of the currently logged in user. !!!!!!!!!!!!!!!!!!!!!!!!!!!
Authors: Luke Jennings, Jonathan Brazier


*/

   // if (!isset($_SESSION['username'])) {
     //   header("location:index.php");
        // Make sure that code below does not get executed when we redirect.
    //    exit;
    
//if(isset($_POST['create_reservation'])) //if make reservation clicked
{
	displayReservationForm();

	//if (isset($_POST['reserve'])) //if reserve clicked
	{
		processReservation();
	}

}




function displayReservationForm()
{
 {
   echo <<<HTMLBLOCK
	<form method = "POST" action = "CreateReservation.php">
	<table>
	  <tr>
		<th><label for = "res_email"> Reservation Email </label></th>
		<th><label for = "owneremail"> Owner Email </label></th>
		<th><label for = "roomnumber"> Room Number </label></th>
		<th><label for = "start"> Start Time </label></th>
		<th><label for = "end"> End Time </label></th>
		<th><label for = "repeat_id"> Reservation Email </label></th>
		<th><label for = "allowshare"> Allow Share </label></th>
		<th><label for = "headcount"> Head Count </label></th>
		<th><label for = "comment"> Comment </label></th>
	  </tr>

	  <tr>
		<td><input type = "email" id = "res_email" name = "res_email" maxlength = "50"></td>
		<td><input type = "email" id = "owneremail" name = "owneremail" maxlength = "50"></td>
		<td><input type = "text" id = "roomnumber" name = "roomnumber" maxlength = "50"></td>
		<td><input type = "number" id = "start" name = "start" ></td>
		<td><input type = "number" id = "end" name = "end"></td>
		<td>
		  <select id = "repeat_id" name = "repeat_id" placeholder = "Repeat">
			<option value = "monday"> Monday </option>
			<option value = "tuesday"> Tuesday </option>
			<option value = "wednesday"> Wednesday </option>
			<option value = "thursday"> Thursday </option>
			<option value = "friday"> Friday </option>
		  </select>
		</td>
		<td><input type = "checkbox" id = "allowshare" name = "allowshare" value = 1> Allow </td>
		<td><input type = "number" id = "headcount" name = "headcount" maxlength = "2"></td>
		<td><input type = "text" id = "comment" name = "comment" maxlength = "500"></td>
		<br>
		<td style = "float:right"><input type = "submit" id="reserve" name="reserve" value = "Save Reservation"></td>
	 </tr>
	</table>
	</form>
HTMLBLOCK;
	}
}
//-------------------------------------------------------------------------------------------------------------
//
//-------------------------------------------------------------------------------------------------------------
function processReservation()
{
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs455";

$roomnumber = ($_POST['roomnumber']);
$roomnumber = trim($roomnumber);
//$roomnumber = filter_var($roomnumber, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^   $/")));

$owneremail = ($_POST['owneremail']);
$owneremail = trim($owneremail);
//$owneremail = filter_var($owneremail, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^   $/")));

if(isset($_POST['allowshare']))
	$allowshare = ($_POST['allowshare']);
else
	$allowshare = 0;

$headcount = ($_POST['headcount']);
$headcount = trim($headcount);
//$headcount = filter_var($headcount, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^   $/")));

$start = ($_POST['start']);
$start = trim($start);
//$start = filter_var($start, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^   $/")));

$end = ($_POST['end']);
$end = trim($end);
//$end = filter_var($end, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^   $/")));

$comment = ($_POST['comment']);
$comment = trim($comment);
//$comment = filter_var($comment, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^   $/")));

//$id = ($_POST['id']);
//$id = trim($id);
//$id = filter_var($id, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^   $/")));

$repeat_id = ($_REQUEST['repeat_id']);
$repeat_id = trim($repeat_id);
//$repeat_id = filter_var($repeat_id, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^   $/")));

$res_email = ($_REQUEST['res_email']);
$res_email = trim($res_email);
//$res_email = filter_var($res_email, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^   $/")));

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	}

$sql = "INSERT into reservations (roomnumber, owneremail, allowshare, headcount, start, end, comment, repeat_id, res_email) VALUES ('$roomnumber', '$owneremail', '$allowshare', '$headcount', '$start', '$end', '$comment', '$repeat_id', '$res_email')";

	if ($conn->query($sql) === TRUE) {
                echo "Reservation made successfully";
            } else {
                echo "Error making reservation: " . $conn->error;
            }

            $conn->close();

	//TODO Insert session variables that sends the data to mail.php.
	// header("location:mail.php")

}
?>