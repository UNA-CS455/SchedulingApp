<?php
	session_start();
	$currRoom = $_POST['currRoom'];
	$roomid = $_POST['roomNumber'];
	$type = $_POST['type'];
	$floor = $_POST['floor'];
	$seats = $_POST['seats'];
	$numcomputers = $_POST['numcomputers'];
	if (trim($numcomputers) === ""){
		$numcomputers = 0;
	}

	require "db_conf.php";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "UPDATE rooms SET roomid = '$roomid', type = '$type', floor = $floor, seats = $seats,
	numcomputers = $numcomputers WHERE roomid = '$currRoom'";
	$conn->query($sql);
	if ($conn->affected_rows > 0){
		$_SESSION['msg'] = "<p> Successfully updated room</p>";
		$sql = "UPDATE reservations SET roomnumber = '$roomid' WHERE roomnumber = '$currRoom'";
		$conn->query($sql);
	}
	else
	{
		$_SESSION['msg'] = "<p> failure $sql </p>";
	}
	$conn->close();
	header("location:roomSettings.php");