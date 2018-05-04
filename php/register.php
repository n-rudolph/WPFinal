<?php
  function closeDbConnection() {
    global $mysqli;
    $mysqli -> close();
  }

  if (isset($_POST["name"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $mysqli = new mysqli("localhost", "root", "", "finalprojectdb");
    if ($mysqli -> connect_error) {
      echo "Db connection error".mysqli_connect_error();
      exit();
    }
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $id = 0;

    $answer = $mysqli -> query("SELECT max(id) as maximum FROM user;");
    while ($ansObj = $answer ->fetch_object()){
      $id = $ansObj->maximum;
      $id++;
    }
    $answer->close();

    $result = $mysqli->query("INSERT INTO user (id, name, lastname, email, password) VALUE ('$id', '$name', '$lastname', '$email', '$password');");
    closeDbConnection();
    echo "success";
  } else {
    echo "invalid data";
  }
 ?>
