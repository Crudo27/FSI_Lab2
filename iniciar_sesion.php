<?php

    session_start();

    require __DIR__ ."/conexion.php";

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        http_response_code(405);
        die('Método no permitido: '.$conn->error);   
    }
    $usuario = trim($_POST['usuario'] ?? '');
    $clave = $_POST['password'] ?? '';

    $consulta = $conn->prepare('SELECT * FROM usuariost WHERE usuario = ?');
    $consulta->bind_param('s', $usuario);

    if(!$consulta->execute())
    {
        die('No se pudo ejecutar la consulta :'.$conn->error);
    }

    $resultado = $consulta->get_result();

    $usuarioVerificar = $resultado->fetch_assoc();

    if(!$usuarioVerificar || !password_verify($clave, $usuarioVerificar['password']))
    {
        exit('Usuario o contraseña incorrectos');
    }

    session_regenerate_id(true);

    $_SESSION['usuario_id'] = (int) $usuarioVerificar['id'];

    $_SESSION['usuario'] = $usuarioVerificar['usuario'];

    $consulta->close();

    header('Location: pagina_privada.php');
    exit;

?>