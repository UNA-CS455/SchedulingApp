<?php
//Adrianne
session_start();


$user = $_POST['username'];	
$pass = $_POST['password'];

    
$result = `java ActiveDirectory $user $pass`;

if($result == 200){
	$_SESSION['username'] = $user; 
	header('location: index.php');
	}
else
	header('location: login.html');

echo "$result";

?>
