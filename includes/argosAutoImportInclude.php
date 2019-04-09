<link rel="shortcut icon" type="image/x-icon" href="../../favicon.ico">
<link rel="stylesheet" href="../../styles/rooms.css">
<link rel="stylesheet" href="../../styles/popup.css">

<title>ARGOS Classes</title>
<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <!--    <div class="modal-content">
              <div class="modal-content-header">
                  <h1 style="color:white; left:3%;" id="modal-header-text"></h1> <span class="close">×</span></div>
              <p class="modal-content-text" id="modalMessage">Enter text</p>
              <p class="modal-center-text" id="buttonContent"></p>
            </div> -->
</div>
<div id="shader" onclick="shaderClicked()"></div>
<script src="../JS/popup.js"></script>
<script src="../JS/rooms.js"></script>
<div class="container" id="room">

  <br />

  <h1>Class Reservations</h1>
  <br/>
  <br />
  <br />
  
  <h4>Sort by:</h4>
  <input type="radio" name="sortBy" id="sortBy" value="room" > Room   
  <input type="radio" name="sortBy" id="sortBy" value="class"> Class
  
  
  <div class="row reservationsTable"
    style="display: block; max-height: 400px; overflow-y: auto;">
    <div class="col-md-9" id="sortByRoom">
      <table class="table table-responsive">
        <thead>
          <th>Class Title</th>
          <th>Room Number</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Actions</th>
        </thead>
        <tbody>
          <?php
            while($reservation = $autoImportRoomNumSortRes->fetch_assoc())
            {
              echo '<tr>';
              echo '<td style="display: none;" hidden>' . $reservation['id'] . '</td>';
            //   echo '<td>' . $reservation['owneremail'] . '</td>';
              echo '<td>' . "CLASS NUMBER" . '</td>';
              echo '<td>' . $reservation['roomnumber'] . '</td>';
              echo '<td>' . $reservation['startdate'] . '</td>';
              echo '<td>' . $reservation['enddate'] . '</td>';
              echo '<td>' . $reservation['starttime'] . '</td>';
              echo '<td>' . $reservation['endtime'] . '</td>';
              echo '<td>';
              echo '<a style="margin-right: 5px;" class="btn btn-default" href="reservationEdit.php?id=' . $reservation['id'] . '"><i class="fas fa-pencil-alt"></i></a>';
              echo '<a style="margin-right: 5px;" class="btn btn-default" href="room_remove.php?id=' . $reservation['id'] . '"><i class="fas fa-trash-alt"></i></a>';
              echo '</td></tr>';
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  
  
  <!--<div class="row reservationsTable"
    style="display: block; max-height: 400px; overflow-y: auto;">
    <div class="col-md-9" id="sortByClass">
      <table class="table table-responsive">
        <thead>
          <th>Class Title</th>
          <th>Room Number</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Actions</th>
        </thead>
        <tbody>
          <?php
            // while($reservation = $autoImportClassNumSortRes->fetch_assoc())
            // {
            //   echo '<tr>';
            //   echo '<td style="display: none;" hidden>' . $reservation['id'] . '</td>';
            // //   echo '<td>' . $reservation['owneremail'] . '</td>';
            //   echo '<td>' . "CLASS NUMBER" . '</td>';
            //   echo '<td>' . $reservation['roomnumber'] . '</td>';
            //   echo '<td>' . $reservation['startdate'] . '</td>';
            //   echo '<td>' . $reservation['enddate'] . '</td>';
            //   echo '<td>' . $reservation['starttime'] . '</td>';
            //   echo '<td>' . $reservation['endtime'] . '</td>';
            //   echo '<td>';
            //   echo '<a style="margin-right: 5px;" class="btn btn-default" href="reservationEdit.php?id=' . $reservation['id'] . '"><i class="fas fa-pencil-alt"></i></a>';
            //   echo '<a style="margin-right: 5px;" class="btn btn-default" href="room_remove.php?id=' . $reservation['id'] . '"><i class="fas fa-trash-alt"></i></a>';
            //   echo '</td></tr>';
            // }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  
  -->
  
  
</div>

<script>
 var sortByClassElem = document.getElementById('sortBy');

	sortByClassElem.addEventListener('RadioStateChange', function() {
    	if(document.getElementById("sortBy").value == "room"){
    	    alert("Sort by room");
    	    alert(document.getElementById("sortBy").value);
    	} 
    	else{
    	    alert("Sort by class");
    	    alert(document.getElementById("sortBy").value);
    	}
    	
	}, false);
	
	alert("Change!");
  

</script>
