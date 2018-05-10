<?php
include 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!$_SESSION['loggedin']){
  $response['status'] = 500;
  $response['msg'] = "Server error occurred. Please try again";
  $response['error'] = "" . getError();
  echo json_encode($response);
  exit();
}

$response = array('status' => 0, 'msg' => "");
if (isset($_SESSION["id"]) && isset($_POST["productid"])) {
    if (!isConnected()) {
        $response['status'] = 500;
        $response['msg'] = "Server error occurred. Please try again";
        $response['error'] = "" . getError();
        echo json_encode($response);
        exit();
    } else {
        $userid = $_SESSION["id"];
        $productid = $_POST["productid"];

        $checkAlreadyInCart = query("SELECT count(*) as total from cart where (userid='$userid' and productid = '$productid');");
        if (($checkAlreadyInCart->fetch_object())->total != 0) {
            $response['status'] = 400;
            $response['msg'] = "Object already in cart";
            $response['error'] = "Product already in user cart.";
            echo json_encode($response);
            exit();
        } else {
            $answer = query("SELECT max(id) AS maximum FROM cart;");
            while ($ansObj = $answer->fetch_object()) {
                $id = $ansObj->maximum;
                $id++;
            }
            $answer->close();

            $result = query("INSERT INTO cart (id, userid, productid) VALUE ('$id', '$userid', '$productid');");
            closeConnection();
            $response['status'] = 200;
            $response['msg'] = "Product added to user cart";
            echo json_encode($response);
        }
    }
} else {
    echo "invalid data";
}
