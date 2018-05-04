<?php
include 'db.php';
include 'sendEmail.php';


if (isset($_POST["name"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    if (!checkConnection()) {
        echo "Db connection error: \n" . getError();
        exit();
    } else {
        $name = $_POST["name"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $id = 0;

        $answer = query("SELECT max(id) as maximum FROM user;");
        while ($ansObj = $answer->fetch_object()) {
            $id = $ansObj->maximum;
            $id++;
        }
        $answer->close();

        $result = query("INSERT INTO user (id, name, lastname, email, password) VALUE ('$id', '$name', '$lastname', '$email', '$password');");
        closeConnection();
        $to = welcomeMail($email);
        echo "success: sent mail \n" . $to;

    }
} else {
    echo "invalid data";
}
