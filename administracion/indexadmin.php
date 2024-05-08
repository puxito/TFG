<?php

// ARCHIVOS
require("../php/errores.php");
require("../php/funciones.php");

// CONEXION
$conn = conectarBBDD();

// VARIABLES
$mensaje = '';

sesionN2();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="../media/logo.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/pancon.css">
    <title>FitFood</title>
</head>

<body>
    <header>
        <div>
            <a href="../index.php"><img src="../media/logoancho.png"></a>
        </div>
        <div class="panel">
            <h1 class="display-6"><strong>Panel de Control</strong></h1>
        </div>
        <nav>
            <?php
            // Verificar si hay una sesión iniciada y mostrar el perfil del usuario
            if (isset($_SESSION["correoElectronicoUsuario"])) {
                echo "<div class='perfil' id='perfil' onclick='toggleMenuPerfil()'>";

                $_SESSION['correoElectronicoUsuario'];
                $nombre_usuario = obtenerNombreUsuario();
                $ruta_imagen = obtenerRutaImagenUsuario();

                echo "   <img class='fotoperfil' src='../$ruta_imagen' alt='Foto de Perfil'>
                    <p class='nombre'>¡Hola, $nombre_usuario!</p>";
            } else {
                echo "<div class='perfil' id='perfil' onclick='toggleMenuPerfil()'>
                    <a href='../php/login.php'><strong>Iniciar sesión</strong></a>";
            }
            ?>
            </div>
        </nav>
    </header>
    <div id="menuPerfil">
        <?php if (isset($_SESSION["correoElectronicoUsuario"])) : ?>
            <a href="perfil.php">Mi Perfil</a>
            <form action="#" method="post">
                <input type="submit" value="Cerrar Sesión" name="cerses">
            </form>
            <script>
                function toggleMenuPerfil() {
                    var menuPerfil = document.getElementById("menuPerfil");
                    if (menuPerfil.style.display === "none") {
                        menuPerfil.style.display = "block";
                    } else {
                        menuPerfil.style.display = "none";
                    }
                }
            </script>
        <?php endif; ?>
    </div>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <article>
                        <h2>Administración de Usuarios</h2>
                        <p>Gestionar los usuarios del sitio web.</p>
                        <a href="../cruds/crud_usuarios.php" class="btn btn-primary">Acceder</a>
                    </article>
                </div>
                <div class="col-md-6">
                    <article>
                        <h2>Añadir Producto</h2>
                        <p>Nuevo producto para la base de datos.</p>
                        <a href="../prods/nuevoprod.php" class="btn btn-primary">Nuevo</a>
                    </article>
                </div>
                <div class="col-md-6">
                    <article>
                        <h2>Gestión de Productos</h2>
                        <p>Administrar los productos de la base de datos.</p>
                        <a href="../cruds/crud_productos.php" class="btn btn-primary">Acceder</a>
                    </article>
                </div>
                <div class="col-md-6">
                    <article>
                        <h2>Administración de Categorías</h2>
                        <p>Gestionar las categorías de los productos.</p>
                        <a href="../cruds/crud_categorias.php" class="btn btn-primary">Acceder</a>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
    </footer>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>