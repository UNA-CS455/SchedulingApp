<?php
	// $user = $_POST['user'];
	require "db_conf.php";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	// $sql = "DELETE FROM users WHERE email='$user' LIMIT 1";
	// if ($conn->query($sql) === TRUE) {
	// 		echo "Record deleted successfully";
	// 	} else {
	// 		echo "Error deleting record: " . $conn->error;
	// 	}

  //DELETE USER=======================================================
  // If deleteUser.php gets the users email
  $email = $_GET['email'];
  if(isset($_GET['email']))
  {
    $sql = "DELETE FROM `users` WHERE `email`='$email'";

    if($conn->query($sql) === TRUE)
    {
      header('Location: ' .$_SERVER['HTTP_REFERER']);
    }
    else
    {
      echo "failed";
    }
  }

  $conn->close();
?>