$(document).ready(function(){
  $("#cart-empty").hide();
  if (!sessionStorage.id){
    window.location.href = 'index.html';
  }
  getUserCart();
});

function getUserCart() {
  var userid = sessionStorage.id;
  $.post('php/getCart.php', {
    id: userid
  }, function(response) {
    var result = JSON.parse(response);
    if (result.length == 0){
      $("#cart-table").hide();
      $("#cart-empty").show();
    } else {
      $.each(result, function (k, product) {
        var cart_html = "<tr id=\"product"+product.id+"\">\n"+
          " <th>\n"+
          "   <img src=\"./resources/images/products/"+product.image+"\" alt=\"product\">\n"+
          " </th>\n" +
          " <th>\n"+
          "   <h4>"+product.name+"</h4>\n"+
          "   <p>"+product.description+"</p>\n"+
          "   <a onclick=\"remove("+product.id+")\">Remove from cart</a>\n</th>\n"+
          " <th>\n"+
          "   <h4>"+product.price+"</h4>\n"+
          " </th>\n"+
          " <th>\n"+
          "   <select class=\"custom-select\" id=\"product"+k+"\">\n"+
          "     <option selected>Quantity</option>\n"+
          "     <option value=\"1\">1</option>\n"+
          "     <option value=\"2\">2</option>\n"+
          "     <option value=\"3\">3</option>\n"+
          "   </select>\n"+
          " </th>\n"+
          "</tr>";
        $("#table-body").append(cart_html);
      });
    }
  });
}

function remove(id) {

}
