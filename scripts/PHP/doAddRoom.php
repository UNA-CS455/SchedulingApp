<?php
	session_start();

if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page
if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}
	$roomid = $_POST['roomid'];
	$type = $_POST['type'];
	$floor = $_POST['floor'];
	$seats = $_POST['seats'];
	if (trim($numcomputers) === ""){
		$numcomputers = 0;
	}

	require "db_conf.php";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	//$sql = "INSERT INTO rooms (roomid, type, floor, seats) VALUES ('$roomid', '$type', '$floor', '$seats')";
	$stmt = $conn->prepare("INSERT INTO rooms (roomid, type, floor, seats) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("ssii", $roomid, $type, $floor, $seats);
	$check = $stmt->execute();
	/*
	$conn->query($sql);
	if ($conn->affected_rows > 0){
		$_SESSION['msg'] = "<p> Successfully added room.</p>";
	}
	else
	{
		$_SESSION['msg'] = "<p> failure $sql </p>";
	}*/
	if ($check){
		$_SESSION['msg'] = "<p> Successfully added room.</p>";
	}
	else{
		$_SESSION['msg'] = "<p> failure $sql </p>";
	}
	$conn->close();
	header("location:roomSettings.php");