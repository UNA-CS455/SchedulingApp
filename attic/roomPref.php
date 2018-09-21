<html>
<?php 
require "db_conf.php"; // set servername,username,password,and dbname

if ($_POST['Type'] == "all")
{


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) 
{
die("Connection failed: " . $conn->connect_error); 
}

$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
// output data of each row
while($row = $result->fetch_assoc()) 
{
echo "roomid: " . $row["roomid"]. " - 
Type: " . $row["type"]. " - 
seats: " . $row["seats"]. " - 
hascomputers: " . $row["hascomputers"]. " - 
numcomputers: " . $row["numcomputers"]. " - 
comment: " . $row["comment"]. "<br>";
}
} 

else 
{
echo "0 results";
}
$conn->close();

}

else 
{

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
{
die("Connection failed: " . $conn->connect_error);
}

$sql = " SELECT rooms.roomid, rooms.type, rooms.seats, rooms.hascomputers, rooms.numcomputers, rooms.comment FROM reservations RIGHT JOIN rooms ON reservations.roomnumber=rooms.roomid WHERE reservations.start IS NULL OR (reservations.allowshare=1 AND (SELECT SUM(reservations.headcount) FROM reservations WHERE rooms.roomid=reservations.roomnumber) < rooms.seats); ";
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
// output data of each row
while($row = $result->fetch_assoc())
{
echo "roomid: " . $row["roomid"]. " - 
Type: " . $row["type"]. " - 
seats: " . $row["seats"]. " - 
hascomputers: " . $row["hascomputers"]. " - 
numcomputers: " . $row["numcomputers"]. " - 
comment: " . $row["comment"]. "<br>";
}
}

else
{
echo "0 results";
}
$conn->close();

}
?>
</html>
