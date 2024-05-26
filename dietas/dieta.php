<?php
// ARCHIVOS
require("../php/errores.php");
require("../php/funciones.php");

// CONEXION
$conn = conectarBBDD();

// VARIABLES
$mensaje = '';

// Verificar si hay una sesión iniciada
sesionN1();

$idUsuario = obtenerIDUsuario();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Dieta</title>
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+onE6pRhejjBo5S1a1Jo3t4H2y74p" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #006691;">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img class="rounded" src="../media/logoancho.png" alt="logo" width="155">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <?php
                if (sesionN0()) {
                    // El usuario ha iniciado sesión

                    // Verificar si el usuario es administrador
                    $conexion = conectarBBDD();
                    $nombre_usuario = $_SESSION["correoElectronicoUsuario"];
                    $sql = "SELECT idRolFK FROM usuarios WHERE correoElectronicoUsuario = ?";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("s", $nombre_usuario);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $fila = $result->fetch_assoc();
                    $administrador = $fila["idRolFK"];
                    $stmt->close();
                    $conexion->close();

                    $nombre_usuario = obtenerNombreUsuario();
                    $ruta_imagen = obtenerRutaImagenUsuario();
                    echo '
                        <ul class="ms-auto m-2 navbar-nav">
                            <li class="border border-dark rounded dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <img class="rounded-circle" src="../' . $ruta_imagen . '" width="65" alt="Foto de Perfil">
                                    Bienvenido: <span class="fw-bold">' . $nombre_usuario . '</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../perfil.php">Mi Perfil</a></li>';
                    if ($administrador == 1) {
                        echo '<li><a class="dropdown-item" href="../administracion/indexadmin.php">Panel de Control</a></li>';
                    }
                    echo '       
                                    <form method="post">
                                        <input type="hidden" name="cerses" value="true">
                                        <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                                    </form>
                                </ul>
                            </li>
                        </ul>';
                } else {
                    echo '
                        <article class="ms-auto">
                            <h2 hidden>Inicio sesión</h2>
                            <form class="d-flex align-items-center" method="post">
                                <div class="">
                                    <a class="btn btn-primary" href="../php/login.php">Iniciar Sesion</a>
                                    <a class="btn btn-primary" href="../php/registro.php">Registrarse</a>
                                </div>
                            </form>
                        </article>';
                }
                ?>
            </div>
        </div>
    </nav>

    <!-- Aquí va el contenido principal de la página -->

    <footer class="footer bg-dark text-light p-2 mt-4">
        <div class="container">
            <div class="row m-3">
                <div class="col-md-6 col-sm-12">
                    <h5>Información de contacto</h5>
                    <p>Email: info@example.com</p>
                    <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 col-sm-12">
                    <h5>Enlaces útiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">Inicio</a></li>
                        <li><a href="#" class="text-light">Servicios</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
