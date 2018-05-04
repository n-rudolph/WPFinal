<?php
  function closeDbConnection() {
    global $mysqli;
    $mysqli -> close();
  }

  if (isset($_POST["email"]) && isset($_POST["password"])) {
    $mysqli = new mysqli("localhost", "root", "", "finalprojectdb");
    if ($mysqli -> connect_error) {
      echo "Db connection error".mysqli_connect_error();
      exit();
    }
    $email = $_POST["email"];
    $password = $_POST["password"];

    $answer = $mysqli -> query("SELECT * FROM user WHERE email = '$email';");
    if (is_null($answer)) {
      $answer->close();
      closeDbConnection();
      echo "100";
      exit();
    }
    $getRowAssoc = mysqli_fetch_assoc($answer);
    $id = $getRowAssoc["id"];
    $name = $getRowAssoc["name"]." ".$getRowAssoc["lastname"];
    $answer->close();
    if (isset($id)) {
      $result = $mysqli->query("UPDATE connectedusers SET amount = amount + 1 WHERE id = 1");
      closeDbConnection();
      echo "200,$id,$name,$email";
    }else{
      closeDbConnection();
      echo "100";
    }
  } else {
    echo "100";
  }
 ?>
