<?php
	$user = $_POST['userid'];
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cs455";
				
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM users WHERE email='$user'";
	$result = $conn->query($sql);
	
	if($result != false){
		echo "<table><tr><th>Useremail</th><th>First Name</th><th>Last Name</th><th>role</th><th>Permissions</th></tr>";
		while ($row = $result->fetch_assoc()) {
			echo "<tr><td>" . $row['email'] . "</td><td>" . $row['firstname'] . "</td><td>" 
				. $row['lastname'] . "</td><td>" . $row['classification'] . "</td><td>" . $row['permissions'] . "</td></tr>";
			echo "<td><form action='changeUserInfo.php' method='POST'>
					<input type='hidden' name='user' value='$user'>
					<input type='submit' value='Submit'></form></td>";
		}
	} else {
		echo "<p> Error: no users found. </p>";
	}
	$conn->close();