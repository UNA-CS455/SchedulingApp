<?php session_start();

require "db_conf.php";
$conn = new mysqli ( $servername, $username, $password, $dbname ) or die( "Connection failed: " . $conn->connect_error );

$email = $_POST['allowedUser']; // We pass in allowedUser and roomid from limitUser.js
$roomid = $_POST['roomid'];

$_allowedSql = "INSERT INTO `whitelist` (`email`, `roomid`) VALUES ('$email', '$roomid')";
$conn->query ( $_allowedSql ); 

if(!empty($conn->error)){ // If there were ANY issues with the query, kill the connection and give an error
    die($conn->error);
}
else{ // Else, echo out the email to limitUser.js
    echo $email;
}

$conn->close();
?>