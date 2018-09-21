<?php session_start();
	
		

	if (!isset($_SESSION['username'])){
		header('location: ../../login.html');
}
//only admin can view this page
if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}

	$room = $_REQUEST['q'];
	require "db_conf.php"; // set servername,username,password,and dbname

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>

        <?php
        $sql = "SELECT * FROM reservations WHERE startdate >= CURDATE() AND (roomid='$room' ) order by startdate, starttime";
        $result = $conn->query($sql);
		//$return_array = array();
		echo "<table><tr><th>res_email</th><th>owner_email</th><th>Room Number</th><th>allow_share</th><th>head_count</th>
				<th>start_date</th><th>end_date</th><th>start_time</th><th>end_time</th><th>occur</th></tr>";
        while ($row = $result->fetch_assoc()) {
			echo "<tr><td>" . $row['res_email'] . "</td><td>" . $row['owneremail'] . "</td><td>" 
				. $row['roomnumber'] . "</td><td>" . $row['allowshare'] . "</td><td>" . $row['headcount'] . "</td><td>"
				. $row['startdate'] . "</td><td>" . $row['enddate'] . "</td><td>" . $row['starttime'] . "</td><td>"
				. $row['endtime'] . "</td><td>" . $row['occur'] . "</td>";
			/*$rowResult = array(
				"roomnumber" => $row['roomnumber'],
				"owneremail" => $row['owneremail'],
				"headcount" => $row['headcount'],
				"startdate" => $row['startdate'],
				"starttime" => date('h:i',strtotime($row['starttime'])),

				"enddate" => $row['enddate'],
				"endtime" => date('h:i',strtotime($row['endtime'])),
				"comment" => $row['comment'],
				"id" => $row['id'],
				
				"start" => date('A',strtotime($row['starttime'])),
				"end" => date('A',strtotime($row['endtime'])),
				"occur" => $row['occur'],
				#"repeat_id" => $row['repeat_id'],
				"allowshare" => $row['allowshare'],
				"res_email" => $row['res_email']
			);
			$return_array[] = $rowResult; // append row to result.*/
		}
        $conn->close();
		
		//echo json_encode($return_array); // return an array of reservations.
		
        ?>