<?php session_start();
    //$_SESSION['logged_in_useremail']
    //$roomnumber = $_POST['roomnumber']
?>

<!DOCTYPE html>
<html>
<head>
<title>UNA Scheduling app</title>
</head>
<body>

<h1>Make Reservation</h1>
<form method="POST" action="/scripts/PHP/CreateReservation.php">
  Reserving email*:
  <input type="text" name="owneremail"><br>

  <p>Duration*:</p>
  Start time:
  <input type="text" name="startHour" style="width: 48px">
  <input type="text" name="startMinute" style="width: 48px">
  <select>
  <option value="startAM">AM</option>
  <option value="startPM">PM</option>
  <input id="date" type="date" name="date" placeholder="2018/01/26" required/><br>
</select>

  End time:
  <input type="text" name="endHour" style="width: 48px">
  <input type="text" name="endMinute" style="width: 48px">
  <select>
  <option value="endAM">AM</option>
  <option value="endPM">PM</option>
  </select>
  <input id="date" type="date" name="date" placeholder="2018/01/26" required/><br>

  Recurring:
  <select>
  <option value="Once">Just Once</option>
  <option value="Weekly">Weekly</option>
  <option value="Monthly">Monthly</option>
</select><br>

  <input type="checkbox" name="allowshare" value="true">Allow room sharing<br>

  Expected number of seats needed:
  <input type="text" name="numberOfSeats" style="width: 48px"><br>

  Comments<br>
  <textarea rows="10" cols="50" name="comment">
  </textarea><br>

  <button type="submit" value="Submit">Make reservation</button>
</form>

</body>
</html>
