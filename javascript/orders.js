$(document).ready(function () {
    $("#orders-empty").hide();
    $.get('php/isLogged.php', {}, function (result) {
        if (result == 'false') {
            window.location.href = "index.html";
        } else {
            getUserOrders();
        }
    });
});

function fillOrders(orders) {
    $.each(orders, function (k, order) {
        $.get('php/getOrderProducts.php?orderid=' + order.id, function (response) {
            var products = JSON.parse(response);
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
                    " <h4>" + product.quantity + "</h4>" +
                    " </th>\n" +
                    "</tr>";
            });
            if (order.delivery == "Express") {
                cart_html += "<tr><th></th><th><h4>Express delivery</h4></th><th><h4>5 €</h4></th><th></th></tr>";
            }
            cart_html += "<tr><th colspan='2'>TOTAL PRICE</th><th colspan='2'>" + order.total + " €</th></tr>";
            cart_html += "</tbody></table>\n";
            cart_html += "<button class=\"btn btn-primary pull-right\" onclick=\"buyAgain(" + order.id + "," + order.total + ",'" + order.delivery + "')\">Buy again</button>";
            $('#collapse' + order.id + " .card-body").append(cart_html);
        });
    });
    var orderid = new URL(window.location.href).searchParams.get("id");
    if (orderid) {
        $('#collapse' + orderid).addClass("show");
    }
}

function getOrderDate(dateString) {
  var split = dateString.split(" ");
  var timeSplit = split[1].split(":");
  var hours = parseInt(timeSplit[0]);
  hours = hours + 2;
  var hourString = "" + (hours<10 ? "0" + hours : ""+hours);
  return split[0] +  " " + hourString + ":" +timeSplit[1];
}

function getUserOrders() {
    $.post('php/getOrders.php', {}, function (response) {
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
              console.log(order);
                var orderHtml = "<div class=\"card\">\n" +
                    "          <div class=\"card-header\" id=\"heading-" + order.id + "\">\n" +
                    "            <h5 class=\"mb-0\">\n" +
                    "              <button class=\"btn btn-link\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapse" + order.id + "\" aria-expanded=\"true\" aria-controls=\"collapse" + order.id + "\">\n" +
                    "                " + getOrderDate(order.date) + "\n" +
                    "              </button>\n" +
                    "            </h5>\n" +
                    "          </div>\n" +
                    "\n" +
                    "          <div id=\"collapse" + order.id + "\" class=\"collapse\" aria-labelledby=\"heading-" + order.id + "\" data-parent=\"#orders-accordion\">\n" +
                    "            <div class=\"card-body\">\n" +
                    "            </div>\n" +
                    "          </div>\n" +
                    "        </div>";
                accordion.prepend(orderHtml);
                accordion.show();
                $("#orders-empty").hide();
            });
            fillOrders(result);
        }
    });
}

function buyAgain(orderid, orderTotal, orderDelivery) {
    $.post('php/buyAgain.php', {
        orderid: orderid,
        date: now(),
        total: orderTotal,
        delivery: orderDelivery
    }, function (response) {
        var result = JSON.parse(response);
        if (result.status == 200) {
            $("#orders-accordion").empty();
            getUserOrders();
        }
    });

}

function now() {
    return new Date().toISOString().replace("T", " ").substring(0, 19);
}
