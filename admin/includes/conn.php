<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    try{
        $conn = new PDO("mysql:host=$servername;port=3306; dbname=kider-website", $username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $conn->setAttribute(2, 3);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // echo "Connected successfully";
    }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
?>