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
$result = $mysqli->query("UPDATE connectedusers SET amount = amount - 1 WHERE id = 1");
closeDbConnection();
echo "200";
 ?>
