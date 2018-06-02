<?php

require 'dbh.inc.php';

function getMessages($timestamp){

    $sql = '';

    // after reloading, query all the messages
    if ($timestamp === false){
        
    // get all messages newer than the timestamp
    } else {

    }

    // execute sql

    // update the last timestamp
    
    
    // update messages


}

function pushMessages($raw){

    // create a sql template
    $sql = 'INSERT INTO message (content, uid) VALUES(?, ?)';
    $content = mysqli_real_escape_string($conn, $raw);
    $uid = $_SESSION['u_uid'];

    // push the user id and message content into database
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt)){
        mysqli_stmt_bind_param($stmt, 'ss', $content, $uid);
        mysqli_stmt_execute($stmt);

        // error while pushing message to db
        if (mysqli_affected_rows($conn) != 1){
            return false;
        }

    } else {
        return false;
    }

    return true;
}