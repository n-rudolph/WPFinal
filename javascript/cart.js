$(document).ready(function(){
  if (!sessionStorage.id){
    window.location.href = 'index.html';
  }
  getUserCart();
});

function getUserCart() {
  var id = sessionStorage.id;
  $.get('php/getCart.php', {userid: id}, function(response) {
    var split = response.split(",");
    if (split[0] == "200") {

    } else {
      // error
    }
  });
}
