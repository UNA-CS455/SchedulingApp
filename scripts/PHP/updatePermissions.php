<?php
	
session_start();

if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page
if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}
	$currUser = $_POST['currUser'];
	$groupID = $_POST['groupID'];

	require "db_conf.php";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "UPDATE users SET groupID = $groupID WHERE email = '$currUser'";
	$conn->query($sql);
	if ($conn->affected_rows >= 0){
		$_SESSION['msg'] = "<p> User group changed. </p>";
	} else {
		$_SESSION['msg'] = "<p> failure $currUser $sql </p>";
	}
	header("location:userSettings.php");
	$conn->close();