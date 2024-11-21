<?php

function connect(){
    $servername = "localhost";
    $username = "dbuser";
    $password = "agrawal@2002";
    $dbname = "inventorymanagement";
    $connection= new mysqli($servername, $username, $password,$dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    return $connection;
}


