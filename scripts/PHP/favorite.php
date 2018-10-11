<?php session_start();

require 'db_conf.php';

if ($_GET['room']){

  $gotRoom = $_GET['room'];
  $email = $_SESSION['username'];
  // add a favorite
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 

  $checkSql = "Select * FROM favorites WHERE roomid = $gotRoom AND email = $email";
  var_dump( $conn->query($checkSql));
  if(!$conn->query($checkSql))
  {
    echo "added a room";
    $sql = "INSERT INTO favorites (email, roomid)
    VALUES ('" . $_SESSION['username'] . "', '" . $_GET['room'] . "')";

    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
      // header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
  }
  elseif($conn->query($checkSql))
  {
    echo "deleted a room";
    // remove one.
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } 

    // sql to delete a record
    $sql = "DELETE FROM favorites WHERE email= $email AND roomid= $gotRoom LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      echo "Record deleted successfully";
      // header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
      echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
  }
}

  // $conn = new mysqli($servername, $username, $password, $dbname);

  // if($conn->connect_error)
  // {
  //   die("Connection Failed: " . $conn->connect_error);
  // }

  // if($_GET['room'])
  // {
  //   $gotRoom = $_GET['room'];

  //   $checkSql = "Select * FROM favorites WHERE roomid = $gotRoom AND email = '".$_SESSION['username']"'";

  // }
  // else
  // {
  //   echo "Something went wrong";
  // }

?>

