<?php

session_start();
require "scripts/PHP/db_conf.php";

$result = 0;
$in_ldap = false;

$user = $_POST['username'];	
$pass = $_POST['password'];

														//append @una.edu for convenience in other source code files

 if ($user === "super" && $pass === "super"){					//using "super" as username and password for testing groups permissions
		$result =200;
		$in_ldap = true;
}

else{
	$result = `java ActiveDirectory $user $pass`;
	$in_ldap = true;
}

$user .= "@una.edu";
//verify ldap
//check to see if user is in the user table
//may need crabtree to give us function for verifying passwords

	if(ldap){
		$ldap_first = "first_name";															//placeholders until dr crabtree gives us the ldap function to pull user data, also this is all subject to change as new info comes to light 
		$ldap_last = "last_name";															//lines 30 - 45 add the user from ldap to the table if we dont have them already
		$ldap_permissions = "U";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
		$sql = "SELECT email from users WHERE email = \'".$user."\'";
	
		$sql_result = $conn->query($sql);
		if(!$sql_result->num_rows > 0)
		{
			$sql = "INSERT INTO `users` (`email`, `firstname`, `lastname`, `permissions`) VALUES
					('". $user . "', '". $ldap_first ."', '" .$ldap_last . "', '" . $ldap_permissions ."') ";
			$conn->query($sql);
		}

		

	}	


if($result == 200){
	$_SESSION['username'] = $user; 

	header('location: index.php');
	}
else
	header('location: login.html');

//echo "$result";*/

?>
