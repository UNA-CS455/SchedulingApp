<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs455";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Get the firstname from the users database
$sql = "SELECT firstname FROM users WHERE users.email ='" . $_POST['owneremail'] . "'";
$result = $conn->query($sql);

if($row = $result->fetch_assoc() && $result->num_rows > 0) {
	$firstname = $row["firstname"];
} else {
    $firstname = "";
}

$conn->close();

$bodymsg = "<img src=\"YARSLOGO\"  alt=ScheduleConfirmation Made Easy border=0 > <br>" .
       "<table><tr><td><font face = 'Calibri' ><Center>YARS: a simple scheduler</center>" .
       "<center>University of North Alabama</center> <br>" .
       "<b><center>Retain for Future Reference </center></b> <br> <br>" .
       "Attention: %s, <br> <br>" .
       "You are receiving this email automatically because of a reservation you made through YARS (Yet Another Room Scheduler):<br>"; 

// create table to display reservation information
$tablemsg = <<<'EOT'
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
</style>
<table class="tg">
  <tr>
    <th class="tg-yw4l">Room</th>
    <th class="tg-yw4l">%s</th>
  </tr>
  <tr>
    <td class="tg-yw4l">Start Time</td>
    <td class="tg-yw4l">%s</td>
  </tr>
  <tr>
    <td class="tg-yw4l">End Time</td>
    <td class="tg-yw4l">%s</td>
  </tr>
  <tr>
    <td class="tg-yw4l">Recurring</td>
    <td class="tg-yw4l">%s</td>
  </tr>
  <tr>
    <td class="tg-yw4l" colspan="2">%s</td>
  </tr>
  <tr>
    <td class="tg-yw4l">Reserving Party</td>
    <td class="tg-yw4l">%s</td>
  </tr>
  <tr>
    <td class="tg-yw4l">Sharing Allowed</td>
    <td class="tg-yw4l">%s</td>
  </tr>
  <tr>
    <td class="tg-yw4l" colspan="2">%s</td>
  </tr>
</table>
EOT;

// closing section of message
$closemsg = "<br>If you think there has been error, please disregard this email or contact the system administrator. Do not reply to this email. You may change this reservation on the YARS system.<br>
-YARS <br>";
 
// combine all text to single message and insert reservation information
$msg = sprintf( $bodymsg . $tablemsg . $closemsg, 
         $firstname,
         $roomnumber,
         $starthour . ":" . $startmin . $start, 
         $starthour . ":" . $startmin . $end, 
         $occur, 
         $comment, 
         $owneremail, 
         $allowshare, 
         $numberOfSeats
         );
// add html headers        
$msg = "<!DOCTYPE html><html>" . $msg . "<HTML>";

// send email
mail($owneremail, "YARS CON", $msg, "From: reservations@warehouse414.org"); 
 
?>