<?php
	include 'calendar.php';
	
	$room = $_GET['room'];
	$calendar = new Calendar($room);
	echo "<h1 style='font-size:28px'>Active Reservations For $room</h1><br>";
	echo $calendar->show();
			
?>