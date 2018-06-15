<link rel="shortcut icon" type="image/x-icon" href="../../favicon.ico">
<link rel="stylesheet" href="../../styles/rooms.css">
<link rel="stylesheet" href="../../styles/popup.css">
<script>
function findRoom(str) {
    if (str.length == 0) {
        document.getElementById("roomInfo").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("roomInfo").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "getRooms.php?q=" + str, true);
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
<div id="shader" onclick="shaderClicked()"></div>
<script src="../JS/popup.js"></script>
<script src="../JS/rooms.js"></script>
<div style="position:absolute" id="agendaReservations"></div>
<div id="deleteRes"></div>
<div id="room">
    
  <br/>

  <h1> Room Settings </h1>

  <br/>
  <div class="container dropdown">
    <div class="row">
      <div class="col-md-4">
        <form>
          <div class="form-group">
            <label for="findRoom">Search Room:</label>
            <input class="form-control" type="text" onkeyup="findRoom(this.value)">
          </div>
        </form>
      </div>
    </div>
  </div>
  <p> <span id="roomInfo"></span></p>
</div>
