<?php session_start();

require "db_conf.php";
$conn = new mysqli ( $servername, $username, $password, $dbname ) or die( "Connection failed: " . $conn->connect_error );


    $roomid = $_POST ['roomid'];
	$type = $_POST ['type'];
	$floor = $_POST ['floor'];
	$seats = ( int ) $_POST ['seats'];
	$numComputers = ( int ) $_POST ['numcomputers'];
	$limit = $_POST['limit'];


	if ($beingEdited)
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

$conn->close;
header("Location: userSettings.php");

?>