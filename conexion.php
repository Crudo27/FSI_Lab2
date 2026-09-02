<?php
    $servidor = 'localhost';
    $database = 'usuarios';
    $usuario = 'root';
    $clave = '';

    $conn = new mysqli($servidor, $usuario, $clave, $database);
    
    if($conn->connect_error)
    {
        die("Error de conexión: ".$conn->connect_error);
    }
?>