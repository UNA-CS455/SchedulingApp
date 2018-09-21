<?php session_start();?>

<form class="test" onsubmit='openConfirmCreate(); return false;'>

  
  
  <h1>Make Reservation</h1>

  Reserving For*:
    <?php 
      if (isset($_SESSION['username'])) {
        $logged_in_user = $_SESSION['username']; //used for default in reserving email field.
        echo "<input type='email' id='owneremail' value='$logged_in_user' required><br>";
      }
    ?>
  <!--<div id="filterArea"> -->
  <!--<font id="typeText">-->
  <br>Type: <!--</font> -->
    <select id="typeSelect" onchange="fieldChanged()">
      <option value="Any">Any</option>
      <option value="Classroom">Classroom</option>
      <option value="Conference">Conference Room</option>
      <option value="Computer Lab">Computer Lab</option>
    </select>
  <!--</div> -->

  <p>Duration*:</p>
    Date:
    <input id = 'date' name = 'date' type = 'date' onchange = "fieldChanged()" value=<?php echo date('Y-m-d'); ?>> <button type='button' onclick='showDayViewModal(document.getElementById("date").value, roomSelected);'>Check</button><br><br>
    Start time:
    <input id = "timeStart"  name = "startTime "type = "time" step = "900" width = "48" onchange = "fieldChanged()" required><br><br>

    End time: 
    <input id = "timeEnd" name = "endTime" type = "time" step = "900" width = "48" onchange = "fieldChanged()" required><br><br>

  Recurring:
    <select id="occur">
      <option value="Once">Just Once</option>
      <option value="Weekly">Weekly</option>
      <option value="Monthly">Monthly</option>
    </select><br><br>

  <input type="checkbox" onclick="changeSheet(); fieldChanged();" id="allowshare">Allow room sharing<br><br>

  <span id="numseatstext" style="visibility:hidden"> Expected number of seats needed: <input type="text" id="numberOfSeats" style="width: 48px;" onchange = "fieldChanged()"></span> <br><br>

  Comments:<br>
    <textarea rows="4" cols="50" id="comment" style="resize:none; width:55%"></textarea><br>
  <br>
  <input type="checkbox" id="confirmEmailCheck">Send me a Confirmation email</input><br><br>
  <input id="reserveButton" type="submit" value="Reserve">
  <!-- <button onclick="openConfirmCreate()">Make reservation</button><br><br> -->
  <br>
  <font id="responseText"></font>
</form>