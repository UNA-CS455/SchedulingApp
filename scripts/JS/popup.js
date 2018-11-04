/******************************************************************************
Popup Javascript Functionality Script
Description: Provides behavior necessary to make pop-ups easy to achieve. To
use, just place 

	<?php include '<insert path here>/modal.php'; ?>
	<script src="<insert path here>/popup.js"></script>

at the start of the <body> tag in a php web page. Place

	<link rel="stylesheet" href="<insert path here>/popup.css">

modal.php contains the modal, popup.js is this file and contains showMessageBox
function needed for making the modal show, popup.css contains all styling needed
for the modal popup. To change content and allow the modal to pop up, simply call

showMessageBox(message,header,buttonhtml, allowClickOutsideClose)

wherever you wish to trigger the modal popup, such as an onclick even for a button,
where:

	***************************************
	*header                             X *
	***************************************
	*									  *
	* message							  *
	*									  *	
	*		     buttonhtml 			  *
	***************************************

is the layout of the modal. If allowClickOutsideClose is true, then clicking outside
the modal will close the box. False will require the X being pressed or manually
having the buttonhtml button close it.
Note: buttonhtml is literally html code for buttons, but you could give any html
code to this, so you could even insert images, tables, etc. Same goes for message.


Author: Derek Chase Brown
Date: 4/2/2018


******************************************************************************/


function showMessageBox(message,header,buttonhtml, allowClickOutsideClose){
	// Get the modal
	var modal = document.getElementById('myModal');
	
	// set content
	document.getElementById('modal-header-text').innerHTML = header;
	document.getElementById('modalMessage').innerHTML = message;
	document.getElementById('buttonContent').innerHTML = buttonhtml;

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on the button, open the modal 
	modal.style.display = "block";

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		closeModal();
	}

	// When the user clicks anywhere outside of the modal, close it
	
	window.onclick = function(event) {
		if(allowClickOutsideClose == true){
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	}
	

}

function showMessageBoxOK(message,header, allowClickOutsideClose){
	// Get the modal
	var modal = document.getElementById('myModal');
	
	// set content
	document.getElementById('modal-header-text').innerHTML = header;
	document.getElementById('modalMessage').innerHTML = message;
	document.getElementById('buttonContent').innerHTML = "<button class='modal-button btn btn-default' onclick='closeModal()'>Ok</button>";

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on the button, open the modal 
	modal.style.display = "block";

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		closeModal();
	}

	// When the user clicks anywhere outside of the modal, close it
	
	window.onclick = function(event) {
		if(allowClickOutsideClose == true){
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	}
	

}



function closeModal(){
	var modal = document.getElementById('myModal');
	modal.style.display = "none";
}