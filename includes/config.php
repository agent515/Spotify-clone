<?php
    ob_start(); //Output Buffering
    session_start();

    $timezone = date_default_timezone_set('Asia/Calcutta');

    $conn = mysqli_connect('localhost', 'root', '', 'spotify');

    if(!$conn){
        echo "Failed database connection: " . $mysqli_connect_errno() . PHP_EOL;
    }
?>