<?php
	include 'calendar.php';
	
	$room = $_GET['room'];
	$calendar = new Calendar($room);
	
	echo $calendar->show();
			
?>