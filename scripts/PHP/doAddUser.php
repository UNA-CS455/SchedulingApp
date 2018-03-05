<?php

	$email = $_POST['email'];
	$first = $_POST['first'];
	$last = $_POST['last'];
	$role = $_POST['role'];
	$permissions = $_POST['permissions'];

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cs455";
				
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "INSERT INTO users (email, firstname, lastname, classification, permissions) VALUES ('$email', '$first', '$last', '$role', '$permissions')";
	$result = $conn->query($sql);
	
	if($result === false){
		echo "<br> failed";
	} else {
		echo "<br> success";
	}
	$conn->close();
