<?php session_start();

	require "db_conf.php"; // set servername,username,password,and dbname

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
		
    

    $conn->close();

?>