<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$amount = count(glob(session_save_path() . '/*'));
echo "200, $amount";
?>
