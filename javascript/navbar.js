$( document ).ready(function() {
  checkSession();
});

function checkSession() {
  $.get('php/isLogged.php', {} , function(response) {
    if (response == 'true') {
      $('.needsLogin').show();
      $('.doesntNeedLogin').hide();
    } else {
      $('.needsLogin').hide();
      $('.doesntNeedLogin').show();
    }
  });
}

function logout() {
    $.get("php/logout.php", {}, function(daten) {
        checkSession();
        console.log(window.location.href);
        //window.location.href = 'index.html';
    });
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
