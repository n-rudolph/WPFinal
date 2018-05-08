function addToCart(prodid) {
    if (sessionStorage.id) {
        $.post("php/addToCart.php", {
            userid: sessionStorage.id,
            productid: prodid
        }, function (result) {
            var resp = JSON.parse(result);
            if (resp.status == "200") {
                window.location.href = "cart.html";
            } else {
                var alert = "<div class=\"alert alert-warning rudy-alert\" role=\"alert\">\n" +
                    (resp.msg? resp.msg : "An error occurred. Please try again later.")
                    + "</div>";
                $('body').append(alert);
                setTimeout(function () {
                    $(".alert").addClass("go-down");
                    setTimeout(function () {
                        $('.alert').alert('close');
                    }, 1000);
                }, 3000);
            }
        });
    }
}
