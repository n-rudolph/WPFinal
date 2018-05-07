$(document).ready(function(){
  $("#cart-empty").hide();
  if (!sessionStorage.id){
    window.location.href = 'index.html';
  }
  getUserCart();
});

var productids = [];
var products = [];
var amounts = [];
var total = 0;

function getUserCart() {
  var userid = sessionStorage.id;
  $.post('php/getCart.php', {
    id: userid
  }, function(response) {
    products = JSON.parse(response);
    if (products.length == 0){
      $("#cart-table").hide();
      $("#cart-empty").show();
    } else {
      $.each(products, function (k, product) {
        productids.push(product.id);
        var cart_html = "<tr id=\"product"+product.id+"\">\n"+
          " <th>\n"+
          "   <img src=\"./resources/images/products/"+product.image+"\" alt=\"product\">\n"+
          " </th>\n" +
          " <th>\n"+
          "   <h4>"+product.name+"</h4>\n"+
          "   <p>"+product.description+"</p>\n"+
          "   <a class=\"removeFromCart\" onclick=\"remove("+product.id+")\">Remove from cart</a>\n</th>\n"+
          " </th>\n" +
          " <th>\n"+
          "   <h4>$"+product.price+"</h4>\n"+
          " </th>\n"+
          " <th>\n"+
          "   <select class=\"custom-select\" id=\"product"+product.id+"\">\n"+
          "     <option value=\"1\" selected>1</option>\n"+
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
  $.post("php/removeFromCart.php", {
    userid: sessionStorage.id,
    productid: id
  }, function(response) {
    var resp = JSON.parse(response);
    if (resp.status == 200) {
      $("#product"+id).remove();
      var index  = productids.indexOf(id);
      productids.splice(index, 1);
      products.splice(index, 1);
      if (productids.length == 0) {
        $("#cart-table").hide();
        $("#cart-empty").show();
      }
    } else {
      // error
    }
  });
}

function fillPurchaseOrder() {
  $(".purchaseDeletable").remove();
  fillProductsAmount();
  calculateTotal();
  $.each(products, function (k, product) {
    var purchase_html = "<tr clase=\"purchaseDeletable\" id=\"product"+product.id+"\">\n"+
      " <th>\n"+
      "   <img class=\"purchase-img\" src=\"./resources/images/products/"+product.image+"\" alt=\"product\">\n"+
      " </th>\n" +
      " <th>\n"+
      "   <p>"+product.name+"</p>\n"+
      " </th>\n" +
      " <th>\n"+
      "   <p>$"+product.price+"</p>\n"+
      " </th>\n"+
      " <th>\n"+
      "   <p>"+amounts[k]+"</p>\n"+
      " </th>\n"+
      "</tr>";
    $("#purchase-table-body").prepend(purchase_html);
  });
}

function fillProductsAmount() {
  amounts = [];
  $.each(products, function (k, product) {
    var productSelectValue = $("#product"+product.id).val();
    amounts.push(productSelectValue == "" ? 1 : productSelectValue);
  });
}

function calculateTotal() {
  total = 0;
  $.each(products, function (k, product) {
    total += product.price * amounts[k];
  });
  if ($("#deliveryField input[type='radio']:checked").val() == "1"){
    total += 5;
  }
  $("#totalAmount").text(total);
}
