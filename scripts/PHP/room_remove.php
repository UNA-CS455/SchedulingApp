<?php session_start();
	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cs455";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

        $sql = "DELETE FROM reservations WHERE roomnumber='" . $_POST['roomid'] . "' AND start='" . $_POST['from'] . "' AND end='" . $_POST['to'] . "' LIMIT 1;";
        if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
		} else {
			echo "Error deleting record: " . $conn->error;
		}

        $conn->close();

?>