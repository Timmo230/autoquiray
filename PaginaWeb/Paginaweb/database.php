<?php
    $host = "localhost";
    $database = "autoquiray";
    $user = "root";
    $password = "123";

    try{
        $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    } catch (PDOExeption $e) {
        die("PDO Connection Error: " . $e->getMessage());
    }