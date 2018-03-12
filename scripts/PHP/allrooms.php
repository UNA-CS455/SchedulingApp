<?php session_start();
	if (!isset($_SESSION['username'])){
			$_SESSION['username'] = "dbrown4@una.edu";
	}
    require "db_conf.php";
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
		if($i == 6)
		{
			$sql = "SELECT * FROM favorites WHERE roomid='" . $row['roomid'] . "' AND email='" . $_SESSION['username'] . "'";
			$result2 = $conn->query($sql);

			while ($row2 = $result2->fetch_assoc()) {
				// there is a favorite.
				$imgName = "images/fav-select.png";
			}
			echo "<td class = 'room' id = '".$row['roomid']."'><img src='" . $imgName . "' onclick='favoriteClicked(this.parentElement);' class='favoriteIcon'><font id = '".$row['roomid']."' onclick='selectRoom(this.id)' class='roomText'><b>" . $row['roomid'] ."</b><br></font></td>";
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
	
	$sql = "SELECT * FROM rooms ORDER BY roomid";
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
			echo "<td class = 'room' id = '".$row['roomid']."'><img src='" . $imgName . "' onclick='favoriteClicked(this.parentElement);' class='favoriteIcon'><font id = '".$row['roomid']."' onclick='selectRoom(this.id)' class='roomText'><b>" . $row['roomid'] ."</b><br><br>". $row['seats'] ."<br>" . $row['type'] . "</font></td>";
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
			echo "<td class = 'room' id = '".$row['roomid']."'><img src='" . $imgName . "' onclick='favoriteClicked(this.parentElement);' class='favoriteIcon'><font id = '".$row['roomid']."' onclick='selectRoom(this.id)' class='roomText'><b>" . $row['roomid'] ."</b><br><br>". $row['seats'] ."<br>" . $row['type'] . "</font></td>";
			$i++;
		}
		

		
	}

$conn->close();
?>
