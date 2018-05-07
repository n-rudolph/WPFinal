function addToCart(prodid) {
  if (sessionStorage.id) {
    $.post("php/addToCart.php", {
      userid: sessionStorage.id,
      productid: prodid
    }, function (result){
      var resp = JSON.parse(result);
      if (resp.status == "200") {
        window.location.href = "cart.html";
      } else {
        // error
        alert("error");
      }
    });
  }
}
