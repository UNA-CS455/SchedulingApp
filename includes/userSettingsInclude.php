<link rel="shortcut icon" type="image/x-icon" href="../../favicon.ico">
<link rel="stylesheet" href="../../styles/rooms.css">
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
    <!--             <div class="modal-content">
                <div class="modal-content-header">
                    <h1 style="color:white; left:3%;" id="modal-header-text"></h1> <span class="close">×</span></div>
                <p class="modal-content-text" id="modalMessage">Enter text</p>
                <p class="modal-center-text" id="buttonContent"></p>
            </div> -->
</div>
<div id="shader" onclick="shaderClicked()"></div>
<script src="../JS/popup.js"></script>
<script src="../JS/rooms.js"></script>
<div id="room">

  <br/>

  <h1>User Settings</h1>
  <br>
  <div class="container dropdown">
    <div class="row">
      <div class="col-md-4">
        <form>
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" id="emailInput" type="text" onkeyup="search(this.value)">
            </div>
        </form>
      </div>
    </div>
    <div id="userInfo" class="dropdown-content"></div>
    <div id="userData"></div>
  </div>
</div>