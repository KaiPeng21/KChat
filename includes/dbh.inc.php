<?php

function db_connect(){
    $dbServer = "Localhost";
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "kchat";
    $conn = mysqli_connect($dbServer, $dbUsername, $dbPass, $dbName);

    if ($conn === false){
        return false;
    }

    return $conn;
}

function db_disconnect($conn){
    mysqli_close($conn);
}