<?php session_start();

require "db_conf.php";
$conn = new mysqli ( $servername, $username, $password, $dbname ) or die( "Connection failed: " . $conn->connect_error );

$userToVerify = $_POST['allowedUser'];


$verifySql = "SELECT * FROM `users` WHERE `users`.`email` = $userToVerify";
$verifyRes = $conn->query($verifySql);

if($verifyRes->num_rows == 1){
    $conn->close;
	return 1;
}
else{
    $conn->close;
	return 0;
}

$conn->close;

?>