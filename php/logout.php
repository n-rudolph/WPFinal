<?php
include 'db.php';

if (isConnected()){
    $update = query("UPDATE connectedusers SET amount = amount - 1 WHERE id = 1");
    if ($update != false){
        $response['status'] = 200;
        $response['msg'] = "Successful log out.";
        echo json_encode($response);
    }else{
        $response['status'] = 500;
        $response['msg'] = "Error at logging out. Try again.";
        $response['error'] = "" . getError();
        echo json_encode($response);
    }
}else{
    $response['status'] = 500;
    $response['msg'] = "Database is not connected.";
    $response['error'] = "" . getError();
    echo json_encode($response);
}
closeConnection();