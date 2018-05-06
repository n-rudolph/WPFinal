$(document).ready(function(){
  $("#cart-empty").hide();
  if (!sessionStorage.id){
    window.location.href = 'index.html';
  }
  getUserCart();
});

function getUserCart() {
  var id = sessionStorage.id;
  $.get('php/getCart.php', {userid: id}, function(response) {
    var result = JSON.parse(response);
    if (result.length == 0){
      $("#cart-table").hide();
      $("#cart-empty").show();
    } else {
      for(var i = 0; i<result.length; i ++) {
      }
    }
  });
}
