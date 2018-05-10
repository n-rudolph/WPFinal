<?php
include 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["id"]) && isset($_POST["productid"])){
  if (isConnected()) {
    $userid = $_SESSION["id"];
    $productid = $_POST["productid"];
    query("delete from cart where (userid = '$userid' and productid = '$productid');");
    $response['status'] = 200;
    $response['msg'] = "Remove complete";
    echo json_encode(utf8ize($response));
  } else {
    $response['status'] = 500;
    $response['msg'] = "Database is not connected.";
    $response['error'] = "" . getError();
    echo json_encode(utf8ize($response));
  }
} else {
  $response['status'] = 500;
  $response['msg'] = "Invalid data.";
  $response['error'] = "" . getError();
  echo json_encode(utf8ize($response));
}
 ?>
