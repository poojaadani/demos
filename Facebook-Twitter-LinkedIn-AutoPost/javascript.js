function fbcloggedin(){
    $('#login').css('display', 'none');
    $('#logout').css('display', 'block');
}

function fbcloggedout(){
    FB.ensureInit(function() {
        FB.Connect.logout(function() {
                $('#login').css('display', 'block');
                $('#logout').css('display', 'none');
        });
    });
}

function ajaxCall(){
    var status = $('#status').val();
    var datas  = "status=" + status;
    $("#loader").css('display', 'block');

    $.ajax({
      url: baseUrl + "/statusupdate.php",
      type: "POST",
      data: datas,
      success: function(html){
        $("#loader").css('display', 'none');
        $("#result").html(html);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
          alert("Error occured");
      }
    });
}
