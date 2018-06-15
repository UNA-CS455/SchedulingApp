<?php session_start();?>

<form class="test" onsubmit='openConfirmCreate(); return false;'>
  <h2>
    Make Reservation
  </h2>
  <div class="form-row">
    <div class="form-group col-md-5 col-sm-5 col-xs-5">
      <label>
        Reserving For
      </label>
      <?php 
        if (isset($_SESSION['username'])) {
          $logged_in_user = $_SESSION['username']; //used for default in reserving email field.
          echo "<input class='form-control' type='email' id='owneremail' value='$logged_in_user' required>";
        }
      ?>
    </div><!-- end form row -->
      <div class="form-group col-md-5 col-sm-5 col-xs-5">
        <label>
          Type
        </label>
        <select class="form-control" id="typeSelect" onchange="fieldChanged()">
          <option value="Any">Any</option>
          <option value="Classroom">Classroom</option>
          <option value="Conference">Conference Room</option>
          <option value="Computer Lab">Computer Lab</option>
        </select> 
      </div> 
    </div>
    <div class="form-row">
      <div class="form-group col-md-3 col-sm-3 col-xs-3">
        <label>
          Duration
        </label>
        <input class="form-control" id = 'date' name = 'date' type = 'date' onchange = "fieldChanged()" value=<?php echo date('Y-m-d'); ?>>
      </div>
      <div class="form-group col-md-1 col-sm-1 col-xs-1">
        <button style="position: relative; top: 27.5px; right: 25px" class="btn btn-primary" type='button' onclick='showDayViewModal(document.getElementById("date").value, roomSelected);'>Check</button>
      </div>
      <div class="form-group col-md-3 col-sm-3 col-xs-3">
        <label>
          Start Time
        </label>
        <input class="form-control" id = "timeStart"  name = "startTime "type = "time" step = "900" width = "48" onchange = "fieldChanged()" required>
      </div>
      <div class="form-group col-md-3 col-sm-3 col-xs-3">
        <label>
          End Time
        </label> 
        <input class="form-control" id = "timeEnd" name = "endTime" type = "time" step = "900" width = "48" onchange = "fieldChanged()" required>
      </div>
    </div><!-- End form row -->
    <div class="form-row">
      <div class="form-group col-md-3 col-sm-3 col-xs-3">
        <label>
          Recurring
        </label>
        <select class="form-control" id="occur">
          <option value="Once">Just Once</option>
          <option value="Weekly">Weekly</option>
          <option value="Monthly">Monthly</option>
        </select>
      </div>
      <div style="position: relative; top: 34.5px;" class="form-group col-md-3 col-ms-3 col-xs-3">
        <input type="checkbox" onclick="changeSheet(); fieldChanged();" id="allowshare">
        <label>
          Allow room sharing
        </label>
      </div>
      <div class="form-group col-md-3 col-sm-3 col-xs-3">
         <span id="numseatstext" style="visibility:hidden">
          <label><h5>Expected number of seats needed<h5></label><input class="form-control" type="text" id="numberOfSeats" style="width: 48px;" onchange = "fieldChanged()"></span>
      </div>
    </div><!-- end form row -->
    <div class="form-row">
      <div class="form-group col-md-10 col-sm-10-col-xs-10">
        <label>
          Comments
        </label>
        <textarea class="form-control" rows="4" cols="50" id="comment" style="resize:none; width:55%"></textarea>
      </div>
    </div><!-- end form row -->
    <div class="form-row">
      <div class="form-group col-md-10 col-sm-10 col-xs-10">
        <input type="checkbox" id="confimeEmailCheck">
        <label>Send me a Confimation email</label>
      </div>
    </div><!-- end form row -->
    <div class="form-row">
      <div class="form-group col-md-4 col-sm-4 col-xs-4">
        <input class="btn btn-primary" id="reserveButton" type="submit" value="Reserve">
      </div>
    </div>
  </div>
</form>