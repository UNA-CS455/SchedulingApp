<?php session_start();
/******************************************************************************

******************************************************************************/
if (!isset($_SESSION['username'])){
	//TODO redirect to login.
		$_SESSION['username'] = "admin@una.edu";
}

$groupName = (isset($_POST['groupName'])) ? $_POST['groupName'] : null; 

$groupName = trim($groupName);
$groupName = filter_var($groupName,FILTER_SANITIZE_SPECIAL_CHARS);
//$groupName = str_replace("'","\'", $groupName);

if(strlen($groupName)<1){
	echo "Not enough characters in the group name field.";
	exit;
}
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
	if($stmt->errno == 1062){ // name is a unique field in the database, so this error exists	
								// when the user attempts to make another group.
		echo "Can't create a group with the name '$groupName' as it already exists.";
	}
	else
		echo $stmt->errno ." : ". $stmt->error;
}
else{
	echo "Group '$groupName' created successfully.";
}
$conn->close();



?>
