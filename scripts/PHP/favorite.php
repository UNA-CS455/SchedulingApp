<?php session_start();

require 'db_conf.php';

if ($_POST['add'] == "yes"){
	// add a favorite
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "INSERT INTO favorites (email, roomid)
	VALUES ('" . $_SESSION['username'] . "', '" . $_POST['roomid'] . "')";

	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
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
	$sql = "DELETE FROM favorites WHERE email='" . $_SESSION['username'] . "' AND roomid='" . $_POST['roomid'] . "' LIMIT 1";

	if ($conn->query($sql) === TRUE) {
		echo "Record deleted successfully";
	} else {
		echo "Error deleting record: " . $conn->error;
	}

	$conn->close();
}

?>