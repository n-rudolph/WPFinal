<?php
include 'db.php';

$response = array('status' => 0, 'msg' => "");
if (isset($_POST["name"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    if (!isConnected()) {
        $response['status'] = 500;
        $response['msg'] = "Server error occurred. Please try again";
        $response['error'] = "" . getError();
        echo json_encode($response);
        exit();
    } else {
        $userid = $_POST["userid"];
        $productid = $_POST["productid"];


        $checkEmail = query("SELECT count(*) as total from cart where (userid='$userid' and productid = '$productid');");
        if (($checkEmail->fetch_object())->total != 0) {
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
            $to = welcomeMail($email);
            $response['status'] = 200;
            $response['msg'] = "Product added to user cart";
            echo json_encode($response);
        }
    }
} else {
    echo "invalid data";
}
