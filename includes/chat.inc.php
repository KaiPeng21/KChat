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
                'statusMsg' => 'FAILED:DBERR',
                'lastMsgTimestamp' => '-1',
                'msgContent' => ''
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            die();
        }

        // validate timestamp
        $timestamp = mysqli_real_escape_string($conn, $_POST['timestamp']);

        $sql = '';
        // after reloading, query all the messages
        if ($timestamp == '-1'){
            $sql = "SELECT `users`.`uid`, `firstname`, `lastname`, `content`, `time` FROM `users` INNER JOIN `messages` ON `messages`.`uid` = `users`.`uid` ORDER BY `time`";
        // get all messages newer than the timestamp
        } else {
            $sql = "SELECT `users`.`uid`, `firstname`, `lastname`, `content`, `time` FROM `users` INNER JOIN `messages` ON `messages`.`uid` = `users`.`uid` WHERE `time` > '$timestamp' ORDER BY `time`";
        }

        // execute sql
        $result = mysqli_query($conn, $sql);

        // error executing the sql query
        if ($result === false){
            $response = array(
                'statusCode' => 3,
                'statusMsg' => 'FAILED:SQLERR',
                'lastMsgTimestamp' => '-1',
                'msgContent' => $sql
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            mysqli_close($conn);
            die();
        }

        // no message being updated or the message database is empty
        if (($rows = mysqli_affected_rows($conn)) == 0){
            $response = array(
                'statusCode' => 2,
                'statusMsg' => 'NOMSG',
                'lastMsgTimestamp' => '-1',
                'msgContent' => ''
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            mysqli_close($conn);
            die();
        }

        // format the messages
        $messages = '';
        for ($i = 0; $i < $rows; $i+=1){
            $msgarr = mysqli_fetch_assoc($result);
            $uid = $msgarr['uid'];
            $content = $msgarr['content'];
            $type = 'other';
            if ($_SESSION['u_uid'] == $uid){
                $type = 'self';
            }

            $name = $msgarr['firstname'] . ' ' . $msgarr['lastname'];
            $timestamp = $msgarr['time'];
            
            $messages .= createMessageBlock($content, $type, $name, $timestamp);

            $lastMsgTimestamp = $msgarr['time'];
        }

        // update messages
        $response = array(
            'statusCode' => 0,
            'statusMsg' => 'SUCCESS',
            'lastMsgTimestamp' => $lastMsgTimestamp,
            'msgContent' => $messages
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        mysqli_close($conn);
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
            $_POST['message'] = trim(nl2br($_POST['message']));
            $content = $_POST['message'];
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