<?php

include 'db.php';

if (isConnected()){
    $products_query = query("select * from product;");
    $products = $products_query->fetch_all(MYSQLI_ASSOC);
    echo json_encode(utf8ize($products));
}else{
    echo json_encode(array());
}
