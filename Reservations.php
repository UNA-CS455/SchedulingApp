<?php session_start();
    //$_SESSION['logged_in_useremail'];
    //$roomnumber = $_POST['roomnumber'];
    //$day = $_POST['day'];
    //$month = $_POST['month'];
?>

<div class="dayview">

</div>

<div class="makeReservation">
  <div class="test">
  <h1>Make Reservation</h1>
    Reserving email*:
    <input type="text" id="owneremail"><br>

    <p>Duration*:</p>
    Start time:<br>
    <input type="text" id="startHour" style="width: 48px">
    <input type="text" id="startMinute" style="width: 48px">
    <select>
    <option value="startAM">AM</option>
    <option value="startPM">PM</option>
    <input type="date" id="startDate" placeholder="2018/01/26" required/><br>
  </select><br>

    End time:<br>
    <input type="text" id="endHour" style="width: 48px">
    <input type="text" id="endMinute" style="width: 48px">
    <select>
    <option value="endAM">AM</option>
    <option value="endPM">PM</option>
    </select>
    <input type="date" id="endDate" placeholder="2018/01/26" required/><br>
	<br>
    Recurring:
    <select>
    <option value="Once">Just Once</option>
    <option value="Weekly">Weekly</option>
    <option value="Monthly">Monthly</option>
  </select><br><br>

    <input type="checkbox" id="allowshare" value="true">Allow room sharing<br><br>

    Expected number of seats needed:
    <input type="text" id="numberOfSeats" style="width: 48px"><br><br>

    <!-- add css for this boi -->
    Comments<br>
    <textarea rows="10" cols="50" id="comment">
    </textarea><br><br><br><br><br><br><br><br><br><br>

    <button id="submitMakeRes">Make reservation</button>
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
