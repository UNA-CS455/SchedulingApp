<?php session_start();

	require "db_conf.php"; // set servername,username,password,and dbname

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
		

    if(isset($_GET['id']))
    {
      $id = $_GET['id'];
    }
    else
    {
      $id = $_POST['id'];
    }

    $sql = "DELETE FROM reservations WHERE id=$id LIMIT 1;";
    if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
      $ref = $_SERVER['HTTP_REFERER'];
      // echo $ref;
      if(strpos($ref, 'userSettings.php') == true)
      {
        header ("Location: " . $_SERVER['HTTP_REFERER']);
      }
		} else {
			echo "Error deleting record: " . $conn->error;
		}

        $conn->close();

?>