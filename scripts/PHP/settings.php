
<!DOCTYPE html>
<html>
<title>Settings</title>
<body>
	<h1> User Settings </h1>
	<h2> Favorite Rooms </h2>
	<form action="getfavorites.php" METHOD="POST">
		Username: <input type="text" name="useremail"><br>
		<input type="submit" value="get" name="get" />
	</form>
	<form action="updateRoom.php" METHOD="POST">
		Current Room: <br>
		<input type="text" name="currRoom">
		<br> New room number:
		<input type="text" name="roomNumber">
		<br>New type:
		<input type="text" name="type">
		<br>New floor: 
		<input type="text" name="floor">
		<br>Seats: 
		<input type="text" name="seats">
		<br>Has computers: 
		<input type="text" name="hascomputers">
		<br>Number of computers: 
		<input type="text" name="numcomputers">
		<input type="submit" value="Submit">
	</form>
	<h1>Administrator Settings:</h1>
	<h3>Currently Selected Reservations</h2>
	<table>
		<tr>
			<th>Room</th>
			<th>From</th>
			<th>To</th>
			<th>Details</th>
		</tr>
		
	</table>
	<br>
	<h3>Find Users by Email</h3>
	<form action="search.php" METHOD="POST">
		<input type="text" name="userid">
		<input type="submit" value="Search">
	</form>
	<br>
	<h3>Add Users by Email</h3>
	<form action="addUser.php" METHOD="POST">
		<input type="text" name="userid">
		<input type="submit" value="Submit">
	</form>
	<br>
	<h3>Find Reservations by email</h3>
	<form action="res_settings.php" METHOD="POST">
		<br>email:
		<input type="text" name="res_email">
		<input type="submit" value="search">
	</form>
</body>
</html>