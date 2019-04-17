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
///////////SELECT ALL USERS
//////////////////////////////////////////////////////////////////////////////////////
  $_sql = "SELECT * FROM `users` ORDER BY `firstname` ASC";

  $_res = $conn->query($_sql);

  $_userRes = $_res->fetch_all();

  //var_dump for debugging puposes
  // var_dump($result);

//////////////////////////////////////////////////////////////////////////////////////
///////////SELECT ALL ROOMS
//////////////////////////////////////////////////////////////////////////////////////
  $_roomSql = "SELECT * FROM `rooms` ORDER BY `roomid` ASC";

  $_roomRes = $conn->query($_roomSql);

  $_roomResponse = $_roomRes->fetch_all();


//////////////////////////////////////////////////////////////////////////////////////
///////////SELECT ALL USER RESERVATIONS
//////////////////////////////////////////////////////////////////////////////////////
  $_reservationsSql = "SELECT * FROM `reservations` WHERE `reservations`.`owneremail` != 'N/A' ORDER BY `roomnumber`, `startdate`";

  $_reservationsRes = $conn->query($_reservationsSql);

  // $userReservations = $_reservationsRes->fetch_assoc();

  // var_dump for debugging
  // var_dump($userReservations);
//////////////////////////////////////////////////////////////////////////////////////
///////////HANDLE SUBMIT FOR CREATING USER
//////////////////////////////////////////////////////////////////////////////////////
  if(isset($_POST['submit']))
  {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $unsecurePass = $_POST['password'];
    $password = sha1($email . $unsecurePass);
    $classification = $_POST['classification'];
    
    $sql = "INSERT INTO `users` (`email`, `firstname`, `lastname`, `password`, `classification`) VALUES ('$email', '$fname', '$lname', '$password', '$classification')";

    if($conn->query($sql) === TRUE)
    {
      // echo "success";
      Header("Refresh: 0");
    }
    else
    {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // $_userRes = $conn->query($_userPost);
  }

?>
<!DOCTYPE html>
<html class="gr__localhost">

<head>
    <script type="text/javascript" src="chrome-extension://aadgmnobpdmgmigaicncghmmoeflnamj/ng-inspector.js"></script>
</head>

<body onload="populateBlacklistRooms(null); populateGroupList();" data-gr-c-s-loaded="true">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
    <script>
    /*
      Email search function
      Performs AJAX to retrieve_emails.php that will perform a lookup from the database of emails
      and return suggested emails as the user types.
    */
    function search(partial) {
        var parser = new DOMParser();

        if (partial == null || partial.length == 0) {
            //clear existing dropdown text if no text is entered
            document.getElementById("userInfo").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {

                    // accountArray - the suggestions that come from the retrive_emails.php call.
                    var accountArray = JSON.parse(this.responseText);
                    var runString = "";

                    //construct the dropdown contents
                    for (var i = 0; i < accountArray.length; i++) {
                        runString += "<p id = 'account_" + i + "'onclick=setEmail(\'" + accountArray[i].email + "\')>" + accountArray[i].lastname + ", " + accountArray[i].firstname + "<br>" + accountArray[i].email + " " + accountArray[i].role + "</p>";
                    }
                    console.error(runString);
                    document.getElementById("userInfo").innerHTML = runString;
                    // only toggle show when it is not showing and when the number of values returned from the database query is greater than 0
                    if (accountArray.length > 0 && !document.getElementById("userInfo").classList.contains('show')) {
                        document.getElementById("userInfo").classList.toggle("show");
                    }
                }
            };

            xmlhttp.open("GET", "search.php?q=" + partial, true);
            xmlhttp.send();

        }
    }

    /*
    Do stuff with what the user clicked in the dropdown
    */
    function setEmail(str) {
        document.getElementById("userInfo").classList.toggle("show");
        if (str.length == 0) {
            document.getElementById("userData").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("userData").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "updateUser.php?q=" + str, true);
            xmlhttp.send();
        }
    }
    </script>
    <title>Settings</title>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-content-header">
                <h1 style="color:white; left:3%;" id="modal-header-text"></h1> <span class="close">×</span></div>
            <p class="modal-content-text" id="modalMessage">Enter text</p>
            <p class="modal-center-text" id="buttonContent"></p>
        </div>
    </div>
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
    <div style="position:absolute" id="agendaReservations"></div>
    <div id="deleteRes"></div>
    <!-- Side navigation -->
    
    <style>
      .userSettingsMO {cursor: pointer;}
      .roomSettingsMO {cursor: pointer;}
      .groupSettingsMO {cursor: pointer;}
    </style>
    
    <div class="sidenav">
        <a class="userSettingsMO" id="userSettingsBtn">User Settings</a>
        <a class="roomSettingsMO" id="roomSettingsBtn">Room Settings</a>
        <a class="groupSettingsMO" id="groupSettingsBtn" style="font-size: 18.63px;">User Reservations</a>
    </div>
    <!-- Display user settings -->
    <div id="displayUserSettings" style="display: none;">
      <?php 
          include("{$_SERVER['DOCUMENT_ROOT']}/schedulingApp/includes/userSettingsInclude.php")
      ?> 
    </div>
    <!-- Display room settings -->
    <div id="displayRoomSettings" style="display: none;">
      <?php 
          include("{$_SERVER['DOCUMENT_ROOT']}/schedulingApp/includes/roomSettingsInclude.php")
      ?>
    </div>
    <!-- Display group settings -->
    <div id="displayGroupSettings" style="">
      <?php 
        include("{$_SERVER['DOCUMENT_ROOT']}/schedulingApp/includes/userReservationsInclude.php")
      ?>
    </div>
</body>

</html>