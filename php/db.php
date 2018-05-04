<?php
$db = new mysqli("localhost:3306", "root", "", "finalprojectdb");


function checkConnection()
{
    global $db;
    if (!$db) {
        return false;
    }else{
        return true;
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