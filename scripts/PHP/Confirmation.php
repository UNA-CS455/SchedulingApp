<?php
$date = $_GET['date'];
$resEmail = $_GET['resEmail'];
$allowshare = $_GET['allowshare'];
$numberOfSeats = $_GET['numberOfSeats'];
$startTime = $_GET['timeStart'];
$endTime = $_GET['timeEnd'];
$occur = $_GET['occur'];
$comment = $_GET['comment'];
?>


        <h1>Reservation</h1>

        <b style='font-size: 125%'>Reserving email:</b>
        <text>
        <?php
        echo $resEmail;
        ?></text><br>

        <b style='font-size: 125%'>Date:</b>
        <text>
        <?php
        echo $date;
        ?></text><br>

        <b style='font-size: 125%'>Duration:</b>
        <text>
        <?php
        echo $startTime . "-" . $endTime;
        ?></text><br>

        <b style='font-size: 125%'>Recurring:</b>
        <text>
        <?php
        echo $occur;
        ?></text><br>

        <?php
        if (intval($allowshare) === 1) {
            ?>
            <b style='font-size: 125%'>Sharing:</b>
            <text>Yes</text>
            <br>
            <b style='font-size: 125%'>Number of Seats:</b>
            <text>
            <?php
            echo $numberOfSeats;
            ?>
            </text>
            <?php
        } else {
            ?>
            <b style='font-size: 125%'>Sharing:</b>
            <text>No</text>
            <?php
        }
        ?><br>



        <b style='font-size: 125%'>Comment:</b><br>
        <textarea rows="4" cols="45" disabled="TRUE" ><?php
            echo $comment;
            ?></textarea><br><br>

