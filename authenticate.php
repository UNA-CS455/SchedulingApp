<?php

session_start();


/////////////////////////////////////////////////////////////////
//connect to db using PDO
/////////////////////////////////////////////////////////////////

//When connecting to the server, set names to utf8 encoding
$_opt = array
(
  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
); 
$_ini = parse_ini_file("{$_SERVER['DOCUMENT_ROOT']}/SchedulingApp/etc/config.ini", true);

//If on localhost, create root PDO. Else, connect to the server with config.ini username and password.
if($_SERVER['SERVER_NAME'] == 'localhost')
{
  $_dsn = "{$_ini['database']['dialect']}:host=127.0.0.1;dbname=" . strtolower($_ini['database']['schema']);

  $_pdo = new PDO($_dsn, 'root', '', $_opt);
}
else
{
  $_pdo = new PDO($_dsn, $_ini['database']['username'], $_ini['database']['password'], $_opt);
}
/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////


//connect to db
require "scripts/PHP/db_conf.php";

$result = 0;
$in_ldap = false;

$user = $_POST['username'];	
$pass = $_POST['password'];

$user .= "@una.edu";


//testing
// echo $user;
// echo "</br>";
// echo $user;
// echo "</br>";
// echo $pass;
// echo "</br>";

///////////////////////////////////////////

$_loginSql = "SELECT `users`.`email` AS `email`, `users`.`password` AS `password` FROM `users` WHERE `users`.`email` = :username AND `users`.`password` = :password";
$_loginStmnt = $_pdo->prepare($_loginSql);

$_params = 
  array
  (
    ':username' => $user,
    ':password' => sha1($user . $_POST['password'])
  );

if($_loginStmnt->execute($_params))
{
  $_foo = $_loginStmnt->fetch(PDO::FETCH_ASSOC);
  print_r($_foo);
}
else
{
  print_r($_loginStmnt->errorInfo());
}

///////////////////////////////////////////

// if($user == "super@una.edu" && $pass == "super")
if($user == $_foo['email'] && sha1($user . $_POST['password']) == $_foo['password'])
{
  //superuser  for testing
	$result = 200;
	$ldap_permissions = 1;
}
else
{
	$result = `java ActiveDirectory $user $pass`;

  if($result == 200)
	 $in_ldap = true;

}
//append @una.edu for convenience in other source code files
// $user .= "@una.edu";
//verify ldap
//check to see if user is in the user table
//may need crabtree to give us function for verifying passwords

if($in_ldap)
{
	$ldap_first = "first_name";
	$ldap_last = "last_name";											
	$ldap_permissions = 2;													//add ldap code for getting user permissions							
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
  {
       die("Connection failed: " . $conn->connect_error);
  }

	//$sql = "SELECT email from users WHERE email = '$user'";				//ldap permissions should be cahnged to 2 instead of U and change the setting page display test for != 1
	
	$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");

	$stmt->bind_param("s", $user);
	$check = $stmt->execute();
    $stmt->store_result();
	$numCheck = $stmt->num_rows;

    
	if($check)
  {
		if($numCheck < 1)
		{
			$stmt_insert = $conn->prepare("INSERT INTO `users` (`email`, `firstname`, `lastname`, `groupID`) VALUES									
					(?, ?, ? ,?)");

			$stmt_insert->bind_param("sssi", $user, $ldap_first, $ldap_last, $ldap_permissions);
			$check = $stmt_insert->execute();
      //TODO check check and send back to login if error happened

		}
	}

	//get permission level
	$sql = "SELECT `groupID` FROM `users` WHERE email='" . $user . "'";

	$sql_result = $conn->query($sql);
	$rowcount = mysqli_num_rows($sql_result);
	while($row=mysqli_fetch_assoc($sql_result)){
	if($rowcount > 0)
  {
		
			$ldap_permissions = $row["groupID"];
		}
	}

}	

if($result == 200)
{
	$_SESSION['username'] = $user; 
	$_SESSION['permission'] = $ldap_permissions;
	header('location: index.php');
  // echo "<br />result success";
}
else
	// header('location: login.html');
  print_r($_foo);

?>
