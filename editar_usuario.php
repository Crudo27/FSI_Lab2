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
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $usuario = trim($_POST['usuario'] ?? '');
        $clave = $_POST['password'] ?? '';

        if(!$id || $usuario === '')
        {
            exit('Datos inválidos');
        }

        if($clave !== '')
        {
            $password = password_hash($clave, PASSWORD_DEFAULT);
            $consulta = $conn->prepare('UPDATE usuariost SET usuario = ?, password = ? WHERE id = ?');
            $consulta->bind_param('ssi', $usuario, $password, $id);
        }
        else
        {
            $consulta = $conn->prepare('UPDATE usuariost SET usuario = ? WHERE id = ?');
            $consulta->bind_param('si', $usuario, $id);
        }

        if(!$consulta->execute())
        {
            exit('No se pudo actualizar el usuario: '.$conn->error);
        }

        $consulta->close();

        header('Location: usuarios.php');
        exit;
    }

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if(!$id)
    {
        exit('Identificador inválido');
    }

    $consulta = $conn->prepare('SELECT id, usuario FROM usuariost WHERE id = ?');
    $consulta->bind_param('i', $id);
    $consulta->execute();

    $resultado = $consulta->get_result();
    $usuarioEditar = $resultado->fetch_assoc();

    if(!$usuarioEditar)
    {
        exit('El usuario no existe');
    }

    $consulta->close();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Usuario</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <div class="form-container">
            <h1>Editar usuario</h1>

            <form action="editar_usuario.php" method="post">
                <input type="hidden" name="id" value="<?= (int) $usuarioEditar['id'] ?>">

                <label for="usuario">Usuario:</label>
                <input id="usuario" type="text" name="usuario" value="<?= htmlspecialchars($usuarioEditar['usuario'], ENT_QUOTES, 'UTF-8') ?>" required>

                <label for="password">Nueva contraseña:</label>
                <input id="password" type="password" name="password">

                <button type="submit">Guardar</button>
                <a href="usuarios.php">Cancelar</a>
            </form>
        </div>
    </body>
</html>