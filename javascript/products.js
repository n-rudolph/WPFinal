$( document ).ready(function() {
    $.get("php/products.php", {}, function(response) {
        console.log(JSON.parse(response));
    });
});