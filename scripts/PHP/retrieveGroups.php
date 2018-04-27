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
		Retrieve Groups PHP Script
		Purpose: Fetches all groups in the database and returns HTML buttons
		that should go into a flexbox on the group settings page.

		Author: Derek Brown
		April 27 2018

	=========================================================================*/

	

	//obtain datbase metadata
    require "db_conf.php";

	//perform conneciton to database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
	

	$sql = "SELECT DISTINCT * FROM groups ";

    $result = $conn->query($sql); // run the query

	//get all rooms first
	$room_array = array();
	while ($rowItem = $result->fetch_assoc()) {

		echo "<button style='width:100%; height:40px; position:relative;' id = ".$rowItem['id']." onclick='populateBlacklistRooms(this.id)'>". $rowItem['name'] . "</button>";
		
	}
	//TODO: add modal popup for new group creation.
	echo "<button style='width:100%; height:40px; position:relative;' id = 'createNewGroupButton' onclick=''> Create New Group </button>";
	
$conn->close();

?>
