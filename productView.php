<?php
include 'php/db.php';
$id = $_GET['id'];
$product = array("name" => "", "price" => 0);
if ($id && isConnected()) {
    $query = query("select * from product where id=$id;");
    $product = $query->fetch_array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php
        echo (string)$product['name'];
        ?></title>
    <link rel="stylesheet" href="resources/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/common.css">
    <script type="text/javascript" src="resources/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="resources/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="javascript/navbar.js"></script>
    <script type="text/javascript" src="javascript/product.js"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="flex-grow-1">
        <a class="navbar-brand" href="index.html">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse ml-auto" id="navbarSupportedContent">
        <button type="button" class="btn btn-primary">
            Active users <span class="badge badge-light" id=activeUsers></span>
        </button>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item doesntNeedLogin">
                <a href="login.html" class="nav-link">Log In</a>
            </li>
            <li class="nav-item doesntNeedLogin">
                <a href="register.html" class="nav-link">Sign Up</a>
            </li>
            <li class="nav-item needsLogin">
                <a onclick="logout()" class="nav-link">Log Out</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <br>
    <div class="card text-center">

        <?php
        echo "<div class=\"card-header\">" . (string)$product['name'] . "</div>";
        echo "<div class=\"card-body\"><div class='row'>";
        echo "<div class='col-md-4'><img src='./resources/images/products/{$product['image']}' alt='image' class='product-view-img'></div>";
        echo "<div class='col-md-8'><h4>{$product['price']} €</h4><h5>{$product['description']}</h5></div></div></div>";
        ?>
        <div class="card-footer text-muted">
            <button class="btn btn-success" id="add-cart" data-toggle="tooltip" data-placement="bottom"
                    title="Log in to use the cart" onclick="addToCart(<?php echo $id ?>)">Add to cart
            </button>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            if (!sessionStorage.id) {
                var add_btn = $('#add-cart');
                add_btn.prop("disabled", true);
                $('[data-toggle="tooltip"]').tooltip({placement: 'bottom', trigger: 'manual'}).tooltip('show');
            }
        });
    </script>

</div>

</body>
</html>
