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

	<h1>User Settings</h1>
	<br>
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
					<!-- <th>Group ID</th -->
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
