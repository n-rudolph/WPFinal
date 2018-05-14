function addToCart(prodid) {
        $.post("php/addToCart.php", {
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

$(document).ready(function () {
    $.get('php/isLogged.php', {}, function (response) {
        if (response == 'false') {
            var add_btn = $('#add-cart');
            add_btn.prop("disabled", true);
            $('[data-toggle="tooltip"]').tooltip({placement: 'bottom', trigger: 'manual'}).tooltip('show');
        }
    });
});