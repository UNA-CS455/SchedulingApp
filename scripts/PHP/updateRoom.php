<?php
	session_start();
	

if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page
if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}
	$currRoom = $_POST['currRoom'];
	$roomid = $_POST['roomNumber'];
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

	$sql = "UPDATE rooms SET roomid = '$roomid', type = '$type', floor = $floor, seats = $seats WHERE roomid = '$currRoom'";
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