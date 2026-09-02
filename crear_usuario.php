<?php
    session_start();

    if(!isset($_SESSION['usuario_id']))
    {
        header('Location: index.php');
        exit;
    }

    require __DIR__ ."/conexion.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $usuario = trim($_POST['usuario'] ?? '');
        $clave = $_POST['password'] ?? '';

        if($usuario === '' || $clave === '')
        {
            exit('Completa todos los campos');
        }

        $password = password_hash($clave, PASSWORD_DEFAULT);

        $consulta = $conn->prepare('INSERT INTO usuariost (usuario, password) VALUES (?, ?)');
        $consulta->bind_param('ss', $usuario, $password);

        if(!$consulta->execute())
        {
            exit('No se pudo crear el usuario: '.$conn->error);
        }

        $consulta->close();

        header('Location: usuarios.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Crear Usuario</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <div class="form-container">
            <h1>Crear usuario</h1>

            <form action="crear_usuario.php" method="post">
                <label for="usuario">Usuario:</label>
                <input id="usuario" type="text" name="usuario" required>

                <label for="password">Contraseña:</label>
                <input id="password" type="password" name="password" required>

                <button type="submit">Guardar</button>
                <a href="usuarios.php">Cancelar</a>
            </form>
        </div>
    </body>
</html>