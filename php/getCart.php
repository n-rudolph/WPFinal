<?php
include 'db.php';
if (isset($_POST["userid"]) {
  $id = $_POST["userid"];
  if (isConnected()){
      $products_query = query("select p.* from cart c join product p on c.productid = p.id where c.userid = '$id';");
      $products = $products_query->fetch_all(MYSQLI_ASSOC);
      echo json_encode($products);
  }else{
      echo json_encode(array());
  }
} else {
    echo json_encode(array());
}
