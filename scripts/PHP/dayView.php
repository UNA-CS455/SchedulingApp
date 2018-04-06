<?php session_start();
/**************************************************************************
Retrive Day View Script

Description: A php script that will accept GET requests containing parameters
'date', which is a string YYYY-MM-DD and 'room' which is a string representing
the room to query on (for example Keller 333, as it appears in the rooms table)
The script produces a table of the given room and the bookings it has from
$dayStart to $dayEnd on the date given in the GET request. 

Authors: Derek Brown, Matthew Foster
March 2018
**************************************************************************/
    $date = $_GET['date'];
	$selectedRoom = $_GET['room'];
	$dayStart = 7;
	$dayEnd = 22;

	if($date == null || $selectedRoom == null || $date == "null" || $selectedRoom == "null"){
		echo "<h1>Please select a date and a room to check its availability.</h1>";
		return;
	}
	//Script to fill in the table with reservations
	require 'db_conf.php';

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = " SELECT * FROM reservations WHERE startdate='$date' AND roomnumber= '$selectedRoom' ORDER BY starttime";
	$results = $conn->query($sql);

	$res = array();
	

	while ($row = $results->fetch_assoc()) {

	$rowResult = array(
				"owneremail" => $row['owneremail'],
				"headcount" => $row['headcount'],
				"startdate" => $row['startdate'],
				"starthour" => date('H',strtotime($row['starttime'])),
				"endhour" => date('H',strtotime($row['endtime'])),
				"start_to_end_str" => date('g:i',strtotime($row['starttime'])) . "-" . date('g:i',strtotime($row['endtime'])),
				"comment" => $row['comment'],
				"id" => $row['id'],
				"allowshare" => $row['allowshare'],
				"res_email" => $row['res_email'],
				"columnPOS" => 0,
				"length" => date('H',strtotime($row['endtime'])) - date('H',strtotime($row['starttime'])),
				"color" => "#d1ebff"
			);
			$res[] = $rowResult; // append row to result.
	}

	if(count($res) > 0){
		echo "<table style='width:100%'>";
	} else{
		echo "<h1> There are currently no active reservations for $selectedRoom on $date.</h1>";
		return;
	}
	//table vector
	$table = array();
	$durationOfDay = $dayEnd - $dayStart;
	$blankCol= array();
	for($i = 0; $i <= $durationOfDay; $i++){
		$blankCol[] = -1;
	}
	$table[] = $blankCol;
	$labelID = array();
	$colors = array("#d1ebff","#d7ffd1","#fff5d1", "#ffd1d1", "#edd1ff" , "#f4ffd1", "#ffd1d1", "#d1ffd2", "#d1fff8");

	/*
		$resColumnArr is an array of arrays. Each array in the array represents a column, and within that array are index values representing the reservation from
		$res array. We should run through all of these to check each reservation for collisions.
		$resColumnArr:
		Given $i is the index for $resColumnArray, we can see the arrays for each index in an example:
		$i =  0    1    2
			[[X]][[A]][[B]]
			[[Y]]	  [[C]]
		Each $i is a column in the table, and more columns are added as the below loop executes.
		X,Y,A,B, and C are numbers representing the index for a reservation within that column, with the index mapping to the respective reservation object in the $res array
		that is defined above.
		So, if we want to place the next reservation in our $res array, we check each $i in $resColumnArray. So we would make sure no overlap occurs with $res[X] or $res[Y]. If so, we 
		continue to the next $i. If we run out of columns to check, ie the new reservation we are placing runs into B and C, then we simply add a new column and continue.
	
	*/
	include "ValidateReservation.php";
	$resColumnArr = array();
	$resColumnArr[] = array(0); // the first reservation will go in the first column $resColumnArr[0], so add it to the array.
	for($i = 0; $i <= count($blankCol)-1; $i++ ){
		$labelID[] = $i;
	}
	
	if(count($res) > 0){
		// handle initial reservation
		for($rowPlacementCounter = (int)$res[0]['starthour'] - 7; $rowPlacementCounter <= (int)$res[0]['endhour'] - 7;$rowPlacementCounter++){
			$table[0][$rowPlacementCounter] = 0;
		}

		//iterate through reservations
		for($resCounter = 1; $resCounter < count($res); $resCounter++){
			//check if the current start hour or end hour falls in between the previous reservation's start and end hour or if it overlaps
				$columnToPlaceIn = -1;
				$isOverlapping = true;
				for($i = 0; $i < count($resColumnArr); $i++){
					for($j = 0; $j < count($resColumnArr[$i]); $j++){
						if(!($res[(int)$resCounter]['starthour'] <= $resColumnArr[$i][$j]['endhour'])){
							//the current reservation we are looking at to place is not overlapping with the one in this column, so place it in this column
							break;
							$isOverlapping = false;
						}
						$columnToPlaceIn = $j;
					}
				}
				if($isOverlapping){
					// all columns are full, so add a new column in the table
					$table[] = $blankCol;
					$columnToPlaceIn = count($table) - 1; // place in the newest column.
				}
				$res[$resCounter]['columnPOS'] = $columnToPlaceIn; // column set


			// We now place the reservation into the table.
			for($rowPlacementCounter = (int)$res[$resCounter]['starthour'] - 7; $rowPlacementCounter <= (int)$res[$resCounter]['endhour'] - 7; $rowPlacementCounter++){
				$table[$res[$resCounter]['columnPOS']][$rowPlacementCounter] = $resCounter; // change the index value of the table cell.
			}
			// we need to add it to the column array
			$resColumnArr[$res[$resCounter]['columnPOS']] = $resCounter;

			// add a color
			$res[$resCounter]['color'] = $colors[$resCounter % count($colors)];
		}

		$sql = "SELECT seats FROM rooms WHERE roomid='$selectedRoom' LIMIT 1";
		$roomresult = $conn->query($sql);
		$row = $results->fetch_assoc();
		$numSeats = 0;
		if(count($row) > 0){
			$numSeats = $row['seats'];
		}

		//the table is now full
		$labelMaintainCount = 0;
		for($row = 0; $row < count($blankCol); $row++){	
			echo "<tr>";	
			$timeBlock = (($row+7)>12) ? (($row+7)-12): ($row+7); // set time digits
			$timeColor = (checkValidTime(false,$row+7 . ":00" , $row+8 . ":00", $selectedRoom)) ? "bgcolor = '#e9ffe2'" : "bgcolor = '#ff8282'";
			echo "<td " . $timeColor .">" . $timeBlock . ":00</td>";
			for($col = 0; $col < count($table); $col++){
				echo "<td";
				if($table[$col][$row]== -1){
					echo "> ";

				}
				else
				{

					$newColor = $res[$table[$col][$row]]['color'];
					echo " bgcolor ='$newColor'>";
					if($table[$col][$row] == $labelID[$labelMaintainCount]){
						$labelMaintainCount++;
						
						echo $res[$table[$col][$row]]['start_to_end_str'] . " [will share]";
					}
				}
				
				echo " </td>";
			}
			echo "</tr>";
		}
	}


	?>

  </table>
