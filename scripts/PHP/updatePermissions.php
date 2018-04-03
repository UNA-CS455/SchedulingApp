<?php
	
	$currUser = $_POST['currUser'];
	$user = $_POST['userEmail'];
	$first = $_POST['first'];
	$last = $_POST['last'];
	$role = $_POST['role'];
	$permissions = $_POST['permissions'];

	require "db_conf.php";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "UPDATE users SET permissions = '$permissions' WHERE email = '$currUser'";
	$conn->query($sql);
	if ($conn->affected_rows > 0){
		echo "<p> success </p>";
	}
	else
	{
		echo "<p> failure </p>";
	}
	$conn->close();