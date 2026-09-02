<?php
    session_start();

    if(!isset($_SESSION['usuario_id']))
    {
        header('Location: index.php');
        exit;
    }

    require __DIR__ ."/conexion.php";

    $resultado = $conn->query('SELECT id, usuario FROM usuariost ORDER BY id');

    if(!$resultado)
    {
        die('Error en la consulta: '.$conn->error);
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Usuarios</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <div class="usuarios-container">
            <h1>Usuarios</h1>

            <a class="boton" href="crear_usuario.php">Nuevo usuario</a>
            <a class="boton" href="pagina_privada.php">Volver</a>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while($usuario = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= (int) $usuario['id'] ?></td>
                            <td><?= htmlspecialchars($usuario['usuario'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><a href="editar_usuario.php?id=<?= (int) $usuario['id'] ?>">Editar</a></td>
                            <td>
                                <form action="eliminar_usuario.php" method="post" onsubmit="return confirm('¿Deseas eliminar este usuario?');">
                                    <input type="hidden" name="id" value="<?= (int) $usuario['id'] ?>">
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>