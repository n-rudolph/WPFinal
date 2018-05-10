<?php

include 'db.php';
include 'sendEmail.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function sendEmail($cart){
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
    foreach ($cart as &$prod){
        $message .= "<tr>";
        $message .= "<th>";
        $message .= "<h4>" . $prod["product"]["name"] . "</h4>";
        $message .= " </th>";
        $message .= " <th>";
        $message .= " <p>" . $prod["product"]["price"] . " €</p>";
        $message .= " </th>";
        $message .= " <th>" . $prod["quantity"] . "";
        $message .= " </th>";
        $message .= " </tr>";
    }
    $message .= "</tbody>";
    $message .= "</table>";
    $message.= "<h4>Total = " . $_POST["total"] . "</h4>";
    $message.= "<h4>Delivery = " . $_POST["delivery"] . "</h4>";

    return orderMail($_SESSION["email"], $message);
}

if (isset($_SESSION["id"]) && isset($_POST["cart"]) && isset($_POST["date"])) {

    $connected = isConnected();
    if (!$connected) {
        $response['status'] = 500;
        $response['msg'] = "Server error occurred. Please try again";
        $response['error'] = "" . getError();
        echo json_encode($response);
    } else {
        $userid = $_SESSION["id"];
        $cart = $_POST["cart"];
        $date = $_POST["date"];
        $delivery = $_POST["delivery"];
        $total = $_POST["total"];

        $q = query("INSERT INTO user_order (id, userid, date, total, delivery) VALUE (null,'$userid', '$date', '$total', '$delivery');");
        $q = true;
        if ($q != false) {
            $lastId = lastId();
            foreach ($cart as &$product) {
                query("INSERT INTO order_product (orderid, productid, quantity) VALUE ($lastId, " . $product["productid"] . ", " . $product["quantity"] . ");");
            }
            query("delete from cart where (userid = '$userid');");
            sendEmail($cart);
            if (true) {
                $response['status'] = 200;
                $response['msg'] = "Order saved successfully";
                $response['lastId'] = $lastId;
                echo json_encode($response);
            }else {
                $response['status'] = 500;
                $response['msg'] = "Error sending mail";
                echo json_encode($response);
            }
        } else {
            $response['status'] = 500;
            $response['msg'] = "Error saving order. Please try again later.";
            $response['error'] = "" . getError();
            echo json_encode($response);
        }
    }
}
