<?php session_start();

require "db_conf.php";
$conn = new mysqli ($servername, $username, $password, $dbname );
if ($conn->connect_error)
{
	die ( "Connection failed: " . $conn->connect_error );
}

$userToVerify = $_POST['allowedUser']; // We pass in the user's name that we want to verify exists


$verifySql = "SELECT * FROM `users` WHERE `users`.`email` = '$userToVerify'";

if($verifyRes = $conn->query($verifySql)){ // If there is a valid result (no SQL syntax errors)
    if($verifyRes->num_rows == 1){ // If there was a DISTINCT user that was returned, echo out 1 to limitUsers.js
        $conn->close();
    	echo 1;
    }
    else{ // If there was more or less than 1 row returned, echo out 0 to limitUsers.js
        $conn->close();
    	echo 0;
    }
}
else{ // If there was a SQL syntax error, kill the connection and give an error
    die($conn->error);
}

?>