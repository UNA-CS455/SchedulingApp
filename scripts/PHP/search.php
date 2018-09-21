<?php

	session_start();

if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page
if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}
	$user = $_REQUEST['q'];
	require "db_conf.php";
				
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM users WHERE email LIKE '$user%'";
	$result = $conn->query($sql);
	
	$return_array = array();
	while ($row = $result->fetch_assoc()) {
		$rowResult = array(
		"firstname" => $row['firstname'],
		"lastname" => $row['lastname'],
		"email" => $row['email'],
		"role" => $row['classification']
	);
	$return_array[] = $rowResult; // append row to result.
}
$conn->close();

echo json_encode($return_array);