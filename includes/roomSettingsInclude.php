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

    <!-- <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-3">
        <form>
          <div class="form-group">
            <label for="findRoom">Search Room:</label>
            <input class="form-control" type="text" onkeyup="findRoom(this.value)">
          </div>
        </form>
      </div>
    </div> -->
    <a href="createEditRoom.php">
      <button class="btn btn-success">
        <span>Create Room&nbsp;&nbsp;<i class="fas fa-plus"></i></span>
      </button>
    </a>

    <div class="row roomTable" style="max-height: 400px; overflow-y: scroll; display: block;">
      <div class="col-md-9">
        <table class="table table-responsive">
          <thead>
            <th>
              Room Name
            </th>
            <th>
              Type
            </th>
            <!-- Is the floor really necessary? -->
            <!-- <th>
              Floor
            </th> -->
            <th>
              Seats
            </th>
            <th>
              Has computers
            </th>
            <th>
              Number Computers
            </th>
            <th>
              Actions
            </th>
          </thead>
          <tbody>
            <?php
              /*
                $_roomResponse is pulled as an array:
                0: roomid
                1: type
                2: floor
                3: seats
                4: hasconputers
                5: numcomputers
                6: numeric_id
  
              */
              if($_roomResponse > 0)
              {
                foreach($_roomResponse as $roomRes)
                {
                  echo '<tr>';
                  echo '<td>' . $roomRes[0]. '</td>';
                  echo '<td>' . $roomRes[1]. '</td>';
                  echo '<td>' . $roomRes[3]. '</td>';
                  // echo '<td>' . $roomRes[4]. '</td>';
                  if($roomRes[4] == 1)
                  {
                    echo '<td>Yes</td>';
                  }
                  else
                  {
                    echo '<td>No</td>';
                  }
                  if($roomRes[5] == 0){
                    echo '<td>' . '' . '</td>';
                  }
                  else{
                    echo '<td>' . $roomRes[5]. '</td>';
                  }
                  echo '<td>';
                  echo '<a style="margin-right: 5px;" class="btn btn-default editBtn" href="createEditRoom.php?roomid=' . $roomRes [0] . '"><i class="fas fa-pencil-alt"></i></a>';
                  echo '<a style="margin-right: 5px;" class="btn btn-default" href="deleteRoom.php?roomid=' . $roomRes[0].'"><i class="fas fa-trash-alt"></i></a>';
                  echo '</td></tr>';
                }
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>

  <p> <span id="roomInfo"></span></p>
</div>
