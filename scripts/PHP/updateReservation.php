<?php

session_start();
require_once 'ValidateReservation.php';
require_once 'db_conf.php';
$conn = new mysqli($servername, $username, $password, $dbname);



$id = $_POST['id'];
$roomnumber = $_POST['roomnumber'];
$email = $_POST['owneremail'];
$starttime = $_POST['startTime'];
$endtime = $_POST['endTime'];
$startdate = $_POST['startDate'];
$enddate = $_POST['endDate'];
$comment = $_POST['comment'];




$sql = "UPDATE reservations SET roomnumber='$roomnumber', startdate='$startdate', enddate='$enddate', starttime='$starttime', endtime='$endtime', comment='$comment', res_email='$email' WHERE id = '$id'";




if (checkValidUpdate(true, $starttime, $endtime, $roomnumber, $id) && checkDateTime(true, $starttime, $endtime)) {

    if ($conn->query($sql) === TRUE) {
        echo "Update Successful";
    } else {
        echo "Update Failed";
    }
}
$conn->close();

