<?php
    session_start();

    if(!isset($_SESSION['usuario_id']))
    {
        header('Location: index.php');
        exit;    
    }

    $nombreUsuario = $_SESSION['usuario'] ?? 'Usuario';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página privada</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <div class="privada-container">
            <h1>Bienvenido, <?= htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8')?></h1>

            <p>Has iniciado sesión correctamente</p>

            <a class="boton" href="usuarios.php">Gestionar usuarios</a>
        </div>
    </body>
</html>