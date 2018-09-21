<?php session_start();


if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page
if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}

	$user= $_SESSION['username'];

	/*=========================================================================
		Update Blacklisted Rooms PHP Script
		Purpose: Given three POST variables:
			1. groupID - the particular permissions group you want to edit
			2. roomid - the room to add or remove
			3. operation - a string representing the operation to perform
							on the room and group. If 'add', then we add this
							room to the blacklists table for the given groupID
							else we remove.

		Author: Derek Brown
		Date: 4/27/2018


	=========================================================================*/
require 'db_conf.php';
$groupID = (isset($_POST['groupID'])) ? $_POST['groupID'] : null; 
$selectedRoom = (isset($_POST['roomid'])) ? $_POST['roomid'] : null; 
//TODO: clean up above vars
echo $_POST['operation'];
if ($_POST['operation'] === "'add'"){
	// add to the blacklist
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "INSERT INTO blacklist (group_id, numeric_room_id)
	VALUES ('$groupID','$selectedRoom')";

	if ($conn->query($sql) != TRUE) {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
}
else{
	// remove one.
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	// sql to delete a record
	$sql = "DELETE FROM blacklist WHERE group_id='$groupID' AND numeric_room_id='$selectedRoom' LIMIT 1";

	if ($conn->query($sql) != TRUE) {
		echo "Error deleting record: " . $conn->error;
	}

	$conn->close();
}

?>