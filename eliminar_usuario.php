<?php
    session_start();

    if(!isset($_SESSION['usuario_id']))
    {
        header('Location: index.php');
        exit;
    }

    require __DIR__ ."/conexion.php";

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

    if($id === (int) $_SESSION['usuario_id'])
    {
        exit('No puedes eliminar el usuario con la sesión activa');
    }

    $consulta = $conn->prepare('DELETE FROM usuariost WHERE id = ?');
    $consulta->bind_param('i', $id);

    if(!$consulta->execute())
    {
        exit('No se pudo eliminar el usuario: '.$conn->error);
    }

    $consulta->close();

    header('Location: usuarios.php');
    exit;
?>