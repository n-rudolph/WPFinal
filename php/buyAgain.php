<?php

  include 'db.php';
  include 'sendEmail.php';

  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }

  if (isset($_POST["orderid"]) && isset($_SESSION["id"]) && isset($_POST["date"]) && isset($_SESSION["email"])) {
    $orderid = $_POST["orderid"];
    $userid = $_SESSION["id"];
    $date = $_POST["date"];
    $delivery = $_POST["delivery"];
    $total = $_POST["total"];

    $q = query("INSERT INTO user_order (id, userid, date, total, delivery) VALUE (null,'$userid', '$date', '$total', '$delivery');");
    $q = true;

    $message = "<h2>Hello " . $_SESSION["name"] . "! Thanks for your order.</h2>";
    $message .= "<table>";
    $message .= "<thead>";
    $message .= "<tr>";
    $message .= "<th>Product</th>";
    $message .= "<th>Price</th>";
    $message .= "<th>Quantity</th>";
    $message .= "</tr>";
    $message .= "</thead>";
    $message .= "<tbody>";

    if ($q != false) {
        $lastId = lastId();
        $result = query("select * from order_product where orderid = '$orderid'");
        $items = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($items as $item) {
          query("INSERT INTO order_product (orderid, productid, quantity) VALUE ($lastId, ".$item['productid'].",".$item['quantity'].");");

          $auxid = $item['productid'];
          $product_result = query("SELECT * FROM product WHERE id = '$auxid'");
          $getRowAssoc = mysqli_fetch_assoc($product_result);
          $prodname = $getRowAssoc["name"];
          $prodprice = $getRowAssoc["price"];

          $message .= "<tr>";
          $message .= "<th>";
          $message .= "<h4>" . $prodname . "</h4>";
          $message .= " </th>";
          $message .= " <th>";
          $message .= " <p>" . $prodprice . " €</p>";
          $message .= " </th>";
          $message .= " <th>" . $item["quantity"] . "";
          $message .= " </th>";
          $message .= " </tr>";
        }

        $message .= "</tbody>";
        $message .= "</table>";
        $message.= "<h4>Total = " . $_POST["total"] . "</h4>";
        $message.= "<h4>Delivery = " . $_POST["delivery"] . "</h4>";

        orderMail($_SESSION["email"], $message);

        $response['status'] = 200;
        $response['msg'] = "Order saved successfully";
        $response['lastId'] = $lastId;
        echo json_encode($response);
    } else {
        $response['status'] = 500;
        $response['msg'] = "Error saving order. Please try again later.";
        $response['error'] = "" . getError();
        echo json_encode($response);
    }
  } else {
    $response['status'] = 400;
    $response['msg'] = "Invalid data.";
    $response['error'] = "" . getError();
    echo json_encode($response);
  }
 ?>
