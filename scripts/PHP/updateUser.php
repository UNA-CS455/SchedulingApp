<!DOCTYPE HTML>
<html>
<title>User Permissions</title>
<body>
<?php 
	$user = $_POST['user'];
	
	echo "<form action='updatePermissions.php' method='POST'>";
	echo "new Email:<input type='text' name='userEmail'></br>";
	echo "First name:<input type='text' name='first'></br>";
	echo "Last name:<input type='text' name='last'></br>";
	echo "role:<input type='text' name='role'></br>";
	echo "Permissions:<input type='text' name='permissions'></br>";
	echo "<input type='hidden' name='currUser' value='$user'></br>";
	echo "<input type='submit' name='submit'>";
	echo "</form>";
?>
	

</body>
</html>