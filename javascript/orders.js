$(document).ready(function () {
    $("#orders-empty").hide();
    if (!sessionStorage.id) {
        window.location.href = 'index.html';
    }
    getUserOrders();
});

function fillOrders(orders) {
    $.each(orders, function (k, order) {
        $.get('php/getOrderProducts.php?orderid=' + order.id, function (response) {
            var products = JSON.parse(response);
            var totalPrice = 0;
            var cart_html = "<table class=\"table\">\n" +
                "        <thead>\n" +
                "          <tr>\n" +
                "            <th colspan='2'>Product</th>\n" +
                "            <th>Price</th>\n" +
                "            <th>Quantity</th>\n" +
                "          </tr>\n" +
                "        </thead>\n" +
                "        <tbody id=\"table-body\">\n";
            $.each(products, function (k, product) {
                totalPrice += parseInt(product.price) * parseInt(product.quantity);
                cart_html += "<tr id=\"product" + product.id + "\">\n" +
                    " <th>\n" +
                    "   <img src=\"./resources/images/products/" + product.image + "\" alt=\"product\"/>\n" +
                    " </th>\n" +
                    " <th>\n" +
                    "   <h4>" + product.name + "</h4>\n" +
                    " <th>\n" +
                    "   <h4>" + product.price + " €</h4>\n" +
                    " </th>\n" +
                    " <th>\n" +
                    " <h4>"+ product.quantity +"</h4>" +
                    " </th>\n" +
                    "</tr>";
            });
            cart_html += "<tr><th colspan='2'>TOTAL PRICE</th><th colspan='2'>"+ totalPrice +" €</th></tr>";
            cart_html += "</tbody></table>\n";
            cart_html += "<button class=\"btn btn-primary pull-right\">Buy again</button>";
            $('#collapse' + order.id + " .card-body").append(cart_html);
        });
    });
    var orderid = new URL(window.location.href).searchParams.get("id");
    if (orderid){
        $('#collapse' + orderid).addClass("show");
    }
}

function getUserOrders() {
    var userid = sessionStorage.id;
    $.post('php/getOrders.php', {
        id: userid
    }, function (response) {
        var result = JSON.parse(response);
        if (result.length === 0) {
            $("#orders-accordion").hide();
            $("#orders-empty").show();
        } else {
            result = result.sort(function (a, b) {
                if (a.date > b.date) {
                    return 1;
                }
                if (a.date < b.date) {
                    return -1;
                }
                return 0;
            });

            var accordion = $("#orders-accordion");
            $.each(result, function (k, order) {
                var orderHtml = "<div class=\"card\">\n" +
                    "          <div class=\"card-header\" id=\"heading-" + order.id + "\">\n" +
                    "            <h5 class=\"mb-0\">\n" +
                    "              <button class=\"btn btn-link\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapse" + order.id + "\" aria-expanded=\"true\" aria-controls=\"collapse" + order.id + "\">\n" +
                    "                " + order.date + "\n" +
                    "              </button>\n" +
                    "            </h5>\n" +
                    "          </div>\n" +
                    "\n" +
                    "          <div id=\"collapse" + order.id + "\" class=\"collapse\" aria-labelledby=\"heading-" + order.id + "\" data-parent=\"#orders-accordion\">\n" +
                    "            <div class=\"card-body\">\n" +
                    "            </div>\n" +
                    "          </div>\n" +
                    "        </div>";
                accordion.append(orderHtml);
                accordion.show();
                $("#orders-empty").hide();
            });
            fillOrders(result);
        }
    });
}