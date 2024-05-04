<?php
require("php/errores.php");
require("php/funciones.php");

// CONEXION
$conn = conectarBBDD();

$ruta_imagen = obtenerRutaImagenUsuario();
$nombre_usuario = obtenerNombreUsuario();
//-------------SELECT------------//
// Sacar la consulta

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitFood</title>
    <link rel="icon" href="media/logo.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="estilos/indexstyle.css">
</head>

<body>
    <header>
        <div>
            <p><img src="media/logoancho.png"></p>
        </div>
        <nav>
            <div class="dieta">
                <a href="prods/productos.php">
                    <img class="icono1" src="media/iconos/productos.png" alt="Ver productos">
                </a>
                <a href="dietas/dieta.php">
                    <img class="icono2" src="media/iconos/add.png" alt="Nueva Dieta">
                </a>
            </div>
            <div class="perfil" id="perfil" onclick="mostrarMenu()">
                <?php if (isset($_SESSION["correoElectronicoUsuario"])) : ?>
                    <img class="fotoperfil" src="<?php echo obtenerRutaImagenUsuario(); ?>" alt="Foto de Perfil">
                    <p class="nombre">Buenas, <?php echo obtenerNombreUsuario(); ?></p>
                <?php else : ?>
                    <a href="login.php" class="enlace-perfil">Iniciar sesión</a> /
                    <a href="registro.php" class="enlace-perfil">Registrarse</a>
                <?php endif; ?>
            </div>

            <div onclick="showMenu(event)" id="menuPerfil" style="display: none;">
                <?php if (isset($_SESSION["correoElectronicoUsuario"])) : ?>
                    <a href="mi_perfil.php">Mi Perfil</a>
                    <form action="#" method="post">
                        <input type="submit" value="Cerrar Sesión" name="cerses">
                    </form>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <form action="#" method="post">
        <input type="submit" value="Cerrar Sesión" name="cerses">
    </form>
    <div class="container">
        <!-- Carrusel con flechas -->
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="media/general/inicio1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="media/general/inicio2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="media/general/inicio3.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
    </footer>
    <script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>