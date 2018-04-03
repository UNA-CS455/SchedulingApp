<?php

	$email = $_POST['email'];
	$permissions = $_POST['permissions'];

	require "db_conf.php";
				
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "INSERT INTO users (email, permissions) VALUES ('$email', '$permissions')";
	$result = $conn->query($sql);
	
	if($result === false){
		echo "<br> failed";
	} else {
		echo "<br> success";
	}
	$conn->close();
