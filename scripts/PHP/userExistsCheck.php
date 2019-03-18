<?php session_start();

require "db_conf.php";
$conn = new mysqli ($servername, $username, $password, $dbname );
if ($conn->connect_error)
{
	die ( "Connection failed: " . $conn->connect_error );
}

$userToVerify = $_POST['allowedUser'];


$verifySql = "SELECT * FROM `users` WHERE `users`.`email` = $userToVerify;";

if($verifyRes = $conn->query($verifySql)){
    if($verifyRes->num_rows == 1){
        $conn->close;
    	echo 1;
    }
    else{
        $conn->close;
    	echo 0;
    }
}
else{
    die($conn->error);
}

$conn->close;

?>