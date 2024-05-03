<?php
// ARCHIVOS

require("errores.php");
require("funciones.php");

// Sesiones
session_start();

// VARIABLES
$mensaje = '';

// Conexión con la BBDD-------
$conn = conectarBBDD();

$mensajesesion = inicioSesion($conn);

// Cerrar la conexión
$conn->close();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="icon" href="../media/logo.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../estilos/loginstyle.css">
</head>

<body>
    <header>
        <div>
            <p><img src="../media/logoancho.png"></p>
        </div>
    </header>
    <div class="container">
        <div class="center-content">
            <h2>Iniciar sesión</h2>
            <img src="../media/logo.png" alt="Logo de la página web">
        </div>
        <form method="post" action="#">
            <div class="input-container">
                <label for="email">Correo electrónico</label>
                <div class="input-with-icon">
                    <input type="text" id="email" name="email" placeholder="Ingrese su correo electrónico" class="form-control">
                    <img src="../media/iconos/usuario.png" alt="Correo electrónico">
                </div>
            </div>
            <div class="input-container">
                <label for="password">Contraseña</label>
                <div class="input-with-icon">
                    <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" class="form-control">
                    <img src="../media/iconos/contrasena.jpg" alt="Contraseña">
                </div>
            </div>
            <div class="forgot-password">
                <a href="#">¿Olvidaste la contraseña?</a>
            </div>
            <div class="button-container">
                <input type="submit" class="login-btn" value="Entrar">
                <a href="registro.php" class="register-btn">Registrarse</a>
            </div>
        </form>
    </div>
    <?php
    $mensajesesion;
    ?>
    <footer>
        <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
    </footer>
</body>

</html>