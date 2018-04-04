
<?php 
	$user = $_REQUEST['q'];
	
	echo "<form action='updatePermissions.php' method='POST'>";
	echo "Current user: $user </br>";
	echo "Group:<input type='text' name='permissions'></br>";
	echo "<input type='hidden' name='currUser' value='$user'></br>";
	echo "<input type='submit' name='submit'>";
	echo "</form>";
?>