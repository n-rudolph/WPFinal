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