
/*
 Needed globals
 */

var showres = false;
var roomSelected = null;
selectRoom(null);
var view = "res"; // or "cal" for calendar view.

/*
 * Code added to ensure that the url always "appears" as directory/ for the index
 * but no effect is ever taken.  This is done so the interaction, redirection, and navigation
 * is consistent and offers no problems.
 *
 * Author: Dillon Borden, Derek Brown
 */
if (window.location.href.includes('index.php')) {
    var clean_uri = location.protocol + "//" + location.host + location.pathname;
    clean_uri = clean_uri.replace('index.php', '');
    window.history.replaceState({}, document.title, clean_uri);
}

//Leaves the number of seats text box grey and disabled if allowshare is not checked.
function changeSheet() {
    var checkbox = document.getElementById('allowshare');
    checkbox = (checkbox == null) ? false : checkbox.checked;
    if (checkbox == true) {
        document.getElementById('numseatstext').style.visibility = "visible";
    } else {
        document.getElementById('numseatstext').style.visibility = "hidden";
    }
}

/*
 Function that will update the room currently selected. Updates include changing the coloration of the 
 respective box in the room selection area of the page to reflect the changes.
 
 Authors: Derek, Dillon, Earl
 April 2018
 
 */
function selectRoom(id) {

    var notAvailableColor = '#1e1e1e';
    var availableUnselectedColor = "ghostwhite";
    var availableSelectedColor = "gray";
    if (roomSelected != null) {
        var normalVersion = document.getElementById(roomSelected);
        var favoriteVersion = document.getElementById('fav_' + roomSelected);
        if (favoriteVersion != null) {
            if (favoriteVersion.className.includes("notfound")) {
                favoriteVersion.style.backgroundColor = notAvailableColor;
            } else
                favoriteVersion.style.backgroundColor = availableUnselectedColor;
        }
        if (normalVersion != null) {
            normalVersion.style.backgroundColor = availableUnselectedColor;
        }
    }
    if (normalVersion == null) {
        var bookAreaParent = document.getElementById("bookArea");
        id = null;
        if (bookAreaParent != null) {
            var firstRoom = bookAreaParent.childNodes[0];
            if (firstRoom != null) {
                id = (firstRoom.className.includes("roombox")) ? firstRoom.id : null;
                // only set the id if the firstRoom is in fact a room, not some other item such as the "No Results" text.
            }


        }
    }

    if (id != null && id.substring(0, 4) == "fav_") {
        id = id.substring(4);
    }



    roomSelected = id;
    var normalVersion = document.getElementById(id);
    var favoriteVersion = document.getElementById('fav_' + id);
    if (favoriteVersion != null) {
        favoriteVersion.style.backgroundColor = availableSelectedColor;
    }
    if (normalVersion != null) {
        normalVersion.style.backgroundColor = availableSelectedColor;
    }

    if (view == "cal")
        updateCalendar();
    else
        updateReserveButtonText();
}

/*
 A function whose purpose is to populate the agenda table with the user's
 current reservations with a given email address.
 Author: Derek Brown
 Spring 2018
 */
function getAgendaReservations() {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //console.error(this.responseText);

            var reservation = JSON.parse(this.responseText);
            var runString = "<h2 style='text-align:center' >Active Reservations</h2>";
            runString += "<br><table id = 'agendaTable' >\n<th>Room</th><th>From</th><th>To</th><th>Details</th>\n";
            for (var i = 0; i < reservation.length; i++) {

                runString += "<tr id=" + i + ">\n";
                runString += "<td id=" + reservation[i].id + ">" + reservation[i].roomnumber + "</td>";
                runString += "<td>" + reservation[i].startdate + "<br>" + reservation[i].starttime + reservation[i].start + "</td>";
                runString += "<td>" + reservation[i].enddate + "<br>" + reservation[i].endtime + reservation[i].end + "</td>";
                runString += "<td><a style='color:blue' onclick=editClicked(this.parentElement.parentElement)><u style='cursor:pointer'>Edit</u></a><br><a style='color: blue' onclick=openConfirmDelete(this.parentElement.parentElement)><u style='cursor:pointer'>Remove</u></a></td>";
                runString += "</tr>\n";
            }
            runString += "</table>";

		document.getElementById('agendaReservations').innerHTML = '<img onclick="shaderClicked()" src="images/x.png" id="closeAgendaButton"></img>';
		document.getElementById("agendaReservations").innerHTML += runString;
        }
    };
    if (window.location.href.includes('PHP')) {
        xmlhttp.open("GET", "res_user.php", true);
    } else {
        xmlhttp.open("GET", "./scripts/PHP/res_user.php", true);
    }


    xmlhttp.send();
}

var switchDelete = false;
var switchCreate = false;
/*
 * A function that handles the user choice on the popup after clicking the delete on agenda.
 * it has a yes and no button, which has two unique behaviors associated with choosing either.
 * Author: Dillon Borden, Derek Brown
 */
function deleteClicked(id, id2) {

    // using the ID, we can tell which was clicked.
    if (id == "yesDelete") {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                //alert(this.responseText);
                buttonhtml = "<button class='modal-button' onclick='closeModal()'>Ok</button>"
                showMessageBox(this.responseText, "Delete Reservation", buttonhtml, false);
                document.getElementById('deleteRes').style.display = "none";
                document.body.style.backgroundColor = "rgba(0,0,0,0)";
                switchDelete = false;
                getAgendaReservations();
                updateCalendar();
            }
        };
        let temp = new Date();
        xmlhttp.open("POST", "scripts/PHP/room_remove.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("id=" + id2);
        //loadCalendar(); // reload the calendar to reflect new reservations.
    } else {
        document.getElementById('deleteRes').style.display = "none";
        document.body.style.backgroundColor = "rgba(0,0,0,0)";
        switchDelete = false;
    }
}

let lastDeleteClicked = null;
/*
 * A front-end function that opens a modal popup asking the user to confirm the deletion of their
 *	selected reservation. Originally created by @Dillon Borden, modified by @Derek Brown
 * Author: Derek Brown
 */
function openConfirmDelete(ele) {
    // first display the modal using display: block (by default should be none)
    // set id of info tag to append this info below.

    lastDeleteClicked = ele;
    buttonhtml = "<button class='modal-button' onclick='closeModal()'>Ok</button>"
    showMessageBox("<br><br>Are you sure you want to delete reservation:<br><br>" + ele.children[0].innerHTML + "<br>From:<br>" + ele.children[1].innerHTML + "<br>To:<br>" + ele.children[2].innerHTML + "<br><br><button class = 'modal-button' id='yesDelete' onclick='deleteClicked(this.id," + String(ele.children[0].id) + ")'>Yes</button><button class='modal-button' id='noDelete' onclick='closeModal()'>No</button>", "Delete Reservation", "", false);
}

/*
 Function that will update the reserve button to display text that reflects the currently selected room.
 
 Author: Derek Brown
 April 7, 2018
 */
function updateReserveButtonText() {


    if (document.getElementById('reserveButton') != null) {
        if (roomSelected != null) {
            document.getElementById('reserveButton').disabled = false;
            document.getElementById('reserveButton').value = "Reserve " + roomSelected;
        } else {
            document.getElementById('reserveButton').value = "No Room Selected";
            document.getElementById('reserveButton').disabled = true;
        }
    }
}

/*
 Function that will be called when a desire to swap views to calendar view exists.
 We call this function when swapping to the view because if you just called updateCalendar()
 by itself, the calendar shown would not have the correct data within it, since at the point of
 swapping between some views, such as redirection from the settings page, roomSelected might be
 null before the updateCalendar function is called and the calendar will instead show all reservations
 while incorrectly having a specific room selected.
 
 Author: Derek Brown.
 Date: 4/7/2018
 */
function showCalendarView() {
    view = "cal"; // change views
    fieldChanged(true); // load all rooms
    updateCalendar(); // produce the calendar.
}

/*
 AJAX call to display and update the calendar within the rightmost area of index.php.
 Author: Derek Brown
 Date: 4/7/2018
 */
function updateCalendar() {
    if (view == "cal") {
        var area = document.getElementById('createZone');
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                area.innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "scripts/PHP/calendarLoad.php?room=" + roomSelected, true);
        xhttp.send();
    }
}

/*
 AJAX call to update rightmost area of index.php with the create reservation form fields.
 Author: Derek Brown
 Date: 4/7/2018
 Edits: 
 -4/8/2018 by Dillon Borden
 - add a check to determine if a redirect to index.php should instead display the 
 calendar view, such as redirecting from settings.php.
 
 */
function showCreateResForm() {
    if (window.location.hash === "#calView") {
        showCalendarView();
        window.location.hash = "";
        var clean_uri = location.protocol + "//" + location.host + location.pathname;
        window.history.replaceState({}, document.title, clean_uri);
        return;
    }

    var area = document.getElementById('createZone');
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            area.innerHTML = this.responseText;
            updateReserveButtonText();
            view = "res";
        }
    };
    xhttp.open("GET", "scripts/PHP/resFormView.php", true);
    xhttp.send();
}

/*
 Handles any change of input field for the "Make Reservation" area. Should be called as the onchange event
 for each input field. This function will filter the rooms based on the content currently in all fields.
 
 Author: Derek Brown
 March 2018
 */
function fieldChanged(getAll) {
    var GETString = "?q=";
    //Get variables from fields
    // if getAll is true, then we skip this part and just return all rooms. Otherwise a call to
    // fieldChanged() or fieldChanged(false) will assume we are looking at the make reservation
    // screen and will probe those fields for data to use during the room retrieval.
    if (getAll == null || !getAll) {
        if (document.getElementById('responseText') != null)
            document.getElementById('responseText').innerHTML = "";
        updateReserveButtonText();
        var checkbox = false;
        if (document.getElementById('allowshare') != null) {
            var checkbox = document.getElementById('allowshare').checked;
        }
        var type = document.getElementById('typeSelect');
        var starttime = document.getElementById('timeStart');
        var endtime = document.getElementById('timeEnd');
        var recurring = document.getElementById('occur');
        var seats = document.getElementById('numberOfSeats');
        var date = document.getElementById('date');
        if (type !== null && type.selectedIndex != 0) {
            GETString += ("&type=" + type.options[type.selectedIndex].value);
        }
        if ((starttime !== null && starttime.value.length > 0) && (endtime !== null && endtime.value.length > 0) && (date !== null && date.value.length > 0)) {
            GETString += ("&starttime='" + starttime.value + "'&endtime='" + endtime.value + "'&date='" + date.value + "'");
        }
        if (recurring !== null && recurring.selectedIndex != 0) {
            GETString += ("&recur=" + recurring.selectedIndex); // pass the index, which will be our enumerated type.
        }

        if (seats !== null && seats.value.length > 0 && checkbox == true) {
            if (!(/^\+?(0|[1-9]\d*)$/.test(seats.value)) || seats.value <= 0) {
                document.getElementById('responseText').style.color = "red";
                document.getElementById('responseText').innerHTML = "Please only enter positive numbers as a headcount!";
                return;
            } else {
                GETString += ("&headcount=" + seats.value);
            }

        } else if (checkbox == true) {
            GETString += ("&headcount=" + 1);
        }
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("roomContainer").innerHTML = this.responseText;
            if (document.getElementById("allroomsheader") != null && document.getElementById("favsheader") != null) {
                document.getElementById("allroomsheader").innerHTML = "<h1 style='font-size: 19;'>All Rooms<h1>"
                document.getElementById("favsheader").innerHTML = "<h1 style='font-size: 19;'>Favorites<h1>"
            }
            selectRoom(roomSelected);
        }
    };
    xhttp.open("GET", "scripts/PHP/retrieveRooms.php" + GETString, true);
    xhttp.send();
}



function getResFormData() {

    var email = document.getElementById("owneremail").value;
    var startTime = document.getElementById("timeStart").value;
    var endTime = document.getElementById("timeEnd").value;
    var date = document.getElementById("date").value;
    var sharing = (document.getElementById("allowshare") == null) ? 0 : Number(document.getElementById("allowshare").checked);
    var startHour = startTime.charAt(0) + startTime.charAt(1);
    var startMin = startTime.charAt(3) + startTime.charAt(4);
    var endHour = endTime.charAt(0) + endTime.charAt(1);
    var endMin = endTime.charAt(3) + endTime.charAt(4);
    var numSeats = (document.getElementById("numberOfSeats") == null) ? null : document.getElementById("numberOfSeats").value;
    var comment = (document.getElementById("comment") == null) ? null : document.getElementById("comment").value;
    var occur = document.getElementById("occur");
    occur = (occur == null) ? null : occur[occur.selectedIndex].value;
    return {email: email, date: date, sharing: sharing, startHour: startHour, startMin: startMin, endHour: endHour, endMin: endMin, numSeats: numSeats, comment: comment, occur: occur};
}


/*
 Function to be called when the intention is to perform an insert into the database of a new reservation.
 will perform sanity checks and acquire variables needed to pass to CreateReservation.php. Any values obtained here
 should also be checked on the server side for sanitation.
 
 data - an optional parameter containing the data to be used in the creation of the new reservation.
 this is used on the quick reserve to facilitate passing of form data between modals that change content.
 If left null or empty, then we can assume that there exists form data that can be obtained by looking for 
 the document element by id with a call to getResFormData.
 */
function createClicked(data) {
// sanity checks first.


    if (roomSelected == null)
    {
        showMessageBoxOK("Select a room to the left and ensure all fields are complete.", "Error", false);
        return;
    }

    if (data == null)
        data = getResFormData();
    var email = data.email;
    var date = data.date;
    var sharing = data.sharing;
    var startHour = data.startHour;
    var startMin = data.startMin;
    var endHour = data.endHour;
    var endMin = data.endMin;
    var numSeats = data.numSeats;
    var comment = data.comment;
    var occur = data.occur;
    /*
     console.error("got here");
     var email = document.getElementById("owneremail").value;
     var startTime = document.getElementById("timeStart").value;
     var endTime = document.getElementById("timeEnd").value;
     var date = document.getElementById("date").value;
     var sharing = Number( document.getElementById("allowshare").checked);
     var startHour = startTime.charAt(0) + startTime.charAt(1);
     var startMin = startTime.charAt(3) + startTime.charAt(4);
     var endHour = endTime.charAt(0) + endTime.charAt(1);
     var endMin = endTime.charAt(3) + endTime.charAt(4);
     var numSeats = document.getElementById("numberOfSeats").value;
     var comment = document.getElementById("comment").value;
     var occur = document.getElementById("occur");
     
     occur = occur[occur.selectedIndex].value;
     */

    if (email == "") {
        showMessageBoxOK("Please enter an email first!", "Error", false);
        return;
    }

    if (startHour == "" || startMin == "") {
        showMessageBoxOK("Please enter a full start time first!", "Error", false);
        return;
    }

    if (endHour == "" || endMin == "") {

        showMessageBoxOK("Please enter a full end time first!", "Error", false);
        return;
    }

    if (/^\d+$/.test(startHour) && /^\d+$/.test(startMin)) {
        // Contain numbers only
    } else {
        // Contain other characters also
        showMessageBoxOK("Please only enter numbers in start time boxes!", "Error", false);
        return;
    }

    // check headcount
    if (sharing) {
        if (!(/^\+?(0|[1-9]\d*)$/.test(numSeats)) || numSeats <= 0) {
            showMessageBoxOK("Please only enter positive numbers as a headcount!", "Error", false);
            return;
        }
    }

    if (startMin.length > 2 || endMin.length > 2) {
        showMessageBoxOK("Times can only be 2 numbers in length!", "Error", false);
        return;
    }



    if (/^\d+$/.test(endHour) && /^\d+$/.test(endMin)) {
        // Contain numbers only
    } else {
        // Contain other characters also
        showMessageBoxOK("Please only enter numbers in end time boxes!", "Error", false);
        return;
    }

    if (sharing == 1 && numSeats == "") {
        showMessageBoxOK("Please specifiy a number of seats needed, or disable sharing.", "Error", false);
        return;
    }

    // ajax call to create script.


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById('responseText').innerHTML = this.responseText;
            showMessageBoxOK(this.responseText, "Make Reservation", false);
            updateCalendar();
            clearFields();
        }
    };
    xhttp.open("POST", "scripts/PHP/CreateReservation.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("roomnumber=" + roomSelected + "&owneremail=" + email + "&allowshare=" + sharing + "&numberOfSeats=" + numSeats + "&starthour=" + startHour + "&startminute=" + startMin + "&date=" + date + "&endhour=" + endHour + "&endminute=" + endMin + "&occur=" + occur + "&comment=" + comment);
}



/*
 Function to be called when the intention is to perform an insert into the database of a new reservation.
 will perform sanity checks and acquire variables needed to pass to CreateReservation.php. Any values obtained here
 should also be checked on the server side for sanitation.
 
 function createClicked(){
 // sanity checks first.
 document.getElementById('responseText').innerHTML = "";
 if (roomSelected == null)
 {
 document.getElementById('responseText').style.color = "red";
 document.getElementById('responseText').innerHTML = "Select a room to the left and ensure all fields are complete.";
 return;
 }
 
 var email = document.getElementById("owneremail").value;
 var startTime = document.getElementById("timeStart").value;
 var endTime = document.getElementById("timeEnd").value;
 var date = document.getElementById("date").value;
 var sharing = Number( document.getElementById("allowshare").checked);
 var startHour = startTime.charAt(0) + startTime.charAt(1);
 var startMin = startTime.charAt(3) + startTime.charAt(4);
 var endHour = endTime.charAt(0) + endTime.charAt(1);
 var endMin = endTime.charAt(3) + endTime.charAt(4);
 var numSeats = document.getElementById("numberOfSeats").value;
 var comment = document.getElementById("comment").value;
 var occur = document.getElementById("occur");
 
 occur = occur[occur.selectedIndex].value;
 if (email == ""){
 document.getElementById('responseText').style.color = "red";
 document.getElementById('responseText').innerHTML = "Please enter an email first!";
 return;
 }
 
 if (startHour == "" || startMin == ""){
 document.getElementById('responseText').style.color = "red";
 document.getElementById('responseText').innerHTML = "Please enter a full start time first!";
 return;
 }
 
 if (endHour == "" || endMin == ""){
 document.getElementById('responseText').style.color = "red";
 document.getElementById('responseText').innerHTML = "Please enter a full end time first!";
 return;
 }
 
 if (/^\d+$/.test(startHour) && /^\d+$/.test(startMin)) {
 // Contain numbers only
 }
 else {
 // Contain other characters also
 document.getElementById('responseText').style.color = "red";
 document.getElementById('responseText').innerHTML = "Please only enter numbers in start time boxes!";
 return;
 }
 
 // check headcount
 if(sharing){
 if (!(/^\+?(0|[1-9]\d*)$/.test(numSeats)) || numSeats <=0) {
 document.getElementById('responseText').style.color = "red";
 document.getElementById('responseText').innerHTML = "Please only enter positive numbers as a headcount!";
 return;
 }
 }
 
 if (startMin.length > 2 || endMin.length > 2){
 document.getElementById('responseText').style.color = "red";
 document.getElementById('responseText').innerHTML = "Times can only be 2 numbers in length!";
 return;
 }
 
 
 
 if (/^\d+$/.test(endHour) && /^\d+$/.test(endMin)) {
 // Contain numbers only
 }
 else {
 // Contain other characters also
 document.getElementById('responseText').style.color = "red";
 document.getElementById('responseText').innerHTML = "Please only enter numbers in end time boxes!";
 return;
 }
 
 if (document.getElementById('allowshare').checked == true && numSeats == ""){
 document.getElementById('responseText').style.color = "red";
 document.getElementById('responseText').innerHTML = "Please specifiy a number of seats needed, or disable sharing.";
 return;
 }
 
 // ajax call to create script.
 console.log('here');
 
 var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
 if (this.readyState == 4 && this.status == 200) {
 //document.getElementById('responseText').innerHTML = this.responseText;
 showMessageBoxOK(this.responseText,"Make Reservation", false);
 clearFields();
 }
 };
 xhttp.open("POST", "scripts/PHP/CreateReservation.php", true);
 xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xhttp.send("roomnumber=" + roomSelected + "&owneremail=" + email + "&allowshare=" + sharing + "&numberOfSeats=" + numSeats + "&starthour=" + startHour + "&startminute=" + startMin + "&date=" + date + "&endhour=" + endHour + "&endminute=" + endMin + "&occur=" + occur + "&comment=" + comment);
 
 }
 
 */

/*
 * A function implemented with the favorites feature that handles a click on the star of a room div.
 * If the star is already an image representing a favorite, it will unfavorite that room and changes
 * will be reflected in the database. It acts like a toggle switch between fav and unfav.
 * Original implementation by @Dillon Borden, modification by @Derek Brown for flexboxes.
 * Author: Dillon Borden, Derek Brown
 */
function favoriteClicked(parentEle) {
    let star = document.getElementById(parentEle.id);
    var roomId = parentEle.id;
    if (roomId.substring(0, 4) == "fav_") {
        roomId = roomId.substring(4);
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            fieldChanged();
        }
    };
    xhttp.open("POST", "scripts/PHP/favorite.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if (star.children[0].src.includes("images/fav-unselect.png")) {
        // add a favorite.
        xhttp.send("add=yes&roomid=" + roomId);
    } else {
        // remove a favorite.
        xhttp.send("add=no&roomid=" + roomId);
    }
}

/*
 * Handles the onclick event for the "shader" div.  the shader div is used to make the background behind
 * a popup window look darker.  If the user clicks outside of the popup then the popup should minimize.
 * Author: Dillon Borden
 */
function shaderClicked() {
    showres = false;
    //document.body.style.backgroundColor = "rgba(0,0,0,1)";
    document.getElementById('agendaReservations').style.display = "none";
    document.getElementById('deleteRes').style.display = "none";
    document.getElementById('shader').style.display = "none";
}

/*
 * Front-end UI function to toggle on and off the showing of "My Agenda" reservations popup.
 * Author: Dillon Borden
 */
function dropdownRes() {
    getAgendaReservations();
    //
    if (showres == false) {
        showres = true;
        //document.body.style.backgroundColor = "rgba(0,0,0,0.5)";
        document.getElementById('agendaReservations').style.display = "block";
        document.getElementById('shader').style.display = "block";
    } else {
        showres = false;
        //document.body.style.backgroundColor = "rgba(0,0,0,1)";
        document.getElementById('agendaReservations').style.display = "none";
        document.getElementById('deleteRes').style.display = "none";
        document.getElementById('shader').style.display = "none";
    }

}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {

        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

/*
 Funciton to be called when the user desires to log out manually.
 * Author(s): Dillon Borden, Derek Brown, Earl Clark, 
 */
function logoutUser() {


    if (window.location.href.includes('scripts/PHP/')) {
        window.location.href = 'logout.php';
    } else {
        if (window.location.href.includes('index.php')) {
            window.location.href += '/scripts/PHP/logout.php';
        } else {
            window.location.href += 'scripts/PHP/logout.php';
        }

    }
}





/*
 Function to be called when the make reservation button has been clicked. Opens a confirmation dialog to
 ask the user to confirm their reservation details.
 Author: Derek Brown
 Date: 4/2/2018
 
 
 function openConfirmCreate(){
 if (roomSelected == null){
 document.getElementById('responseText').style.color = "red";
 document.getElementById('responseText').innerHTML = "Select a room to the left and ensure all fields are complete.";
 return;
 }
 
 var details = "";
 var xhttp = new XMLHttpRequest();
 console.error("here");
 xhttp.onreadystatechange = function() {
 if (this.readyState == 4 && this.status == 200) {
 
 details = this.responseText;
 buttonhtml =  "<button class='modal-button' onclick='closeModal(); createClicked();'>Book it!</button><button class='modal-button' onclick='closeModal()'>Cancel</button>"
 showMessageBox("Are you sure you want to reserve " + roomSelected + "?<br>" + details ,"Confirm",buttonhtml, false);
 }
 console.error(this);
 };
 
 xhttp.open("GET", "scripts/PHP/Confirmation.php?resEmail=" + email + "&allowshare=" + sharing + "&numberOfSeats=" + numSeats + "&timeStart=" + startHour + ":" + startMin + "&date=" + date + "&timeEnd=" + endHour + ":" + endMin + "&occur=" + occur + "&comment=" + comment);
 xhttp.send();
 
 
 }
 
 */

/*
 Function to clear input fields under the Make Reservation section.
 Author: Derek Brown
 Date: 4/2/2018
 
 */
function clearFields() {

    if (document.getElementById('responseText') != null)
        document.getElementById('responseText').innerHTML = "";
    if (document.getElementById('occur') != null)
        document.getElementById("occur").selectedIndex = 0;
    if (document.getElementById('typeSelect') != null)
        document.getElementById("typeSelect").selectedIndex = 0;
    if (document.getElementById('timeStart') != null)
        document.getElementById("timeStart").value = '';
    if (document.getElementById('timeEnd') != null)
        document.getElementById("timeEnd").value = '';
    //document.getElementById("date").value= '';
    changeSheet();
    //document.getElementById("allowshare").checked= false;
    if (document.getElementById('numberOfSeats') != null)
        document.getElementById("numberOfSeats").value = '';
    if (document.getElementById('comment') != null)
        document.getElementById("comment").value = '';
    fieldChanged();
}


function showDayViewModal(date, room, showQuickBook) {
    var quickBook = "";
    if (showQuickBook) {
        quickBook = '<hr><h1>Quick Reserve</h1><form id = "quickBookForm" onsubmit="openConfirmCreate(getResFormData()); return false;">Duration*:<input id = "timeStart"  name = "startTime "type = "time" step = "900" width = "48" onchange = "" required>\
		- <input id = "timeEnd" name = "endTime" type = "time" step = "900" width = "48" onchange = "" required><br> \
		Reserving for*:<input type="text" id="owneremail" value="" required><br>\
		Brief Comment: <input type="text" id="comment"><br><input type="hidden" id="date" value="' + date + '"><input type="hidden" id="allowshare" value="0" >\
		<input id="reserveButton" type="submit" value="Quick Reserve"> </form>';
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("").innerHTML = this.responseText;
            showMessageBox(this.responseText, "Day View - " + roomSelected + " for " + date, quickBook, true);
        }
    };
    xhttp.open("GET", "scripts/PHP/dayView.php?date=" + date + "&room=" + room, true);
    xhttp.send();
}

/*
 Function to be called when the make reservation button has been clicked. Opens a confirmation dialog to
 ask the user to confirm their reservation details.
 
 data - an optional parameter containing the data to be used in the creation of the new reservation.
 this is used on the quick reserve to facilitate passing of form data between modals that change content.
 If left null or empty, then we can assume that there exists form data that can be obtained by looking for 
 the document element by id with a call to getResFormData.
 
 
 Author: Derek Brown
 Date: 4/2/2018 
 */


function openConfirmCreate(data) {
    var response = document.getElementById('responseText');
    if (roomSelected == null && response != null) {
        response.style.color = "red";
        response.innerHTML = "Select a room to the left and ensure all fields are complete.";
        return;
    }

    //buttonhtml =  "<button class='modal-button' onclick='closeModal(); createClicked(data);'>Book it!</button><button class='modal-button' onclick='closeModal()'>Cancel</button>"
    buttonhtml = "<button id='ConfirmClickCreateButton' class='modal-button'>Book it!</button><button class='modal-button' onclick='closeModal()'>Cancel</button>"
    showMessageBox("Are you sure you want to reserve " + roomSelected + "?", "Confirm", buttonhtml, false);
    // to pass data, we have to use an anon function.
    document.getElementById('ConfirmClickCreateButton').onclick = function () {
        closeModal();
        createClicked(data);
    };
}


function calendarDateClicked(date) {
    showDayViewModal(date.substring(3), roomSelected, true);
}

/*
 * Handles the event for calendar navigation between months based on the selected room.
 * Can be either forward or backward by month when clicked.
 * Author: Dillon Borden
 */
function calendarNavi(month, year) {
    var area = document.getElementById('createZone');
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            area.innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "scripts/PHP/calendarLoad.php?month=" + month + "&year=" + year + "&room=" + roomSelected, true);
    xhttp.send();
}

/*
 * A switch function which takes a month number 01-12 and returns a string for the month.
 *
 * Author: Dillon Borden
 */
function findDay(dayNum) {
    switch (dayNum) {
        case "01":
            return "January";
        case "02":
            return "February";
        case "03":
            return "March";
        case "04":
            return "April";
        case "05":
            return "May";
        case "06":
            return "June";
        case "07":
            return "July";
        case "08":
            return "August";
        case "09":
            return "September";
        case "10":
            return "October";
        case "11":
            return "November";
        case "12":
            return "December";
    }
}

/*
	Function that is accessed on the group settings page "groupSettings.php" and is
	used to populate the list of rooms obtained through AJAX to the retrieveBlacklistRooms
	php script. 
	Author: Derek Brown
	Date: 4/27/2018
*/
function populateBlacklistRooms(groupChosen){
	var e = document.getElementById('roomContainer');
	var header = document.getElementById('groupheader');
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			e.innerHTML = this.responseText;
			var name = document.getElementById(groupChosen);
			if(name !=null)
				header.innerHTML = "Blaklist for " + name.innerHTML;
		}
	};
	xhttp.open("GET", "retrieveBlacklistRooms.php?groupID=" + groupChosen);
	xhttp.send();
	

}

/*
	Obtains all groups listed in the database and places them in the groups area div
	on groupSettings.php.
	Author: Derek Brown
	Date: 4/27/2018
*/
function populateGroupList(){
	var e = document.getElementById('groupsArea');

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			e.innerHTML = this.responseText;

		}
	};
	xhttp.open("GET", "retrieveGroups.php");
	xhttp.send();
	

}

function updateBlacklist(groupid, roomid, bool_addToBlacklist){
	console.error(roomid);
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.error(this.responseText);
			populateBlacklistRooms(groupid);
		}
	};
	xhttp.open("POST", "updateBlacklists.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	if (bool_addToBlacklist){
		// add to blacklist
		xhttp.send("groupID="+groupid+"&roomid=" + roomid+"&operation='add'");
	}
	else{
		// remove from blacklist
		xhttp.send("groupID="+groupid+"&roomid=" + roomid+"&operation='remove'");
	}
}

/*
 function openCreateRes(id){
 if (id.length < 5){
 return;
 }
 
 let date = id.substr(3);
 let year = date.slice(0, 4);
 let month = date.slice(5, 7);
 month = findDay(month);
 let day = date.slice(8,10);
 let roomChoice = roomSelected;
 if (roomChoice == null){
 roomChoice = "All Rooms";
 }
 let formattedLabel = day + " " + month + " " + year + " - " + roomChoice;
 
 
 document.getElementById('createRes').style.display = "inline";
 document.body.style.backgroundColor = "rgba(0,0,0,0.5)";
 document.getElementById('createRes').innerHTML = "";
 // AJAX CALL HERE.
 
 var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
 if (this.readyState == 4 && this.status == 200) {
 document.getElementById("createRes").innerHTML = this.responseText;
 document.getElementById('createLabel').innerHTML = formattedLabel;
 }
 };
 xhttp.open("POST", "scripts/PHP/Reservations.php", true);
 xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 console.error(roomChoice);
 xhttp.send("date=" + date + "&room=" + roomChoice);
 }
 
 function typeChanged(id){
 var e = document.getElementById('compSelect');
 var f = document.getElementById('floorSelect');
 if (id == "Any" && e.options[e.selectedIndex].value == "Any" && f.options[f.selectedIndex].value == "Any"){
 var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
 if (this.readyState == 4 && this.status == 200) {
 document.getElementById("roominsert").innerHTML = this.responseText;
 }
 };
 xhttp.open("GET", "scripts/PHP/allrooms.php", true);
 xhttp.send();
 }
 else{
 var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
 if (this.readyState == 4 && this.status == 200) {
 document.getElementById("roominsert").innerHTML = this.responseText;
 }
 };
 xhttp.open("GET", "scripts/PHP/roombytype.php?type=" + id + "&floor=" + f.options[f.selectedIndex].value + "&comp=" + e.options[e.selectedIndex].value, true);
 xhttp.send();
 }
 
 
 }
 
 function floorChanged(id){
 var e = document.getElementById('typeSelect');
 var f = document.getElementById('compSelect');
 if (id == "Any" && e.options[e.selectedIndex].value == "Any" && f.options[f.selectedIndex].value == "Any"){
 var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
 if (this.readyState == 4 && this.status == 200) {
 document.getElementById("roominsert").innerHTML = this.responseText;
 }
 };
 xhttp.open("GET", "scripts/PHP/allrooms.php", true);
 xhttp.send();
 }
 else{
 var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
 if (this.readyState == 4 && this.status == 200) {
 document.getElementById("roominsert").innerHTML = this.responseText;
 }
 };
 xhttp.open("GET", "scripts/PHP/roombytype.php?type=" + e.options[e.selectedIndex].value + "&floor=" + id + "&comp=" + f.options[f.selectedIndex].value, true);
 xhttp.send();
 }
 
 }
 
 function compChanged(id){
 var e = document.getElementById('typeSelect');
 var f = document.getElementById('floorSelect');
 if (id == "Any" && e.options[e.selectedIndex].value == "Any" && f.options[f.selectedIndex].value == "Any"){
 var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
 if (this.readyState == 4 && this.status == 200) {
 document.getElementById("roominsert").innerHTML = this.responseText;
 }
 };
 xhttp.open("GET", "scripts/PHP/allrooms.php", true);
 xhttp.send();
 }
 else{
 var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
 if (this.readyState == 4 && this.status == 200) {
 document.getElementById("roominsert").innerHTML = this.responseText;
 }
 };
 xhttp.open("GET", "scripts/PHP/roombytype.php?type=" + e.options[e.selectedIndex].value + "&floor=" + f.options[f.selectedIndex].value + "&comp=" + id, true);
 xhttp.send();
 }
 
 }
 
 function toggleRoomView()
 {
 if (showrooms == false)
 {
 showrooms = true;
 document.getElementById('roomMenu').style.display = "inline";
 document.getElementById('roomSelect').style.top = "88%";
 document.getElementById('roomWrapper').style.display = "none";
 document.getElementById('selectedRoom').style.top = "88%";
 document.getElementById('roomSelect').src = "images/up_arrow.png";
 document.body.style.backgroundColor = "rgba(0,0,0,0.5)";
 }
 else
 {
 showrooms = false;
 document.getElementById('roomMenu').style.display = "none";
 document.getElementById('roomSelect').style.top = "14%";
 document.getElementById('roomWrapper').style.display = "inline";
 document.getElementById('selectedRoom').style.top = "14%";
 document.getElementById('roomSelect').src = "images/down_arrow.png";
 document.body.style.backgroundColor = "rgba(0,0,0,0)";
 }
 }
 
 
 */
function updateClicked() {
    // sanity checks first.

    var roomnumber = document.getElementById("roomnumber").value;
    var id = document.getElementById("id").innerHTML;
    var email = document.getElementById("owneremail").value;
    var startTime = document.getElementById("startTime").value;
    var endTime = document.getElementById("endTime").value;
    var startDate = document.getElementById("date").value;
    var endDate = document.getElementById("date").value;
    var headcount = document.getElementById("headcount").innerHTML;
    var allowshare = document.getElementById("allowshare").innerHTML;
    if (allowshare == "Yes") {
        allowshare = 1;
    } else {
        allowshare = 0;
    }

    var startHour = startTime.charAt(0) + startTime.charAt(1);
    var startMin = startTime.charAt(3) + startTime.charAt(4);
    var endHour = endTime.charAt(0) + endTime.charAt(1);
    var endMin = endTime.charAt(3) + endTime.charAt(4);
    var comment = document.getElementById("comment").value;
    if (email == "") {
        document.getElementById('responseText').style.color = "red";
        document.getElementById('responseText').innerHTML = "Please enter an email first!";
        return;
    }

    if (startHour == "" || startMin == "") {
        document.getElementById('responseText').style.color = "red";
        document.getElementById('responseText').innerHTML = "Please enter a full start time first!";
        return;
    }

    if (endHour == "" || endMin == "") {
        document.getElementById('responseText').style.color = "red";
        document.getElementById('responseText').innerHTML = "Please enter a full end time first!";
        return;
    }

    if (/^\d+$/.test(startHour) && /^\d+$/.test(startMin)) {
        // Contain numbers only
    } else {
        // Contain other characters also
        document.getElementById('responseText').style.color = "red";
        document.getElementById('responseText').innerHTML = "Please only enter numbers in start time boxes!";
        return;
    }

    if (startMin.length > 2 || endMin.length > 2) {
        document.getElementById('responseText').style.color = "red";
        document.getElementById('responseText').innerHTML = "Times can only be 2 numbers in length!";
        return;
    }

    if (Number(startMin) > 59 || Number(endMin) > 59) {
        document.getElementById('responseText').style.color = "red";
        document.getElementById('responseText').innerHTML = "Times cannot be bigger than 60 minutes!";
        return;
    }

    if (/^\d+$/.test(endHour) && /^\d+$/.test(endMin)) {
        // Contain numbers only
    } else {
        // Contain other characters also
        document.getElementById('responseText').style.color = "red";
        document.getElementById('responseText').innerHTML = "Please only enter numbers in end time boxes!";
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('responseText').style.color = "black";
            document.getElementById('responseText').innerHTML = this.responseText;
            getAgendaReservations();
        }
    };
    xhttp.open("POST", "./scripts/PHP/updateReservation.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id + "&owneremail=" + email + "&roomnumber=" + roomnumber + "&startTime=" + startTime + "&startDate=" + startDate + "&endDate=" + endDate + "&endTime=" + endTime + "&allowshare=" + allowshare + "&headcount=" + headcount + "&comment=" + comment);
}

function editClicked(ele) {
    var id = String(ele.children[0].id);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var editHtml = this.responseText;
            var buttonHtml = "<button class='modal-button' onclick='updateClicked();'>Update</button>";
            showMessageBox(editHtml, "Edit", buttonHtml, true);
        }
    };
    xhttp.open("POST", "scripts/PHP/editClicked.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}

