<?php session_start();

	require "db_conf.php"; // set servername,username,password,and dbname

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
		$id = $_POST['id'];

        $sql = "DELETE FROM reservations WHERE id=$id LIMIT 1;";
        if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
		} else {
			echo "Error deleting record: " . $conn->error;
		}

        $conn->close();

?>