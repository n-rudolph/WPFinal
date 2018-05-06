<?php

include 'db.php';

if (isset($_POST["email"]) && isset($_POST["password"])) {

    $connected = isConnected();
    if (!$connected) {
        $response['status'] = 500;
        $response['msg'] = "Server error occurred. Please try again";
        $response['error'] = "" . getError();
        echo json_encode($response);
    } else {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $answer = query("SELECT * FROM user WHERE email = '$email';");
        if (is_null($answer) || $answer->num_rows == 0) {
            $answer->close();
            closeConnection();
            $response['status'] = 400;
            $response['msg'] = "Email not found";
            echo json_encode($response);
            exit();
        }else{
            $user = mysqli_fetch_assoc($answer);
            $passwordMatch = $user['password'] == $password;
            if ($passwordMatch){
                $id = $user["id"];
                $name = $user["name"] . " " . $user["lastname"];
                $answer->close();
                if (isset($id)) {
                    $result = query("UPDATE connectedusers SET amount = amount + 1 WHERE id = 1");
                    closeConnection();
                    $response['status'] = 200;
                    $response['msg'] = "Successful login: $name, $email";
                    $response['user'] = array("id" => $id, "name" => $name, "email" => $email);
                    echo json_encode($response);
                } else {
                    closeConnection();
                    $response['status'] = 500;
                    $response['msg'] = "Unexpected error";
                    echo json_encode($response);
                }
            }else{
                $response['status'] = 400;
                $response['msg'] = "Incorrect password.";
                echo json_encode($response);
            }
        }
    }
} else {
    $response['status'] = 400;
    $response['msg'] = "Fields missing";
    echo json_encode($response);
}
