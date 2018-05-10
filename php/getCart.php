<?php
include 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["id"])){
  if (isConnected()) {
    $id = $_SESSION["id"];
    $products_query = query("select p.* from cart c join product p on c.productid = p.id where c.userid = '$id';");
    $products = $products_query->fetch_all(MYSQLI_ASSOC);
    echo json_encode(utf8ize($products));
  } else {
      echo json_encode(array());
  }
} else {
    echo json_encode(array());
}
