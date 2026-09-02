<?php
    require __DIR__.'/conexion.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre'] ?? '');
        $autor = trim($_POST['autor'] ?? '');
        $isbn = trim($_POST['isbn'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        
        if(!$id)
        {
            exit('Identificador inválido');
        }

        if(!$id || $nombre === '' || $autor === '' || $isbn === '')
        {
            exit('Completa los campos obligatorios');
        }

        $consulta = $conn->prepare('UPDATE libros SET nombre = ?, autor = ?, isbn = ?, descripcion = ? WHERE id = ?');

        $consulta->bind_param('ssssi', $nombre, $autor, $isbn, $descripcion, $id);

        if(!$consulta->execute())
        {
            exit('No se pudo actualizar el libro: '.$conn->error);
        }
        
        $consulta->close();

        header('Location: index.php');

        exit; 
    }
    else
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if(!$id)
        {
            exit('Identificador inválido');   
        }

        $consulta = $conn->prepare('SELECT * FROM libros WHERE id = ?');
        $consulta->bind_param('i', $id);

        if(!$consulta->execute())
        {
            exit('No se pudo obtener el libro: '.$conn->error);
        }

        $resultado = $consulta->get_result();
        $libro = $resultado->fetch_assoc();

        if(!$libro)
            {
                http_response_code(404);
                exit('El libro no existe.');
            }

        $consulta->close();
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Libro</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <h1>Editar libro</h1>

        <form action="editar.php" method="post">
            <input type="hidden" name="id" value="<?= (int) $libro['id']?>">
            <div class="editar"> 
                <label for="nombre">Nombre del libro:</label>
                <input id="nombre" type="text" name="nombre" value="<?= htmlspecialchars($libro['nombre'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="editar">
                <label for="autor">Autor:</label>
                <input id="autor" type="text" name="autor" value="<?=htmlspecialchars($libro['autor'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="editar">
                <label for="isbn">ISBN: </label>
                <input id="isbn" type="text" name="isbn" value="<?=htmlspecialchars($libro['isbn'], ENT_QUOTES, 'UTF-8')?>" required>
            </div>

            <div class="editar">
                <label for="descripcion">Descripción:</label>
                <input id="descripcion" type="text" name="descripcion" value="<?=htmlspecialchars($libro['descripcion'], ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <button type="submit">
                Guardar
            </button>

            <a href="index.php">Cancelar</a>
        </form>
    </body>
</html>