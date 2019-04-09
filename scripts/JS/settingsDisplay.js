$(document).ready(function()
{
  $("#displayUserSettings").show();
  $("#displayRoomSettings").hide();
  $("#displayGroupSettings").hide();
  $("#ARGOSautoImportSettings").hide();

  $("#userSettingsBtn").click(function()
  {
    $("#displayUserSettings").show();
    $("#displayRoomSettings").hide();
    $("#displayGroupSettings").hide();
    $("#ARGOSautoImportSettings").hide();
  });

  $("#roomSettingsBtn").click(function()
  {
    $("#displayUserSettings").hide();
    $("#displayRoomSettings").show();
    $("#displayGroupSettings").hide();
    $("#ARGOSautoImportSettings").hide();
  });

  $("#groupSettingsBtn").click(function()
  {
    $("#displayUserSettings").hide();
    $("#displayRoomSettings").hide();
    $("#displayGroupSettings").show();
    $("#ARGOSautoImportSettings").hide();
  });
  
  $("#autoImportSettingsBtn").click(function()
  {
    $("#displayUserSettings").hide();
    $("#displayRoomSettings").hide();
    $("#displayGroupSettings").hide();
    $("#ARGOSautoImportSettings").show();
  });

})