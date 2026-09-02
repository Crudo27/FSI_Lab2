<?php
    require __DIR__.'/conexion.php';

    $resultado = $conn->query('SELECT id, nombre, autor, isbn, descripcion FROM libros');
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
        <title>Tabla</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Libro:</th>
                    <th>Autor:</th>
                    <th>ISBN:</th>
                    <th>Descripcion</th>
                    <th>Eliminar</th>
                    <th>Modificar</th>
                </tr>
            </thead>

            <tbody>
                <?php while($libro = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($libro['nombre']) ?></td>
                        <td><?= htmlspecialchars($libro['autor']) ?></td>
                        <td><?= htmlspecialchars($libro['isbn']) ?></td>
                        <td><?= htmlspecialchars($libro['descripcion']) ?></td>
                        <td>
                            <form action="eliminar.php" method="post" onsubmit="return confirm('¿Deseas eliminar este libro?');">
                                <input type="hidden" name="id" value="<?= (int) $libro['id'] ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                        <td><a href="editar.php?id=<?=(int) $libro['id']?>">Editar</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </body>
</html>