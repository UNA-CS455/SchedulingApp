function showWhitelist()
{
	var checkbox = document.getElementById('limitCheck');
	checkbox = (checkbox == null) ? false : checkbox.checked;
	if (checkbox == true)
	{
		if (document.getElementById('allowedReserve') != null)
		{
			document.getElementById('allowedReserve').style.visibility = "visible";
		}

	}
	else
	{
		if (document.getElementById('allowedReserve') != null)
		{
			document.getElementById('allowedReserve').style.visibility = "hidden";
		}

	}
}