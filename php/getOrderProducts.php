<?php
include 'db.php';

if (isset($_GET["orderid"])){
  if (isConnected()) {
    $id = $_GET["orderid"];
    $orders_query = query("select * from order_product op join product p on op.productid = p.id where op.orderid = '$id';");
    $orders = $orders_query->fetch_all(MYSQLI_ASSOC);
    echo json_encode(utf8ize($orders));
  } else {
      echo json_encode(array());
  }
} else {
    echo json_encode(array());
}
