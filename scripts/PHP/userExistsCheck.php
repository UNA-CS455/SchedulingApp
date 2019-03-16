<?php session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs455";

$conn = new mysqli ( $servername, $username, $password, $dbname );

$userToVerify = $_POST['allowedUser'];


$verifySql = "SELECT * FROM `users` WHERE `users`.`email` = $userToVerify";
$verifyRes = $conn->query($verifySql);

if($verifyRes->num_rows == 1){
    $conn->close;
	echo 1;
}
else{
    $conn->close;
	echo 0;
}

$conn->close;

?>