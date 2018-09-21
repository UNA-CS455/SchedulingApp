$(document).ready(function()
{
  $("#displayUserSettings").show();
  $("#displayRoomSettings").hide();
  $("#displayGroupSettings").hide();

  $("#userSettingsBtn").click(function()
  {
    $("#displayUserSettings").show();
    $("#displayRoomSettings").hide();
    $("#displayGroupSettings").hide();
  });

  $("#roomSettingsBtn").click(function()
  {
    $("#displayUserSettings").hide();
    $("#displayRoomSettings").show();
    $("#displayGroupSettings").hide();
  });

  $("#groupSettingsBtn").click(function()
  {
    $("#displayUserSettings").hide();
    $("#displayRoomSettings").hide();
    $("#displayGroupSettings").show();
  });

})