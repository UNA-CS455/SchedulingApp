<?php
	$user = $_POST['userid'];
	require "db_conf.php";
				
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM users WHERE email LIKE '%$user%'";
	$result = $conn->query($sql);
	
	if($result->num_rows > 0){
		echo "<table><tr><th>Useremail</th><th>First Name</th><th>Last Name</th><th>role</th><th>Permissions</th></tr>";
		while ($row = $result->fetch_assoc()) {
			echo "<tr><td>" . $row['email'] . "</td><td>" . $row['firstname'] . "</td><td>" 
				. $row['lastname'] . "</td><td>" . $row['classification'] . "</td><td>" . $row['permissions'] . "</td>";
			echo "<td><form action='updateUser.php' method='POST'>
					<input type='hidden' name='user' value='". $row['email'] ."'>
					<input type='submit' value='Submit'></form></td></tr>";
		}
	} else {
		echo "<p> Error: no users found. </p>";
	}
	$conn->close();