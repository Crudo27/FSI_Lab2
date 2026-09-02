<?php
    $servidor = 'localhost';
    $database = 'biblioteca';
    $usuario = 'root';
    $clave = '';

    $conn = new mysqli($servidor, $usuario, $clave, $database);

    if($conn->connect_error)
    {
        die("Connection failed: ".$conn->connect_error);  
    }
?>