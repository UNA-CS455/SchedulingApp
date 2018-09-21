<?php
	session_start();

if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page
if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}
	$email = $_POST['email'];
	$permissions = $_POST['permissions'];

	require "db_conf.php";
				
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	//$sql = "INSERT INTO users (email, permissions) VALUES ('$email', '$permissions')";
	$stmt = $conn->prepare("INSERT INTO users (email, classification) VALUES (?, ?)");
	//$result = $conn->query($sql);
	$stmt->bind_param("ss", $email, $permissions);
	$check = $stmt->execute()
	
	if($check === false){
		echo "<br> failed";
	} else {
		echo "<br> success";
	}
	$conn->close();
