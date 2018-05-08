$( document ).ready(function() {
    $.get("php/products.php", {}, function(response) {
        var products = JSON.parse(response);
        if (!products){
            window.location.href = "index.html";
        }else {
            var row = $('.container .row');
            $.each(products, function (k, product) {
                var prod_html = "<div class=\"col-md-4\">\n" +
                    "            <div class=\"card product-card\">\n" +
                    "                <img class=\"card-img-top product-img\" src=\"./resources/images/products/" + product.image + "\" alt=\"Product\" onclick='window.location.href = \"productView.php?id=" + product.id + "\"'/>\n" +
                    "                <div class=\"card-body\">\n" +
                    "                    <p class=\"card-text\">" + product.name + " - <span>" + product.price + " €</span></p>\n" +
                    "                    <a href=\"productView.php?id=" + product.id + "\" >View</a>\n" +
                    "                </div>\n" +
                    "            </div>\n" +
                    "        </div>";
                row.append(prod_html);
            });
        }
    });
});
