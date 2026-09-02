<?php

    require __DIR__ ."/conexion.php";

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio de Sesión</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <header>
            <div class="login-container">
                <div class="label">Login</div>
                <form class="inicio" action="iniciar_sesion.php" method="post">
                    <input id="usuario" class="usuario" type="text" name="usuario" placeholder="Usuario" autocomplete="username" required>
                    <input id="password" class="contraseña" type="password" name="password" placeholder="Contraseña" autocomplete="current-password" required>
                    <button class="login-button" type="submit">Iniciar Sesión</button>
                </form>
                <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
            </div>
        </header>
    </body>
</html>