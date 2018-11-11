<?php
  session_start();

  if (!isset($_SESSION['username'])){
    //$_SESSION['username'] = "admin@una.edu"; // for development, we will uncomment the call to header below.
    header('location: login.html'); exit();
  }

  if(isset($_SESSION['username']))
  {
    $logged_in_user = $_SESSION['username'];
  };

  // if(isset($_SESSION['classification']))
  // {
  //   echo($_SESSION['classification']);
  // }
  
?>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Include Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
  <!-- Include FontAwesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <!-- Stylesheets -->
  <link rel="stylesheet" href="styles/rooms.css">
  <link rel="stylesheet" href="styles/Reservation.css">
  <link rel="stylesheet" href="styles/calendar.css">
  <link rel="stylesheet" href="styles/popup.css">
  <!-- Jquery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  <!-- Scripts -->
  <script src="scripts/JS/roomObjects.js"></script>
  <title>LeoBook</title>
</head>

<body onload="showCreateResForm();fieldChanged();" class="container-fluid index-body" style="overflow-y: scroll;" >
  <div class="row">
    <!-- By default, load the make reservation screen into createZone -->
    <div id="shader" onclick="shaderClicked()"></div>
    <?php include 'modal.php'; ?>
    <script src="scripts/JS/popup.js"></script>
    <script src="scripts/JS/rooms.js"></script>
    
    <script src="scripts/JS/jquery-3.3.1.min.js"></script>
    <?php 
      include("{$_SERVER['DOCUMENT_ROOT']}/SchedulingApp/includes/header.php");
    ?>
    <div style="position:absolute" id="agendaReservations">
      <!--
          The "My Reservations" agenda dropdown area. Content will be given to this via a call to the dropdownRes()
          function which is called when the "My Reservations" link in the banner is clicked.
        -->
    </div>
    <div id="deleteRes"></div>
    <div class="col-md-4 outerBookArea" id="roomContainer">
      <!--
          This is the leftmost area of the page. Content is updated upon page load with the function fieldChanged().
          This area serves as the room selector.
        -->
      <span id="favsheader"></span>
      <div id="favsbookArea"></div>
      <span id="allroomsheader"></span>
      <div id="bookArea"></div>
    </div>
    <div class="col-md-8 col-sm-12" id="createZone" style="padding-left: 45px;">
      <!--
          This is the rightmost area of the page. Content is provided by function calls:
          
          showCreateResForm() - will update the content of this div with the Make Reservation
          form. This is intended to be the default view, and is also called at the top of this
          file in the onload attribute of the body tag. 
          
          showCalendarView() - will update the content of this div with a calendar showing reservations
          on each day of the month for the room selected in the roomselector (which is the div with id of
          "roomContainer" at the bottom of this page). 
        
        
        -->
    </div>
  </div>
</body>

</html>