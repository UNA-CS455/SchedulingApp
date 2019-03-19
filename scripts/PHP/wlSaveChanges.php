<?php session_start();

require "db_conf.php";
$conn = new mysqli ( $servername, $username, $password, $dbname ) or die( "Connection failed: " . $conn->connect_error );


    $roomid = $_POST ['roomid']; // All of these are columns in the `rooms` table in our database
	$type = $_POST ['roomType']; // We pass all of them in from limitUsers.js
	$floor = $_POST ['floorNum'];
	$seats = ( int ) $_POST ['seats'];
	$numComputers = ( int ) $_POST ['numComputers'];
	$hasComputers = $_POST['hasComputers'];
	$limit = $_POST['limit'];
	$beingEdited = $_POST['beingEdited'];
	

	if ($beingEdited == 1){ // If we are editing the room
		$_updateSql = "UPDATE `rooms` SET `rooms`.`type` = '$type', `rooms`.`floor` = '$floor', `rooms`.`seats` = '$seats', `rooms`.`hascomputers` = '$hasComputers',
			`rooms`.`numcomputers` = '$numComputers', `rooms`.`limit` = '$limit' WHERE `rooms`.`roomid` = '$roomid'";

		$conn->query ( $_updateSql ) or die($conn->error);
	} 
	else{ // If we are creating the room
		$_createSql = "INSERT INTO `rooms` (`roomid`, `type`, `floor`, `seats`, `hascomputers`, `numcomputers`, `limit`) VALUES ('$roomid', '$type', '$floor', '$seats', '$hasComputers', '$numComputers', '$limit')";
		$conn->query ( $_createSql );
	}


if(!empty($conn->error)){ // If there was an error that has occurred, kill the connection and give an error
    die($conn->error);
}

$conn->close();
?>