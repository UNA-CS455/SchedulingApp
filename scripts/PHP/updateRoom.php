<?php
	
session_start();
	
/////////////////////////////////////////////////////////////////
//old DB calls
/////////////////////////////////////////////////////////////////
if (!isset($_SESSION['username'])){
	header('location: ../../login.html');
}
//only admin can view this page
if ($_SESSION['permission']!= 1){
	header('location: ../../login.html');
}
  $roomId = $_POST['roomid'];
	// $currRoom = $_POST['currRoom'];
	// $roomid = $_POST['roomNumber'];
	// $type = $_POST['type'];
	// $floor = $_POST['floor'];
	// $seats = $_POST['seats'];

  $getSql = "SELECT * FROM rooms WHERE `rooms`.`roomid` = $roomId";
  $conn->query($getSql);
  


	if (trim($numcomputers) === ""){
		$numcomputers = 0;
	}

	require "db_conf.php";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "UPDATE rooms SET roomid = '$roomid', type = '$type', floor = $floor, seats = $seats WHERE roomid = '$currRoom'";
	$conn->query($sql);
	if ($conn->affected_rows > 0){
		$_SESSION['msg'] = "<p> Successfully updated room</p>";
		$sql = "UPDATE reservations SET roomnumber = '$roomid' WHERE roomnumber = '$currRoom'";
		$conn->query($sql);
	}
	else
	{
		$_SESSION['msg'] = "<p> failure $sql </p>";
	}
	$conn->close();
	// header("location:userSettings.php");

/////////////////////////////////////////////////////////////////
//connect to db using PDO
/////////////////////////////////////////////////////////////////

//When connecting to the server, set names to utf8 encoding
// $_opt = array
// (
//   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
// ); 
// $_ini = parse_ini_file("{$_SERVER['DOCUMENT_ROOT']}/SchedulingApp/etc/config.ini", true);

// //If on localhost, create root PDO. Else, connect to the server with config.ini username and password.
// if($_SERVER['SERVER_NAME'] == 'localhost')
// {
//   $_dsn = "{$_ini['database']['dialect']}:host=127.0.0.1;dbname=" . strtolower($_ini['database']['schema']);

//   $_pdo = new PDO($_dsn, 'root', '', $_opt);
// }
// else
// {
//   $_pdo = new PDO($_dsn, $_ini['database']['username'], $_ini['database']['password'], $_opt);
// }


/////////////////////////////////////////////////////////////////
//Make database queries
/////////////////////////////////////////////////////////////////

// $_getRoomSql = "SELECT * FROM `rooms` where `rooms`.`roomid` = :roomId";
// $_getRoomsStmnt = $_pdo->prepare($_getRoomSql);

// $_params = 
// array
// (
//   ':roomId' => $_POST['currRoom']
// );

//  // $currRoom = $_POST['currRoom'];
//  $currRoomId = $_POST['currRoom'];
//  $newRoomId = $_POST['newRoom'];
//  $type = $_POST['type'];
//  $floor = $_POST['floor'];
//  $seats = $_POST['seats'];
//  echo $roomid;
//  echo $new;

// if($_getRoomsStmnt->execute($_params))
// {
//   $_foo = $_getRoomsStmnt->fetch(PDO::FETCH_ASSOC);
//   print_r($_foo);

// }
// else
// {
//   echo "failure";
// }


// $_updateRoomSql = "UPDATE `rooms` SET `rooms`.`type` = :type, `rooms`.`floor` = :floor, `rooms`.`seats` = :seats WHERE `rooms`.`roomid` = :roomid";
// $_updateRoomStmnt = $_pdo->prepare($_updateRoomSql);

// $_params = 
// array
// (
//   ':type' => $_POST['type'],
//   ':floor' => $_POST['floor'],
//   ':seats' => $_POST['seats'],
//   ':roomid' => $_POST['currRoom']
// );

// if($_updateRoomStmnt->execute($_params))
// {
//   header('location: userSettings.php');
// }
// else
// {
//   echo "fail";
// }