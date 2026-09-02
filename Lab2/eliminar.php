<?php
    require __DIR__.'/conexion.php';

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        http_response_code(405);
        exit('Método no permitido');
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if(!$id)
    {
        exit('Identificador inválido');
    }

    $consulta = $conn->prepare('DELETE FROM libros WHERE id = ?');

    $consulta->bind_param('i', $id);
    
    if(!$consulta->execute())
    {
        exit('No se pudo eliminar el libro: '.$conn->error);
    }

    $consulta->close();

    header('Location: index.php');
    exit;
?>