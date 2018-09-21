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
$headcount = $_POST['headcount'];
$allowshare = $_POST['allowshare'];

$comment = trim($comment);
$comment = filter_var($comment, FILTER_SANITIZE_SPECIAL_CHARS);



$sql = "UPDATE reservations SET roomnumber='$roomnumber', startdate='$startdate', enddate='$enddate', starttime='$starttime', endtime='$endtime', comment='$comment', res_email='$email' WHERE id = '$id'";
$starttime = DateTime::createFromFormat('H:i', $starttime);
$endtime = DateTime::createFromFormat('H:i', $endtime);


if (checkValidUpdate(true, $starttime, $endtime, $startdate, $roomnumber, $id) && checkDateTime(true, $starttime->format("H:i"), $endtime->format("H:i"))) {

    if ($allowshare == "1") {

        if (checkEnoughSeats(true, $starttime->format("H:i"), $endtime->format("H:i"), $startdate, $roomnumber, $headcount)) {

            if ($conn->query($sql) === TRUE) {
                echo "Update Successful";
            } else {
                echo "Update Failed";
            }
        }
    } else {
        if (checkReservation($starttime, $endtime, $startdate, $roomnumber, $id)) {
            if ($conn->query($sql) === TRUE) {
                echo "Update Successful";
            } else {
                echo "Update Failed";
            }
        }
    }
}
$conn->close();

