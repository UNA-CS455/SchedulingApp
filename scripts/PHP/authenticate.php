<?php
session_start();

require "db_conf.php"; // set servername, username, password, and dbname

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_POST['username'];	
$pass = $_POST['password'];

$sql = "SELECT email FROM users WHERE email = '".$user."'";     
// not checking for password yet since it's not in the database         
$res = mysqli_query($conn, $sql);

if(!$res) { // Display the error
	echo 'Something went wrong while signing in. Please try again later.';
	echo mysqli_error();
}
else {
	if(mysqli_num_rows($res) == 0) {
		echo 'Username/password combination is incorrect.';
		echo '<br><a href="login.html">Try Again</a>';
	}
	else {
		$_SESSION['username'] = $user;
		header("location:index.php");
	}
}

?>