<?php
// ARCHIVOS
require("errores.php");
require("funciones.php");

// SESIÓN
session_start();

// CONEXIÓN
$conn = conectarBBDD();

// VARIABLES
$mensaje = '';

// Verificar la sesión y el rol del usuario
$usu = sesionN1();

// Obtener el rol del usuario
$correoElectronicoUsuario = $_SESSION["correoElectronicoUsuario"];
$sql = "SELECT idRolFK FROM usuarios WHERE correoElectronicoUsuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correoElectronicoUsuario);
$stmt->execute();
$result = $stmt->get_result();
$fila = $result->fetch_assoc();
$rol = $fila["idRolFK"];

// Zona de Administradores (rol = 1)
if ($rol == 1) {
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FitFood</title>
        <link rel="icon" href="../media/logo.png" type="image/x-icon" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../estilos/menustyle.css">
    </head>

    <body>
        <header>
            <div>
                <a href="../index.php"><img src="../media/logoancho.png"></a>
            </div>
            <nav>
            <?php
            if (sesionN1()) {
                echo "<div class='perfil' id='perfil' onclick='toggleMenuPerfil()'>";

                $_SESSION['correoElectronicoUsuario'];
                $nombre_usuario = obtenerNombreUsuario();
                $ruta_imagen = obtenerRutaImagenUsuario();

                echo "   <img class='fotoperfil' src='../$ruta_imagen' alt='Foto de Perfil'>
                    <p class='nombre'>¡Hola, $nombre_usuario!</p>";
            } else {
                echo "<div class='perfil' id='perfil' onclick='toggleMenuPerfil()'>
                    <a href='php/login.php'><strong>Iniciar sesión</strong></a>";
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
                <div class="col">
                    <div class="col-md-6">
                        <article>
                            <h2>Panel de Control &#128736;</h2>
                            <p>Acceso solo administradores</p>
                            <a href="../administracion/indexadmin.php" class="btn btn-primary">Acceder</a>
                        </article>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="col">
                    <div class="col-md-6">
                        <article>
                            <h2>Sitio Web</h2>
                            <p>Acceso General</p>
                            <a href="../index.php" class="btn btn-primary">Acceder</a>
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

<?php
}
?>

<?php
// Zona de Usuarios Clientes (rol = 3)
if ($rol == 3) {
    header("Location: ../index.php");
    exit();
}
?>