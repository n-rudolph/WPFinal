<?php
include 'authUtils.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isConnected()){
    logout();
    $response['status'] = 200;
    $response['msg'] = "Successful log out.";
    echo json_encode($response);
}else{
    $response['status'] = 500;
    $response['msg'] = "Database is not connected.";
    $response['error'] = "" . getError();
    echo json_encode($response);
}
closeConnection();
?>
