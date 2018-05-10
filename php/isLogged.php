<?php
include 'authUtils.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isLoggedin()) {
  if (isSessionExpired()) {
    logout();
    echo 'false';
  } else {
    echo 'true';
  }
} else {
  echo 'false';
}
 ?>
