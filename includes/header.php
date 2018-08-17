<!-- jumbotron and navbar -->
<div class="jumbotron-fluid">
  <img src="images/una.png" id="logo" onclick="window.location.href = ''">
</div>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <!-- Adrianne -->
        <?php
          if(isset($_SESSION['username'])){echo "<p>Welcome, " .$logged_in_user."</p>";}
        ?>
      </a>
    </div>
    <button id="makeResButton" class="btn btn-default navbar-btn" onclick="showCreateResForm()">Make Reservation</button>
    <button id="monthViewButton" class="btn btn-default navbar-btn" onclick="showCalendarView()">Month View</button>
    <button class="btn btn-default navbar-btn" onclick="dropdownRes()">My Reservations</button>
    <?php //TODO: database query on users table for permission?
        if(isset($_SESSION['permission']) &&  $_SESSION['permission'] == 1)//using "super" as username and password for testing groups permissions
        {
          echo  "<button class='btn btn-default navbar-btn' id=\"settingsButton\" onclick=\"window.location.href += 'scripts/PHP/userSettings.php'\">Settings</button>";
        } 
    ?>
    <!--Taylor-->
    <button onclick="logoutUser();" class="signOut btn btn-default navbar-btn pull-right">Logout</button>
  </div>
</nav>