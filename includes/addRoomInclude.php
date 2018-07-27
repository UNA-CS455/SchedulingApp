<?php
  session_start();

  $roomid = $_POST['roomid'];
?>
<body>
    <div id="shader" onclick="shaderClicked()"></div>
    <script src="../JS/popup.js"></script>
    <script src="../JS/rooms.js"></script>
    <div style="position:absolute" id="agendaReservations"></div>
    <div id="deleteRes"></div>
    <div class="d" ; <table id="pages">
        <tr>
            <th>Pages</th>
        </tr>
        <tr>
            <td>
                <br>
                <button class="settingsButton" onclick="location.href='userSettings.php';">User Settings</button>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <button class="settingsButton" onclick="location.href='roomSettings.php';">Room Settings</button>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <button class="settingsButton" onclick="location.href='groupSettings.php';">Group Settings</button>
            </td>
            <br>
        </tr>
        </table>
    </div>
    <div id="room">
        <h1> Room Settings </h1>
        <br>
        <p>
            <span id="roomInfo"></span>
            <table>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <form action="doAddRoom.php" method="POST">
                    <?php
                      echo "<tr><td>Room Number:</td><td><input type='text' value='$roomid' name='roomid'></td></tr>";
                    ?>
                        <tr>
                            <td> Room type: </td>
                            <td>
                                <select name='type'>
                                    <option value='Classroom' selected='selected'>Classroom</option>
                                    <option value='Conference'>Conference Room</option>
                                    <option value='Computer Lab'>Computer Lab</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td> Floor number: </td>
                            <td>
                                <input type='text' name='floor'>
                            </td>
                        </tr>
                        <tr>
                            <td> Seats: </td>
                            <td>
                                <input type='text' name='seats'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type='submit' value='Add Room'>
                </form>
                </td>
                </tr>
            </table>
        </p>
    </div>
</body>