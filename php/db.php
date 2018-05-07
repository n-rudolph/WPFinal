<?php
$db = new mysqli("localhost:3306", "root", "", "finalprojectdb");


function isConnected()
{
    $error = getError();
    if ($error == NULL){
        return true;
    }else{
        return false;
    }
}

function closeConnection()
{
    global $db;
    $db->close();
}

function getError()
{
    global $db;
    return $db->connect_error;
}

function query($txt){
    global $db;
    return $db -> query($txt);
}

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}
