<?php session_start();
	/*if (!isset($_SESSION['username'])) {
		header("location:index.php");
		exit;
	}*/
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cs455";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>

<?php
	$sql = "SELECT * FROM rooms WHERE type='" . $_GET['type'] . "'  ORDER BY roomid ";
    $result = $conn->query($sql);
	$i = 0;

	$firstPrinted = false;
	while ($row = $result->fetch_assoc()) 
	{
		if($i == 0)
		{
			echo "<tr>";
		}
		if ($firstPrinted == false){
			$firstPrinted = true;
			echo "<td onclick='selectRoom(this.id)' class='room' id='No Room Preference/All'><font class='roomText'><b>All Rooms/No Preference</b><br><br></font></td>";
			$i++;
		}
		if($i == 6)
		{
			echo "<td onclick='selectRoom(this.id)' class = 'room' id = '".$row['roomid']."'><font class='roomText'><b>" . $row['roomid'] ."</b><br>". $row['seats'] ."<br>" . $row['type'] . "</font></td>";
			echo "</tr>";
			$i = 0;
		}
		
		else
		{	
			echo "<td onclick='selectRoom(this.id)' class = 'room' id = '".$row['roomid']."'><font class='roomText'><b>" . $row['roomid'] ."</b><br>". $row['seats'] ."<br>" . $row['type'] . "</font></td>";
			$i++;
		}
		

		
	}

$conn->close();
?>