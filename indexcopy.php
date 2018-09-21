<?php
  session_start();

  if (!isset($_SESSION['username'])){
    //$_SESSION['username'] = "admin@una.edu"; // for development, we will uncomment the call to header below.
    header('location: login.html'); exit();
  }
?>
  <html>

  <head>
    <!-- Include Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <!-- Stylesheets -->
    <link rel="stylesheet" href="styles/rooms.css">
    <link rel="stylesheet" href="styles/Reservation.css">
    <link rel="stylesheet" href="styles/calendar.css">
    <!-- Add? <link rel="stylesheet" href="styles/links.css"> <!--Taylor-->
    <link rel="stylesheet" href="styles/popup.css">
    <!-- Jquery -->
    <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script> -->
    <title>LeoBook</title>
  </head>

  <body onload="showCreateResForm();fieldChanged();">
    <!-- By default, load the make reservation screen into createZone -->
    <div id="shader" onclick="shaderClicked()"></div>
    <?php include 'modal.php'; ?>
    <script src="scripts/JS/popup.js"></script>
    <script src="scripts/JS/rooms.js"></script>
    <script src="scripts/JS/jquery-3.3.1.min.js"></script>
    <div id="banner">
      <!--
        This is the banner of the page. It contains the links and the content of the topmost portion
        of the page.
      -->

      
      
      <img src="images/una.png" id="logo" onclick="window.location.href = ''">
      <button id="makeResButton" onclick="showCreateResForm();">Make Reservation</button>
      <button id="monthViewButton" onclick="showCalendarView();">Month View</button>
      <button onclick="dropdownRes();" id="myResButton">My Reservations</button>
      <?php //TODO: database query on users table for permission?
          if(isset($_SESSION['permission']) &&  $_SESSION['permission'] == 1)                                             //using "super" as username and password for testing groups permissions
          {
            echo  "<button id=\"settingsButton\" onclick=\"window.location.href += 'scripts/PHP/userSettings.php'\">Settings</button>";
          } 

        ?>
        <div class="welcome">
          <!--Adrianne-->
          <?php
                if (isset($_SESSION['username'])) {
          echo "<p id='welcomeText'>Welcome, " . $_SESSION['username'] ."</p><br>";
          $logged_in_user = $_SESSION['username']; //used for default in reserving email field.
                }
                ?>
            <!--Taylor-->
            <button onclick="logoutUser();" class="signOut">Logout</button>
        </div>
    </div>
    <div style="position:absolute" id="agendaReservations">
      <!--
        The "My Reservations" agenda dropdown area. Content will be given to this via a call to the dropdownRes()
        function which is called when the "My Reservations" link in the banner is clicked.
      -->
    </div>
    <div id="deleteRes"></div>
    <div class="makeReservation" id="createZone">
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
    <div class="outerBookArea" id="roomContainer">
      <!--
        This is the leftmost area of the page. Content is updated upon page load with the function fieldChanged().
        This area serves as the room selector.
      -->
      <span id="favsheader"></span>
      <div id="favsbookArea"></div>
      <span id="allroomsheader"></span>
      <div id="bookArea"></div>
    </div>
  </body>

  </html>