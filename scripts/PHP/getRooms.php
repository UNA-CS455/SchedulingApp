<?php
	session_start();

if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page
if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}
	
	$room = $_REQUEST["q"];
	require "db_conf.php";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$room = $conn->real_escape_string($room);
	$sql = "SELECT * FROM rooms WHERE roomid LIKE '$room%'";
	$result = $conn->query($sql);
	
	if ($result->num_rows === 1){
		$row = $result->fetch_assoc();
		$room = $row['roomid'];


    ?>
    <form action="updateRoom.php" method="POST">
      <div class='row'>
        <div class='col-md-1 col-sm-1 col-xs-1'>
          <label for='currentRoom'>
            Current Room
          </label>
          <input type='text' name="currRoom" class='form-control' <?php echo "value='". $row['roomid'] ." '";?> readonly>
        </div>
        <div class='col-md-1 col-sm-1 col-xs-1'>
          <label for='newRoom' style='font-size: 15.2px; font-weight: bold; padding-bottom: 1px;'>
            New Room Number
          </label>
          <input type='text' name='newRoom' class='form-control' <?php echo "value='". $row['roomid'] ." ' "; ?> hidden='hidden' disabled='disabled'>
        </div>
      </div>
      <br/>
      <div class='row'>
        <div class='col-md-2 col-sm-2 col-xs-2'>
          <label for='type'>
            Type
          </label>
          <select id='type' name='type' class='form-control'>
            <option value="Classroom" <?php echo ($row['type'] == "Classroom") ? 'selected = "selected"' : '';?>>Classroom</option>
            <option value="Conference Room" <?php echo ($row['type'] == "Conference Room") ? 'selected = "selected"' : '';?>>Conference Room</option>
            <option value="Computer Lab" <?php echo ($row['type'] == "Computer Lab") ? 'selected = "selected"' : '';?>>Computer Lab</option>
          </select>
        </div>
      </div>
      <br/>
      <div class='row'>
        <div class='col-md-1 col-sm-1 col-xs-1'>
           <label for='floorName' style='font-size: 15.2px;'>
            New Floor Number
           </label>
          <input class='form-control' type='text' name='floor' <?php echo "value='". $row['floor'] ." ' "; ?>>
        </div>
        <div class='col-md-1 col-sm-1 col-xs-1'>
          <label for='floorName'>
            Seats
          </label>
          <input class='form-control' type='text' name='seats' <?php echo "value='". $row['seats'] ." ' "; ?>>
        </div>
      </div>
      <br/>
      <div class='row'>
        <div class='col-md-2 col-sm-2 col-xs-2'>
          <button type='submit' class='btn btn-primary' style='width: 100%;'>
            Submit Changes
          </button>
        </div>
      </div>
    </form>
		<!-- added to create space from room settings search bar
		ADD THIS AND STYLE TO YOUR LIKING 
		echo "<form action='updateRoom.php' METHOD='POST'>
      <div class='row'>
        <div class='col-md-1 col-sm-1 col-xs-1'>
          <label for='currentRoom'>
            Current Room
          </label>
          <input type='text' class='form-control' value='". $row['roomid'] ." ' disabled='disabled'>
        </div>
        <div class='col-md-1 col-sm-1 col-xs-1'>
          <label for='currentRoom' style='font-size: 15.2px; font-weight: bold; padding-bottom: 1px;'>
            New Room Number
          </label>
          <input type='text' name='currRoom' class='form-control' value='". $row['roomid'] ." ' hidden='hidden'>
        </div>
      </div>
      <br/>
      <div class='row'>
        <div class='col-md-2 col-sm-2 col-xs-2'>
          <label for='type'>
            Type
          </label>
          <select id='type' name='type' class='form-control'>";
            if ($row['type'] == "Classroom"){
              echo "<option value='Classroom' selected='selected' >Classroom</option>
                    <option value='Conference'>Conference Room</option>
                    <option value='Computer Lab'>Computer Lab</option>
                    </select>";
        } else if ($row['type'] == "Computer Lab"){
          echo "<option value='Classroom' >Classroom</option>
            <option value='Conference'>Conference Room</option>
            <option value='Computer Lab' selected='selected'>Computer Lab</option>
            </select>";
        } else {
          echo "<option value='Classroom' >Classroom</option>
            <option value='Conference' selected='selected'>Conference Room</option>
            <option value='Computer Lab'>Computer Lab</option>
            </select>";
        }
        echo"</div></div><br/>";
        echo"<div class='row'>
          <div class='col-md-1 col-sm-1 col-xs-1'>
            <label for='floorName' style='font-size: 15.2px;'>
              New Floor Number
            </label>
            <input class='form-control' type='text' name='floor' value='" .$row['floor']. "'>
          </div>
          <div class='col-md-1 col-sm-1 col-xs-1'>
            <label for='floorName'>
              Seats
            </label>
            <input class='form-control' type='text' name='seats' value='" .$row['seats']. "'>
          </div>
        </div>
        <br/>
        <div class='row'>
          <div class='col-md-2 col-sm-2 col-xs-2'>
            <button type='submit' class='btn btn-primary' style='width: 100%;'>
              Submit Changes
            </button>
          </div>
        </div>
        </div>
      </div>
    </form>
    <br/>"; -->

<?php
		// ADD THIS FOR STYLING 
		
		$sql = "SELECT * FROM reservations WHERE startdate >= CURDATE() AND roomnumber='$room' order by startdate, starttime";
        $result = $conn->query($sql);
		echo "<h1> <br> Current Bookings <br></h1>";

		if ($result->num_rows < 1){
			echo "There are no current bookings for this room";
		}
	    else{
			echo "<table><tr><th>Reserving Email</th><th>Owner Email</th><th>Room Number</th><th>Sharing Allowed</th><th>Head Count</th>
				<th>Start Date</th><th>End Date</th><th>Start Time</th><th>End Time</th><th>Occurrence</th></tr>";
		
			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>" . $row['res_email'] . "</td><td>" . $row['owneremail'] . "</td><td>" 
					. $row['roomnumber'] . "</td><td>" . $row['allowshare'] . "</td><td>" . $row['headcount'] . "</td><td>"
					. $row['startdate'] . "</td><td>" . $row['enddate'] . "</td><td>" . $row['starttime'] . "</td><td>"
					. $row['endtime'] . "</td><td>" . $row['occur'] . "</td>";
				echo "<td><form action=room_remove_rs.php METHOD='POST'>";
				echo "<input type='text' value='" . $row['id'] . "' name='id' hidden>";
				echo "<input type='submit' value='Delete'>";
				echo "</form></td></tr>";
			}

		}
	}
	else if ($result->num_rows > 1) 
	{
		echo "<br>Continue entering room name or click below to add this room.";
		echo "<form action='addRoom.php' method='POST'>";
		echo "<input type='text' value='$room' name='roomid' hidden>";
		echo "<input type='submit' value='Add Room'>";
	}
	else {
		echo "<br>Error: No room matching current name. Click below to add a room with this name.";
		echo "<form action='addRoom.php' method='POST'>";
		echo "<input type='text' value='$room' name='roomid' hidden>";
		echo "<input type='submit' value='Add Room'>";
	}
	$conn->close();
	
?>