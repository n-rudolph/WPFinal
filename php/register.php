<?php
include 'db.php';
include 'sendEmail.php';

$response = array('status' => 0, 'msg' => "");
if (isset($_POST["name"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    if (!checkConnection()) {
        $response['status'] = 500;
        $response['msg'] = "Server error occurred. Please try again";
        $response['error'] = "" . getError();
        echo json_encode($response);
        exit();
    } else {
        $name = $_POST["name"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $id = 0;

        $checkEmail = query("SELECT count(*) as total from user where email='$email'");
        if (($checkEmail->fetch_object())->total != 0) {
            $response['status'] = 400;
            $response['msg'] = "Mail already registered";
            $response['error'] = "$email already exists in database.";
            echo json_encode($response);
            exit();
        } else {
            $answer = query("SELECT max(id) AS maximum FROM user;");
            while ($ansObj = $answer->fetch_object()) {
                $id = $ansObj->maximum;
                $id++;
            }
            $answer->close();

            $result = query("INSERT INTO user (id, name, lastname, email, password) VALUE ('$id', '$name', '$lastname', '$email', '$password');");
            closeConnection();
            $to = welcomeMail($email);
            $response['status'] = 200;
            $response['msg'] = "Mail sent to: $to";
            echo json_encode($response);
        }
    }
} else {
    echo "invalid data";
}
