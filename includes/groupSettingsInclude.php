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
        <div id="room">
            <h1> Group Settings </h1>
            <br>
            <div class="groupsFrame" id="groupsArea">
                <button style="width:100%; height:40px; position:relative;" id="1" onclick="populateBlacklistRooms(this.id)">A</button>
                <button style="width:100%; height:40px; position:relative;" id="2" onclick="populateBlacklistRooms(this.id)">U</button>
                <button style="width:100%; height:40px; position:relative;" id="createNewGroupButton" onclick="showMessageBox('<form><p>Group Name:</p><input type=\'text\' id=\'groupnameinput\' required><br>','Add New Group', '<button onclick=\'addNewGroup()\'>Create</button></form>',true);"> Create New Group </button>
            </div>
            <h1 id="groupheader"></h1>
            <div id="roomContainer">
                <h4> Select a group to edit its properties. </h4></div>
            <span id="deleteGroupButtonArea"></span>
        </div>