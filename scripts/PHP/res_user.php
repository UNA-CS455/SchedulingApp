<?php session_start();
	/*if (!isset($_SESSION['username'])) {
		header("location:index.php");
		exit;
	}*/

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cs455";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>

        <?php
        $sql = "SELECT * FROM reservations order by roomnumber";
        $result = $conn->query($sql);
		$return_array = array();
        while ($row = $result->fetch_assoc()) {
	
			$rowResult = array(
				"roomnumber" => $row['roomnumber'],
				"owneremail" => $row['owneremail'],
				"headcount" => $row['headcount'],
				"start" => $row['start'],
				"end" => $row['end'],
				"comment" => $row['comment'],
				"id" => $row['id'],
				"repeat_id" => $row['repeat_id'],
				"allowshare" => $row['allowshare'],
				"res_email" => $row['res_email']
			);
			$return_array[] = $rowResult; // append row to result.
		}
        $conn->close();
		
		echo json_encode($return_array); // return an array of reservations.
		
        ?>