$( document ).ready(function() {
  checkSession();
});

function checkSession() {
  if (sessionStorage.id){
    $('.needsLogin').show();
    $('.doesntNeedLogin').hide();
  } else {
    $('.needsLogin').hide();
    $('.doesntNeedLogin').show();
  }
}

function logout() {
  if (sessionStorage.id){
    $.get("php/logout.php", {}, function(daten) {
        sessionStorage.removeItem("id");
        sessionStorage.removeItem("name");
        sessionStorage.removeItem("email");
        checkSession();
        window.location.href = 'index.html';
    });
  }
}

setInterval(function() {
  $.get('php/getActiveUsers.php', {}, function(data) {
    var split = data.split(",");
    if (split[0]=="200"){
      $("#activeUsers").html(split[1]);
    }else{
      $("#activeUsers").html("0");
    }
  });
}, 2000);
