<?php
  function closeDbConnection() {
    global $mysqli;
    $mysqli -> close();
  }
  $mysqli = new mysqli("localhost", "root", "", "finalprojectdb");
  if ($mysqli -> connect_error) {
    echo "100,Db connection error".mysqli_connect_error();
    exit();
  }

  $answer = $mysqli -> query("SELECT * FROM connectedusers WHERE id = 1;");
  $getRowAssoc = mysqli_fetch_assoc($answer);
  $amount = $getRowAssoc["amount"];

  $answer->close();
  closeDbConnection();
  echo "200,$amount";
  exit();
 ?>
