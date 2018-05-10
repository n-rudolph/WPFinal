<?php
include 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id = $_SESSION['id'];

if (isset($id)){
  if (isConnected()) {
    $orders_query = query("select * from user_order uo where uo.userid = '$id';");
    $orders = $orders_query->fetch_all(MYSQLI_ASSOC);
    echo json_encode(utf8ize($orders));
  } else {
      echo json_encode(array());
  }
} else {
    echo json_encode(array());
}
