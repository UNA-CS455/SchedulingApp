<!DOCTYPE html>
<html lang="en">

<head>
  <title>ORS</title>	
  <meta charset="utf-8">
  <link rel="stylesheet" href="frontEnd.css">
</head>

<body>
  <div id="page-wrap">
  <div id="contact-area">
<table style="width:100%">
<h1><?php 
  
    echo $_POST["date"]; 
  ?></h1>
<h1><?php 
      echo $_POST["room"]; 
  ?></h1>
  <div style = "overflow-x:auto;">
  <tr>
    <td class="time">6:00 AM</td>
	<td id="6AMBlock"></td>
  </tr>
  <tr>
    <td class="time">7:00 AM</td>
	<td id="7AMBlock"></td>
  </tr>
  <tr>
    <td class="time">8:00 AM</td>
	<td id="8AMBlock"></td>
  </tr>
  <tr>
    <td class="time">9:00 AM</td>
	<td id="9AMBlock"></td>
  </tr>
  <tr>
    <td class="time">10:00 AM</td>
	<td id="10AMBlock"></td>
  </tr>
  <tr>
    <td class="time">11:00 AM</td>
	<td id="11AMBlock"></td>
  </tr>
  <tr>
    <td class="time">12:00 PM</td>
	<td id="12PMBlock"></td>
  </tr>
  <tr>
    <td class="time">1:00 PM</td>
	<td id="1PMBlock"></td>
  </tr>
  <tr>
    <td class="time">2:00 PM</td>
	<td id="2PMBlock"></td>
  </tr>
  <tr>
    <td class="time">3:00 PM</td>
	<td id="3PMBlock"></td>
  </tr>
  <tr>
    <td class="time">4:00 PM</td>
	<td id="4PMBlock"></td>
  </tr>
  <tr>
    <td class="time">5:00 PM</td>
	<td id="5PMBlock"></td>
  </tr>
  <tr>
    <td class="time">6:00 PM</td>
	<td id="6PMBlock"></td>
  </tr>
  <tr>
    <td class="time">7:00 PM</td>
	<td id="7PMBlock"></td>
  </tr>
  <tr>
    <td class="time">8:00 PM</td>
	<td id="8PMBlock"></td>
  </tr>
  </div>
</table>
</div>
</div>
</body>
</html>