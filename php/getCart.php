<?php
include 'db.php';
function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}

if (isset($_POST["id"])){
  if (isConnected()) {
    $id = $_POST["id"];
    $products_query = query("select p.* from cart c join product p on c.productid = p.id where c.userid = '$id';");
    $products = $products_query->fetch_all(MYSQLI_ASSOC);
    echo json_encode(utf8ize($products));
  } else {
      echo json_encode(array());
  }
} else {
    echo json_encode(array());
}
