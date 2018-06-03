<?php
session_start();
require 'dbh.inc.php';
require 'tool.inc.php';

if (!isset($_SESSION['u_uid'])){
    header("Location: ../index.php");
    die();
}

if (isset($_POST['method']) && !empty($_POST['method']) && isset($_POST['timestamp']) && !empty($_POST['timestamp'])){

    // getting message 
    if ($_POST['method'] == 'getMessages'){

        // connect to database
        $conn = db_connect();
        if ($conn === false){
            $response = array(
                'statusCode' => 1,
                'statusMsg' => 'FAILED:DBERR'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            die();
        }

        // validate timestamp
        $timestamp = mysqli_real_escape_string($conn, $_POST['timestamp']);
        $timestamp = validate_timestamp($timestamp);

        $sql = '';
        // after reloading, query all the messages
        if ($timestamp === false){
            $sql = "SELECT `users`.`uid`, `firstname`, `lastname`, `content`, `time` FROM `users` INNER JOIN `messages` ON `messages`.`uid` = `users`.`uid` ORDER BY `time` DESC";
        // get all messages newer than the timestamp
        } else {
    
        }
    
        // execute sql
    
        // update the last timestamp
        
        
        // update messages

        // testing..........
        $response = array(
            'msg' => 'testing message content',
            'statusCode' => 1,
            'statusMsg' => 'SUCCESS'
        );
        // if success, respond message to JS/chat.js
        header('Content-Type: application/json');
        echo json_encode($response);
        die();

    // push a message to the database
    } elseif ($_POST['method'] == 'pushMessage'){

        // message was not sended but pushMessage method was triggered
        if (!isset($_POST['message']) || empty($_POST['message'])){
            $response = array(
                'statusCode' => 3,
                'statusMsg' => 'FAILED:POSTERR'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            die();

        } else {

            // connect to database
            $conn = db_connect();
            if ($conn === false){
                $response = array(
                    'statusCode' => 1,
                    'statusMsg' => 'FAILED:DBERROR'
                );
                header('Content-Type: application/json');
                echo json_encode($response);
                die();
            }

            // retrieve content and uid info
            $content = trim(mysqli_real_escape_string($conn, $_POST['message']));
            $uid = $_SESSION['u_uid'];

            // ignore empty messages
            if (empty($content)){
                $response = array(
                    'statusCode' => 0,
                    'statusMsg' => 'EMPTYMSG'
                );
                header('Content-Type: application/json');
                echo json_encode($response);
                mysqli_close($conn);
                die(); 
            }

            // prepare statement for database insertion
            $stmt = mysqli_stmt_init($conn);
            $sql = "INSERT INTO `messages` (`uid`, `content`) VALUES (?, ?);";
            if (!mysqli_stmt_prepare($stmt, $sql)){
                $response = array(
                    'statusCode' => 2,
                    'statusMsg' => 'FAILED:SQLERR'
                );
                header('Content-Type: application/json');
                echo json_encode($response);
                mysqli_close($conn);
                die();
            } else {
                // bind sql parameters and execute
                mysqli_stmt_bind_param($stmt, 'ss', $uid, $content);
                mysqli_stmt_execute($stmt);

                if (mysqli_affect_rows($conn) != 1){
                    $response = array(
                        'statusCode' => 2,
                        'statusMsg' => 'FAILED:SQLERR'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    mysqli_close($conn);
                    die();        
                } else {
                    $response = array(
                        'statusCode' => 0,
                        'statusMsg' => 'SUCCESS'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    mysqli_close($conn);
                    die();        
                }
            }    
        }

    }

}