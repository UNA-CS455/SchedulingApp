<?php session_start();
	if (!isset($_SESSION['username'])) {
		header("location:index.php");
		exit;
	}

	require "db_conf.php"; // set servername,username,password,and dbname

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


		$user = $_SESSION['username'];
	
        //$sql = "SELECT * FROM reservations WHERE concat(startdate,' 23:59:59') >= NOW() AND (owneremail = '$user' OR res_email = '$user') order by startdate, starttime";
		if (isset($_GET['id'])) {
			$idval = $_GET['id'];
			$stmt = $conn->prepare("SELECT * FROM reservations WHERE id =?");
			$stmt->bind_param("i", $idval);
		} else{
			$stmt = $conn->prepare("SELECT * FROM reservations WHERE concat(startdate,' 23:59:59') >= NOW() AND (owneremail =? OR res_email =?) order by startdate, starttime");	
			$stmt->bind_param("ss", $user, $user);			
		}

        //$result = $conn->query($sql);
		//$return_array = array();

    $stmt->execute();
		$mResult = $stmt->get_result();
		$return_array = [];
		while ($row = $mResult->fetch_assoc()){
			$rowResult = array(
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
			$return_array[] = $rowResult; // append row to result.
		}
/*
        while ($row = $result->fetch_assoc()) {
	
			$rowResult = array(
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
			$return_array[] = $rowResult; // append row to result.
		}*/
        $conn->close();
		
		echo json_encode($return_array); // return an array of reservations.
		
?>