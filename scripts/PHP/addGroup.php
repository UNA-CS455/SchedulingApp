<?php session_start();
/******************************************************************************

******************************************************************************/
if (!isset($_SESSION['username'])){
	//TODO redirect to login.
		$_SESSION['username'] = "admin@una.edu";
}

$groupName = (isset($_POST['groupName'])) ? $_POST['groupName'] : null; 

	$groupName = trim($groupName);
	$groupName = filter_var($groupName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z''-'\s]{1,50}$/")));
	$groupName = str_replace("'","\'", $groupName);

require "db_conf.php"; // set servername,username,password,and dbname

$conn = new mysqli($servername, $username, $password, $dbname);

//if connection to database fails, die
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

//if connection is success, insert data into database and echo to user result

$stmt = $conn->prepare("INSERT INTO groups (name) VALUES (?)");
$stmt->bind_param("s", $groupName);
$check = $stmt->execute();


if (!$check) {
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
else{
	echo "Group '$groupName' created successfully.";
}
$conn->close();



?>
