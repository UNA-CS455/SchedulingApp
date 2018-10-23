<?php
session_start ();

if (! isset ( $_SESSION ['username'] ))
{
  header ( 'location: ../../login.html' );
}
// only admin can view this page
if ($_SESSION ['permission'] != 1)
{
  header ( 'location: ../../login.html' );
}

require "db_conf.php";
$conn = new mysqli ( $servername, $username, $password, $dbname );
if ($conn->connect_error)
{
  die ( "Connection failed: " . $conn->connect_error );
}

// ////////////////////////////////////////////////////////////////////////////////////
// /////////SELECT ALL ROOM ID's
// ////////////////////////////////////////////////////////////////////////////////////

$_getRoomsSql = "SELECT roomid FROM rooms ORDER BY roomid ASC";
$_getRoomsResponse = $conn->query($_getRoomsSql);
// while($roomid = $_getRoomsResponse->fetch_assoc())
// {
//   echo $roomid['roomid'];
// }

// var_dump($roomid);

// ////////////////////////////////////////////////////////////////////////////////////
// /////////SELECT PASSED THROUGH RESERVATION
// ////////////////////////////////////////////////////////////////////////////////////

if (isset ( $_GET ['id'] ))
{
  //Get the reservation to be edited
  $_getReservationSql = "SELECT * FROM `reservations` WHERE `reservations`.`id` = ".$_GET['id']." ";
  $_getReservationResponse = $conn->query($_getReservationSql);
  $reservation = $_getReservationResponse->fetch_assoc();

  // var_dump($reservation);
}
else
{
  // echo "being edited";
  
}

if (isset ( $_POST ['submit'] ))
{
  
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
        <button class="btn btn-default navbar-btn" id="makeResButton" onclick="window.location.href = '../../'; showCreateResForm();">Make
          Reservation</button>
        <button class="btn btn-default navbar-btn" id="monthViewButton" onclick="window.location.href = '../../#calView'; showCalendarView();">Month
          View</button>
        <button class="btn btn-default navbar-btn" onclick="dropdownRes();" id="monthViewButton">My Reservations</button>
        <button class="btn btn-default navbar-btn" id="settingsButton" onclick="window.location.href = 'userSettings.php'">Settings</button>
        <!--Taylor-->
        <button onclick="logoutUser();" class="signOut btn btn-default navbar-btn pull-right">Logout</button>
      </div>
    </nav>
    <div class="container">
      <br />
      <h1>Edit Reservation</h1>
      <br />
      <div class="row">
        <form name="reservationForm" method="POST" action="">
          <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-2">
              <div class="form-group">
                <label for="owneremail">Owner Email</label>
                <input class="form-control" type="text" name="owneremail" <?php echo($reservation['owneremail']) ? 'placeholder= " '.$reservation['owneremail'].' "' : '' ?> readonly>
              </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-2">
              <div class="form-group">
                <label for="roomnumber">Room Number</label>
                <select class="form-control">
                  <?php
                    while($roomid = $_getRoomsResponse->fetch_assoc()){
                  ?>
                  <option value="<?php echo $roomid['roomid'];?>" <?php echo ($roomid['roomid'] == $reservation['roomnumber']) ? "selected" : "" ?>><?php echo $roomid['roomid']; ?></option>
                <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-2">
              <div class="form-group">
                <label for="allowSharing">Allow Sharing</label>
                <input id="allowshareCheck" class="form-check-input" type="checkbox" name="allowshare" <?php echo($reservation['allowshare'] == 1) ? 'checked value="1"' : '' ?>>
              </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-2">
              <div class="form-group">
                <label for="headcount">Headcount</label>
                <input id="headcount" class="form-control" type="text" name="headcount"  <?php echo($reservation['allowshare'] == 1) ? (($reservation['headcount']) ? 'value=" '.$reservation['headcount'].' "' :  'readonly value="0"') : '' ?> >
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
</body>

</html>
<script>

    $('#allowshareCheck').change(function()
    {
      if(this.checked)
      {
        $('#headcount').removeAttr('readonly');
      }
      else
      {
        $('#headcount').prop('readonly', true);
        $('#headcount').val(null);
      }
    })

</script>