























function openConfirmCreateUser(name)
{
	// first display the modal using display: block (by default should be none)
	// set id of info tag to append this info below.

// 	buttonhtml = "<button class='modal-button' onclick='closeModal()'>Ok</button>"; //this was missing a semicolon? unsure why, added it back in.
    buttonhtml = "<br> <br><button class = 'modal-button btn btn-success' id='yesAddWL' onclick='insertUserWhitelist()'>Yes</button> <button class='modal-button btn btn-danger' id='noAddWL' onclick='closeModal()'>No</button>";
	showMessageBox("<br><br>Are you sure you want to add:<br><br>" + name + buttonhtml, "Add user", "", false);

}