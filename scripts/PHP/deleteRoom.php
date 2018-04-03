<?php
	$room = $_POST['room'];
	require "db_conf.php";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "DELETE FROM rooms WHERE roomnumber='$room' LIMIT 1";
	if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
		} else {
			echo "Error deleting record: " . $conn->error;
		}

    $conn->close();