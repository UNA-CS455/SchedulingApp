<link rel="shortcut icon" type="image/x-icon" href="../../favicon.ico">
<link rel="stylesheet" href="../../styles/rooms.css">
<link rel="stylesheet" href="../../styles/popup.css">

<title>Settings</title>
<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <!--    <div class="modal-content">
              <div class="modal-content-header">
                  <h1 style="color:white; left:3%;" id="modal-header-text"></h1> <span class="close">×</span></div>
              <p class="modal-content-text" id="modalMessage">Enter text</p>
              <p class="modal-center-text" id="buttonContent"></p>
            </div> -->
</div>
<div id="shader" onclick="shaderClicked()"></div>
<script src="../JS/popup.js"></script>
<script src="../JS/rooms.js"></script>
<div class="container" id="room">

  <br />

  <h1>User Reservations</h1>
  <br>
  <!-- <div class="container dropdown">
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
  </div> -->
  <button class="btn btn-success createUsrBtn">
    <span>Create user&nbsp;&nbsp;<i class="fas fa-plus"></i></span>
  </button>

  <br />
  <br />
  <div class="row usrTable"
    style="display: block; max-height: 400px; overflow-y: auto;">
    <div class="col-md-9">
      <table class="table table-responsive">
        <thead>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Classification</th>
          <th>Group ID</th>
          <th>Actions</th>
        </thead>
        <tbody>
          <?php
                    /*
                     * $_userRes is pulled as an array:
                     * 0: email
                     * 1: firstname
                     * 2: lastname
                     * 3: password
                     * 4: classification
                     * 5: groupID
                     */
                    if ($_userRes > 0)
                    {
                      foreach ( $_userRes as $user )
                      {
                        echo '<tr>';
                        echo '<td>' . $user [1] . '</td>';
                        echo '<td>' . $user [2] . '</td>';
                        echo '<td>' . $user [0] . '</td>';
                        echo '<td>' . $user [4] . '</td>';
                        //echo '<td>' . $user [5] . '</td>';
                        echo '<td>';
                        echo '<a style="margin-right: 5px;" class="btn btn-default editBtn" href="editUser.php?email=' . $user [0] . '"><i class="fas fa-pencil-alt"></i></a>';
                        echo '<a style="margin-right: 5px;" class="btn btn-default" href="deleteUser.php?email=' . $user [0] . '"><i class="fas fa-trash-alt"></i></a>';
                        echo '</td></tr>';
                      }
                    }
                    ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="createUsrDiv row" style="display: none;">
    <form name="createUser" method="POST" action="">
      <div class="row">
        <br />
        <div class="col-md-4">
          <label for="firstname">First Name</label>
          <input type="text" name="firstname" class="form-control">
        </div>
        <!-- /.col-lg-3 -->
        <div class="col-md-4">
          <label for="lastname">Last Name</label>
          <input type="text" name="lastname" class="form-control">
        </div>
        <!-- /.col-lg-3 -->
      </div>
      <div class="row">
        <br />
        <div class="col-md-3">
          <label for="email">Email</label>
          <input type="text" name="email" class="form-control">
        </div>
        <div class="col-md-3">
          <label for="password">Password</label>
          <input type="text" name="password" class="form-control">
        </div>
        <div class="col-md-2">
          <label for="classification">Classification</label>
          <select class="form-control" id="classification"
            name="classification">
            <option value="">Select One</option>
            <option value="ADMIN">Admin</option>
            <option value="USER">User</option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <br />
          <button class="btn btn-secondary" id="submit" name="submit"
            type="submit">Submit</button>
        </div>
      </div>
    </div>
  </form>
</div>
</div>

<script>
  $(document).ready(function()
  {
    $('.createUsrBtn').click(function()
    {
      $('.usrTable').toggle();
      $('.createUsrDiv').toggle();
    })
  })
</script>
