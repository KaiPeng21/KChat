<?php
session_start();


if (isset($_POST['method']) && !empty($_POST['method']) && isset($_POST['timestamp']) && !empty($_POST['timestamp'])){

    if ($_POST['method'] == 'getMessages'){


        // testing..........
        $response = array(
            'msg' => 'testing message content',
            'statusCode' => 1,
            'statusMsg' => 'SUCCESS',
        );

        // if success, respond message to JS/chat.js
        header('Content-Type: application/json');
        echo json_encode($response);
        die();

    }

}