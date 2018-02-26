<?php session_start();
    //$_SESSION['logged_in_useremail'];
    //$roomnumber = $_POST['roomnumber'];
    $date = $_POST['date'];

?>

<!DOCTYPE html>
<html>
<head>

<title>UNA Scheduling app</title>
</head>
<body>

<div class="dayview">
	<font id="createLabel">08 March 2018 - Raburn 206</font>
</div>

<div class="makeReservation" id="createZone">
  <div class="test">
  <h1>Make Reservation</h1>
    Reserving email*:
    <input type="text" id="owneremail" required><br>

    <p>Duration*:</p>
    Start time:
    <input type="text" id="startHour" style="width: 48px" required>:
    <input type="text" id="startMinute" style="width: 48px" required>
    <select id="start">
    <option value="AM">AM</option>
    <option value="PM">PM</option>
	</select>
	<br>


    End time:	
    <input type="text" id="endHour" style="width: 48px" required>:
    <input type="text" id="endMinute" style="width: 48px" required>
    <select id="end">
    <option value="AM">AM</option>
    <option value="PM">PM</option>
    </select>
	<br>

    Recurring:
    <select id="occur">
    <option value="Once">Just Once</option>
    <option value="Weekly">Weekly</option>
    <option value="Monthly">Monthly</option>
  </select><br><br>

    <input type="checkbox" id="allowshare">Allow room sharing<br><br>

    Expected number of seats needed:
    <input type="text" id="numberOfSeats" style="width: 48px"><br><br>

    <!-- add css for this boi -->
    Comments<br>
    <textarea rows="10" cols="50" id="comment"></textarea><br><br><br><br><br><br><br><br><br>
	<input type="hidden" id = "startdate" value = <?php echo "'$date'"; ?>>
	<input type="hidden" id = "enddate" value = <?php echo "'$date'"; ?>>
	
    <button onclick="createClicked()">Make reservation</button><br><br>
	<font id="responseText"></font>
</div>
</div>

<div class="calendar">
  <table style="width:100%">
    <tr>
      <th style="width:10%">Time</th>
      <th style="width:30%"></th>
      <th style="width:30%">Bookings</th>
      <th style="width:30%"></th>
    </tr>
    <tr>
      <td>7:00AM</td>
      <td bgcolor="#00FFFF">Roden@una.edu[7:00AM - 10:00AM]</td>
      <td bgcolor="#00FFFF"></td>
      <td bgcolor="#00FFFF"></td>
    </tr>
    <tr>
      <td>8:00AM</td>
      <td bgcolor="#00FFFF"></td>
      <td bgcolor="#00FFFF"></td>
      <td bgcolor="#00FFFF"></td>
    </tr>
    <tr>
      <td>9:00AM</td>
      <td bgcolor="#00FFFF"></td>
      <td bgcolor="#00FFFF"></td>
      <td bgcolor="#00FFFF"></td>
    </tr>
    <tr>
      <td>10:00AM</td>
      <td bgcolor="#00FFFF"></td>
      <td bgcolor="#00FFFF"></td>
      <td bgcolor="#00FFFF"></td>
    </tr>
    <tr>
      <td>11:00AM</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>12:00PM</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>1:00PM</td>
      <td bgcolor = "#FF9393">Jenkins@una.edu[1:00PM - 3:00PM]</td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>2:00PM</td>
      <td bgcolor = "#FF9393"></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>3:00PM</td>
      <td bgcolor = "#FF9393"></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>4:00PM</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>5:00PM</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>6:00PM</td>
      <td></td>
      <td></td>
      <td bgcolor = "#93FFB9">Crabtree@una.edu[6:00PM - 9:00PM]</td>
    </tr>
    <tr>
      <td>7:00PM</td>
      <td></td>
      <td></td>
      <td bgcolor = "#93FFB9"></td>
    </tr>
    <tr>
      <td>8:00PM</td>
      <td></td>
      <td></td>
      <td bgcolor = "#93FFB9"></td>
    </tr>
    <tr>
      <td>9:00PM</td>
      <td></td>
      <td></td>
      <td bgcolor = "#93FFB9"></td>
    </tr>
    <tr>
      <td>10:00PM</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>11:00PM</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </table>
</div>
</body>
</html>
