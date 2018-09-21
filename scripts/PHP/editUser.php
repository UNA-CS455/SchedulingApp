<?php
  session_start();

  if (!isset($_SESSION['username'])){
    header('location: ../../login.html');
  }
  //only admin can view this page
  if ($_SESSION['permission']!= 1){
    header('location: ../../login.html');
  }

  require "db_conf.php";
  $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

//////////////////////////////////////////////////////////////////////////////////////
///////////SELECT PASSED THROUGH USER
//////////////////////////////////////////////////////////////////////////////////////
  $gotUser = $_GET['email'];
  $_sql = "SELECT * FROM `users` WHERE `users`.`email` = '$gotUser'";

  $_res = $conn->query($_sql);

  $_userRes = $_res->fetch_assoc();

  $_oldEmail = $_userRes['email'];
  //var_dump for debugging puposes
  // var_dump($_userRes);

//////////////////////////////////////////////////////////////////////////////////////
///////////HANDLE EDITING A USER
//////////////////////////////////////////////////////////////////////////////////////

  if(isset($_POST['submit']))
  {
    $updateFirstname = $_POST['firstname'];
    $updateLastname = $_POST['lastname'];
    $updateEmail = $_POST['email'];
    $updatePassword = sha1($_POST['email'] . $_POST['password']);
    $updateClassification = $_POST['classification'];

    $_updateSql = "UPDATE `users` SET `users`.`firstname` = '$updateFirstname', `users`.`lastname` = '$updateLastname', `users`.`email` = '$updateEmail', `users`.`password` = '$updatePassword', `users`.`classification` = '$updateClassification' WHERE `users`.`email` = '$_oldEmail'";
    $conn->query($_updateSql);

    header('Location: userSettings.php');

  }


?>
  <!DOCTYPE html>
  <html class="gr__localhost">

  <head>
    <script type="text/javascript" src="chrome-extension://aadgmnobpdmgmigaicncghmmoeflnamj/ng-inspector.js"></script>
  </head>

  <body onload="populateBlacklistRooms(null); populateGroupList();" data-gr-c-s-loaded="true">
    <div id="shader" onclick="shaderClicked()"></div>
    <!-- Jquery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Local scripts -->
    <script src="../JS/popup.js"></script>
    <script src="../JS/rooms.js"></script>
    <script src="../JS/settingsDisplay.js"></script>
    <!-- Include FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <!-- Include Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <!-- Jquery -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../../styles/rooms.css">
    <link rel="stylesheet" href="../../styles/Reservation.css">
    <link rel="stylesheet" href="../../styles/calendar.css">
    <!-- Add? <link rel="stylesheet" href="styles/links.css"> <!--Taylor-->
    <link rel="stylesheet" href="../../styles/popup.css">
    <title>Edit user</title>
    <div class="jumbotron-fluid">
      <img src="../../images/una.png" id="logo" onclick="window.location.href = ''">
    </div>
    <nav class="navbar navbar-default" style="margin-bottom: 0px;">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"></a>
          <!-- Adrianne -->
          <p id="welcomeText">Welcome, super@una.edu</p>
          <br>
        </div>
        <button class="btn btn-default navbar-btn" id="makeResButton" onclick="window.location.href = '../../'; showCreateResForm();">Make Reservation</button>
        <button class="btn btn-default navbar-btn" id="monthViewButton" onclick="window.location.href = '../../#calView'; showCalendarView();">Month View</button>
        <button class="btn btn-default navbar-btn" onclick="dropdownRes();" id="monthViewButton">My Reservations</button>
        <button class="btn btn-default navbar-btn" id="settingsButton" onclick="window.location.href = 'userSettings.php'">Settings</button>
        <!--Taylor-->
        <button onclick="logoutUser();" class="signOut btn btn-default navbar-btn pull-right">Logout</button>
      </div>
    </nav>
    <div class="container">
      <br/>
      <h1>User Settings</h1>
      <div class="row">
        <form name="createUser" method="POST" action="">
          <div class="row">
            <br/>
            <div class="col-md-4">
              <label for="firstname">First Name</label>
              <input type="text" name="firstname" class="form-control" <?php echo(isset($_userRes['firstname']) ? ' value="'.$_userRes['firstname'].'" ' : "") ?>>
            </div>
            <!-- /.col-lg-3 -->
            <div class="col-md-4">
              <label for="lastname">Last Name</label>
              <input type="text" name="lastname" class="form-control" <?php echo(isset($_userRes['lastname']) ? ' value="'.$_userRes['lastname'].'" ' : "") ?>>
            </div>
            <!-- /.col-lg-3 -->
          </div>
          <div class="row">
            <br/>
            <div class="col-md-3">
              <label for="email">Email</label>
              <input type="text" name="email" class="form-control" <?php echo(isset($_userRes['email']) ? ' value="'.$_userRes['email'].'" ' : "") ?>>
            </div>
            <div class="col-md-3">
              <label for="password">Password</label>
              <input type="text" name="password" class="form-control" placeholder="Enter new password">
            </div>
            <div class="col-md-2">
              <label for="classification">Classification</label>
              <select class="form-control" id="classification" name="classification">
                <option value="" <?php echo (isset($_userRes['classification']) ? "selected" : "") ?>>Select One</option>
                <option value="ADMIN" <?php echo ($_userRes['classification'] == 'ADMIN' ? "selected" : "") ?>>Admin</option>
                <option value="USER" <?php echo ($_userRes['classification'] == 'USER' ? "selected" : "") ?>>User</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <br/>
              <button class="btn btn-secondary" id="submit" name="submit" type="submit">Update User</button>
            </div>
          </div>
      </div>
      </form>
    </div>
    </div>
  </body>

  </html>