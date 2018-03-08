<?php

	$currRoom = $_POST['currRoom'];
	$roomid = $_POST['roomNumber'];
	$type = $_POST['type'];
	$floor = $_POST['floor'];
	$seats = $_POST['seats'];
	$hascomputers = $_POST['hascomputers'];
	$numcomputers = $_POST['numcomputers'];

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cs455";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "UPDATE rooms SET roomid = '$roomid', type = '$type', floor = $floor, seats = $seats, hascomputers = $hascomputers,
	numcomputers = $numcomputers WHERE roomid = '$currRoom'";
	$conn->query($sql);
	if ($conn->affected_rows > 0){
		echo "<p> success </p>";
		$sql = "UPDATE reservations SET roomnumber = '$roomid' WHERE roomnumber = '$currRoom'";
		$conn->query($sql);
	}
	else
	{
		echo "<p> failure </p>";
	}
	$conn->close();