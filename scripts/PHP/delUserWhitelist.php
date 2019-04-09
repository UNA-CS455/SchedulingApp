<?php session_start();

require "db_conf.php";
$conn = new mysqli ( $servername, $username, $password, $dbname ) or die( "Connection failed: " . $conn->connect_error );

$email = $_POST['allowedUser']; // We pass in allowedUser and roomid from limitUser.js
$roomid = $_POST['roomid'];

$_allowedSql = "DELETE FROM `whitelist` WHERE `whitelist`.`email` = '$email' AND `whitelist`.`roomid` = '$roomid'";
$conn->query ( $_allowedSql ) or die($conn->error); 

if(!empty($conn->error)){ // If there were ANY issues with the query, kill the connection and give an error
    die($conn->error);
}
else{ // Else, echo out the email to limitUser.js
    echo "Successfully deleted $email";
}


$conn->close();
?>