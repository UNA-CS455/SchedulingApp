<?php session_start();

$_SESSION['owneremail'] = "dbrown4@una.edu";
$_SESSION['roomid'] = "Raburn 210";
$_SESSION['starttime'] = "02/04/2018 12:00:00";
$_SESSION['endtime'] = "02/04/2018 15:00:00";
$_SESSION['recur'] = ‘yes’;
$_SESSION['recur_str'] = "Every Sunday";
$_SESSION['res_email'] = "dbrown4@una.edu";
$_SESSION['share'] = ‘yes’;
$_SESSION['headcount'] = 15;

header("location:mail.php");



?>
