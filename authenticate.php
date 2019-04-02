<?php

session_start();
require "scripts/PHP/db_conf.php";
$conn = new mysqli($servername, $username, $password, $dbname);
$result = 0;
$in_ldap = false;
$user = $_POST['username'];
$_SESSION['username'] = $user;
$pass = $_POST['password'];
$user .= "@una.edu";

//  echo $user;
//   echo "\n";
//   echo $pass;
//   echo "\n";

  $_sql = "SELECT * FROM `users` WHERE `users`.`email` = '$user' ORDER BY `firstname` ASC";
  $_res = $conn->query($_sql);
  $_userRes = $_res->fetch_assoc();

//   var_dump($_userRes);

  if($_userRes['classification'] != "")
  $_SESSION['classification'] =  $_userRes['classification'];
  if($_userRes['email'] != "")
  $_SESSION['email'] = $_userRes['email'];

  if($user == $_userRes['email'] &&  sha1($user . $_POST['password']) == $_userRes['password'])
  {
  echo "this should show up once";
  $result = 200;
  $ldap_permissions = 1;
  }
  else
  {
  $result = `java ActiveDirectory $user $pass`;
  if($result == 200)
  $in_ldap = true;
  }

 
// if ($user == "super" && $pass == "super") {      //superuser  for testing
//     $result = 200;
//     $ldap_permissions = 1;
//     $_SESSION['classification'] = "ADMIN";
//  }
//     else {
//         $result = `java ActiveDirectory $user $pass`;
//         if ($result == 200)
//             $in_ldap = true;
//     }


    
//append @una.edu for convenience in other source code files
//verify ldap
//check to see if user is in the user table
//may need crabtree to give us function for verifying passwords
    if ($in_ldap) {
        $ldap_first = "first_name";
        $ldap_last = "last_name";
        $ldap_permissions = 2;             //add ldap code for getting user permissions							

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //$sql = "SELECT email from users WHERE email = '$user'";				
        //ldap permissions should be cahnged to 2 instead of U and change the setting page display test for != 1

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $user);
        $check = $stmt->execute();
        $stmt->store_result();
        $numCheck = $stmt->num_rows;

        if ($check) {
            if ($numCheck < 1) {
                $stmt_insert = $conn->prepare("INSERT INTO `users` (`email`, `firstname`, `lastname`, `groupID`) VALUES									
					(?, ?, ? ,?)");
                $stmt_insert->bind_param("sssi", $user, $ldap_first, $ldap_last, $ldap_permissions);
                $check = $stmt_insert->execute();
//TODO check check and send back to login if error happened
            }
        }
        //get permission level
        $sql = "SELECT `groupID`, `classification` FROM `users` WHERE email='" . $user . "'";
        $sql_result = $conn->query($sql);
        $rowcount = mysqli_num_rows($sql_result);
        while ($row = mysqli_fetch_assoc($sql_result)) {
            if ($rowcount > 0) {

                $ldap_permissions = $row["groupID"];
                $_SESSION['classification'] = $row["classification"];
            }
        }
    }
    if ($result == 200) {
        $_SESSION['username'] = $user;
        $_SESSION['permission'] = $ldap_permissions;
        header('location: index.php');
    }
    if ($result == 404){
        header('location: login.html');
    }
    else {
        echo $result . " " . $user . " " . $pass;
        //header('location: login.html');
    }
?>