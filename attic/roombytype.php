<?php session_start();
	if (!isset($_SESSION['username'])){
			$_SESSION['username'] = "dbrown4@una.edu";
	}
	require "db_conf.php"; // set servername,username,password,and dbname
	
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>

<?php

	$sql = "SELECT * FROM favorites WHERE email='" . $_SESSION['username'] . "' ORDER BY roomid";
    $result = $conn->query($sql);
	$i = 0;
	$headerPrinted = false;
	while ($row = $result->fetch_assoc()) 
	{
		if ($headerPrinted == false){
			echo "<tr style='height: 7%;'><th style='font-size: 3vmin;'>Favorites</th></tr>";
			$headerPrinted = true;
		}
		$imgName = "images/fav-unselect.png";
		if($i == 0)
		{
			echo "<tr>";
		}
		if($i == 4)
		{
			$sql = "SELECT * FROM favorites WHERE roomid='" . $row['roomid'] . "' AND email='" . $_SESSION['username'] . "'";
			$result2 = $conn->query($sql);

			while ($row2 = $result2->fetch_assoc()) {
				// there is a favorite.
				$imgName = "images/fav-select.png";
			}
			echo "<td class = 'room' id = '".$row['roomid']."'><img src='" . $imgName . "' onclick='favoriteClicked(this.parentElement);' class='favoriteIcon'><font id = '".$row['roomid']."' onclick='selectRoom(this.id)' class='roomText'><b></font></td>";
			echo "</tr>";
			$i = 0;
		}
		
		else
		{	
			$sql = "SELECT * FROM favorites WHERE roomid='" . $row['roomid'] . "' AND email='" . $_SESSION['username'] . "'";
			$result2 = $conn->query($sql);

			while ($row2 = $result2->fetch_assoc()) {
				// there is a favorite.
				$imgName = "images/fav-select.png";
			}
			echo "<td class = 'room' id = '".$row['roomid']."'><img src='" . $imgName . "' onclick='favoriteClicked(this.parentElement);' class='favoriteIcon'><font id = '".$row['roomid']."' onclick='selectRoom(this.id)' class='roomText'><b>" . $row['roomid'] ."</b><br></font></td>";
			$i++;
		}
		

		
	}
	

	if ($_GET['type'] == "Any"){
		if ($_GET['comp'] == "Any"){
			$sql = "SELECT * FROM rooms ORDER BY roomid";
		}
		else if($_GET['comp'] == "yes"){
			$sql = "SELECT * FROM rooms WHERE hascomputers=1 ORDER BY roomid";
		}
		else{
			$sql = "SELECT * FROM rooms WHERE hascomputers=0 ORDER BY roomid";
		}
	}
	else{
		if ($_GET['comp'] == "Any"){
			$sql = "SELECT * FROM rooms WHERE type='" . $_GET['type'] . "'  ORDER BY roomid ";
		}
		else if($_GET['comp'] == "yes"){
			$sql = "SELECT * FROM rooms WHERE hascomputers=1 AND type='" . $_GET['type'] . "'  ORDER BY roomid ";
		}
		else{
			$sql = "SELECT * FROM rooms WHERE hascomputers=0 AND type='" . $_GET['type'] . "'  ORDER BY roomid ";
		}
		
	}

	
    $result = $conn->query($sql);
	$i = 0;

	$headerPrinted = false;
	$firstPrinted = false;
	while ($row = $result->fetch_assoc()) 
	{
		if ($headerPrinted == false){
			echo "<tr style='height: 7%;'><th style='font-size: 3vmin;'>All Rooms</th></tr>";
			$headerPrinted = true;
		}
		$imgName = "images/fav-unselect.png";
		if ($_GET['floor'] == "first"){
			if ($row['floor']!= "1"){
				continue;
			}
		}
		
		if ($_GET['floor'] == "second"){
			if ($row['floor']!= "2"){
				continue;
			}
		}
		
		if ($_GET['floor'] == "third"){
			if ($row['floor']!= "3"){
				continue;
			}
		}
		
		if($i == 0)
		{
			echo "<tr>";
		}
		if($i == 4)
		{
			$sql = "SELECT * FROM favorites WHERE roomid='" . $row['roomid'] . "' AND email='" . $_SESSION['username'] . "'";
			$result2 = $conn->query($sql);

			while ($row2 = $result2->fetch_assoc()) {
				// there is a favorite.
				$imgName = "images/fav-select.png";
			}
			echo "<td class = 'room' id = '".$row['roomid']."'><img src='" . $imgName . "' onclick='favoriteClicked(this.parentElement);' class='favoriteIcon'><font id = '".$row['roomid']."' onclick='selectRoom(this.id)' class='roomText'><b>" . $row['roomid'] ."</b><br>". $row['seats'] ."<br>" . $row['type'] . "</font></td>";
			echo "</tr>";
			$i = 0;
		}
		
		else
		{	
			$sql = "SELECT * FROM favorites WHERE roomid='" . $row['roomid'] . "' AND email='" . $_SESSION['username'] . "'";
			$result2 = $conn->query($sql);

			while ($row2 = $result2->fetch_assoc()) {
				// there is a favorite.
				$imgName = "images/fav-select.png";
			}
			echo "<td class = 'room' id = '".$row['roomid']."'><img src='" . $imgName . "' onclick='favoriteClicked(this.parentElement);' class='favoriteIcon'><font id = '".$row['roomid']."' onclick='selectRoom(this.id)' class='roomText'><b>" . $row['roomid'] ."</b><br>". $row['seats'] ."<br>" . $row['type'] . "</font></td>";
			$i++;
		}
		

		
	}

$conn->close();
?>
