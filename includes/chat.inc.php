<?php
session_start();
include 'dbh.inc.php';

if (!isset($_SESSION['u_uid'])){
    header("Location: ../index.php");
    die();
}

if (isset($_POST['method']) && !empty($_POST['method']) && isset($_POST['timestamp']) && !empty($_POST['timestamp'])){

    // getting message 
    if ($_POST['method'] == 'getMessages'){
        
        
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

        if (isset($_POST['message']) && !empty($_POST['message'])){

            $content = trim($_POST['message']);
            $uid = $_SESSION['u_uid'];
            
            $conn = db_connect();
            if ($conn === false){
                exit();
            }

            $sql = "INSERT INTO messages (`uid`, `content`) VALUES ('.$uid.', '.$content.');";

            $res = mysqli_query($conn, $sql);

            $response = array(
                'statusCode' => 0,
                'statusMsg' => $sql
            );
    
            // if success, respond message to JS/chat.js
            header('Content-Type: application/json');
            echo json_encode($response);

            mysqli_close($conn);
            die();            
        }

    }

}