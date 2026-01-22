<?php
    $host = "localhost";
    $database = "autoquiray";
    $user = "root";
    $password = "123";
    
    try{
        $conn = new PDO(
            "mysql:host=$host;dbname=$database;charset=utf8",
            $user,
            $password,
            [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    } catch (PDOException $e) {
        die("PDO Connection Error: " . $e->getMessage());
    }