<?php session_start();

require "db_conf.php";
$conn = new mysqli ( $servername, $username, $password, $dbname ) or die( "Connection failed: " . $conn->connect_error );


    $roomid = $_POST ['roomid'];
	$type = $_POST ['roomType'];
	$floor = $_POST ['floorNum'];
	$seats = ( int ) $_POST ['seats'];
	$numComputers = ( int ) $_POST ['numComputers'];
	$hasComputers = $_POST['hasComputers'];
	$limit = $_POST['limit'];
	$beingEdited = $_POST['beingEdited'];
	
	echo var_dump($_POST);


	if ($beingEdited == 1)
	{
		$_updateSql = "UPDATE `rooms` SET `rooms`.`type` = '$type', `rooms`.`floor` = '$floor', `rooms`.`seats` = '$seats', `rooms`.`hascomputers` = '$hasComputers',
			`rooms`.`numcomputers` = '$numComputers', `rooms`.`limit` = '$limit' WHERE `rooms`.`roomid` = '$roomid'";

		$conn->query ( $_updateSql ) or die($conn->error);
	} else
	{
		$_createSql = "INSERT INTO `rooms` (`roomid`, `type`, `floor`, `seats`, `hascomputers`, `numcomputers`, `limit`) VALUES ('$roomid', '$type', '$floor', '$seats', '$hasComputers', '$numComputers', '$limit')";
		$conn->query ( $_createSql );
	}


if(!empty($conn->error)){
    die($conn->error);
}

$conn->close();
header("Refresh: 0");
// Isn't sending back to userSettings.php :(

?>