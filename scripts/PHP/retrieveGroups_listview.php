<?php session_start();

	

if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page
if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}
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
	echo "<td><select name='groupID'>";
	while ($rowItem = $result->fetch_assoc()) {

		echo "<option value='" . $rowItem['id'] . "'>" . $rowItem['name'] . "</option>";
		
	}
	echo "</select></td></tr>";

$conn->close();

?>
