<?php
include 'db.php';

if (isset($_POST["id"])){
  if (isConnected()) {
    $id = $_POST["id"];
    $orders_query = query("select * from user_order uo where uo.userid = '$id';");
    $orders = $orders_query->fetch_all(MYSQLI_ASSOC);
    echo json_encode(utf8ize($orders));
  } else {
      echo json_encode(array());
  }
} else {
    echo json_encode(array());
}
