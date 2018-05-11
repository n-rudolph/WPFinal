<?php
include 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function isLoggedin() {
  return $_SESSION['loggedin'];
}

function isSessionExpired() {
  $now = time();
  if ($_SESSION['expire'] && $now < $_SESSION['expire']) {
    return false;
  } else {
    return true;
  }
}

function logout() {
  if (isConnected()) {
    query("UPDATE connectedusers SET amount = amount - 1 WHERE id = 1");
    closeConnection();
  }
  session_unset();
  session_destroy();
}
 ?>
