<?php
session_start();
//$user = $_SESSION['username'];
require_once 'db_conf.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_errno) {
    die("Connect Error: " . $conn->connect_error);
}


$id = $_POST['id'];


$select = "SELECT * FROM reservations WHERE id = $id";
$result = $conn->query($select);
if ($result->num_rows != 1) {
} else {
    $row = $result->fetch_assoc();
}

$owneremail = $row['owneremail'];
$res_email = $row['res_email'];
$date = $row['startdate'];
$starttime = $row['starttime'];
$endtime = $row['endtime'];
$enddate = $row['enddate'];
$roomnumber = $row['roomnumber'];
$comment = $row['comment'];
$headcount = $row['headcount'];
$starttime = date('H:i', strtotime($starttime));
$endtime = date('H:i', strtotime($endtime));

if($row['allowshare']) {
    $allowshare = "Yes";
    $headcount = "<span id='headcount'>$headcount</span> people <br><br>";
} else {
    $allowshare = "No";
    $headcount = "<span id='headcount'></span>";
}


$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

$options = "";
if ($result->num_rows > 0) {
    while ($option = $result->fetch_assoc()) {
        $options = $options . "<option value='{$option['roomid']}'>{$option['roomid']}</option>";
    }
} else {
    $options = "<option>No rooms available</option>";
}

$edithtml = "<?php?><html><head></head><body>"
        . "<div id='responseText'></div>"
        . "<span id='id' style='display:none'>$id</span>"
        . "Reserving Email: $owneremail<br><br>"
        . "Revervation for: <input type='text' id = 'owneremail' value='$res_email'><br><br>"
        . "<input type='date' id='date' value='$date'><br><br>"
        . "<input id = 'startTime' type = 'time' step = '900' width = '48' value='$starttime'>"
                . "<br>to<br> <input id = 'endTime' type = 'time' step = '900' width = '48' value='$endtime'><br><br>"
        . "Allow Sharing: <span id='allowshare'>$allowshare</span><br><br>$headcount"
        . "<select id='roomnumber'><option value='$roomnumber' hidden>$roomnumber</option>"
            . "$options</select><br>"
        . "Comments:"
            . "<br><textarea rows='4' cols='25' id='comment'>$comment</textarea>"
        . "</body>"
        . "</html>";


echo $edithtml;



