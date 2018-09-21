<?php
//Chad and Lee
session_start();

if (isset($_SESSION['username'])){
  //unset($_SESSION['username']);
  session_unset();
  session_destroy();
  session_write_close();
  setcookie(session_name(),'',0,'/');
  session_regenerate_id(true);
  header('location: ../../login.html');
}
else {
  header('location: ../../login.html');
}
?>
