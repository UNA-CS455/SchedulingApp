<?php session_start();
if (!isset($_SESSION['username'])){
	//TODO redirect to login.
		$_SESSION['username'] = "admin@una.edu";
}

	$groupID = (isset($_POST['groupID'])) ? $_POST['groupID'] : null; 

	$groupID = trim($groupID);
	$groupID = filter_var($groupID,FILTER_SANITIZE_SPECIAL_CHARS);

	
	if($groupID == 1){
		echo "Can't delete the Admin group. It must be in the system.";
		exit;
	}
	if($groupID == 2){
		echo "Can't delete the default user group. It must be in the system.";
		exit;
	}
	require "db_conf.php"; // set servername,username,password,and dbname

	
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
	
	$stmt = $conn->prepare("DELETE FROM groups WHERE id = ?");
	$stmt->bind_param("s", $groupID);
	$check = $stmt->execute();


	if ($check) {
		echo "Group deleted successfully";
	} else {
		echo "Error deleting group: " . $conn->error;
	}

	$conn->close();

?>