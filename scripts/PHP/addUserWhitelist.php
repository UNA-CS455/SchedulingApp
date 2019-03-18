<?php session_start();

require "db_conf.php";
$conn = new mysqli ( $servername, $username, $password, $dbname ) or die( "Connection failed: " . $conn->connect_error );

$email = $_POST['allowedUser'];
$roomid = $_POST['roomid'];

$_allowedSql = "INSERT INTO `whitelist` (`email`, `roomid`) VALUES ('$email', '$roomid')";
$conn->query ( $_allowedSql ) or die($conn->error);

if(!empty($conn->error)){
    die($conn->error);
}
else{
    echo $email;
}

$conn->close();
header("Refresh: 0");


?>