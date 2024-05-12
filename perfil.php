<?php
// ARCHIVOS
require("php/errores.php");
require("php/funciones.php");

// CONEXION
$conn = conectarBBDD();

// VARIABLES
$mensaje = '';

// Verificar si hay una sesión iniciada
sesionN1();

// Obtener el ID del usuario actualmente conectado
$idUsuario = obtenerIDUsuario();

// Obtener los datos del usuario de la base de datos
$datosUsuario = obtenerDatosUsuario();

// Verificar si se enviaron datos del formulario y actualizar los datos del usuario si es necesario
if (isset($_POST["actualizar"])) {
    $idUsuario = $_POST["idUsuario"];
    $nombreUsuario = $_POST["nombreUsuario"];
    $apellidosUsuario = $_POST["apellidosUsuario"];
    $fechaNacimientoUsuario = $_POST["fechaNacimientoUsuario"];
    $correoElectronicoUsuario = $_POST["correoElectronicoUsuario"];

    // Consulta para actualizar los datos
    $actualizarusuario = "UPDATE usuarios SET nombreUsuario =?, 
                                              apellidosUsuario =?, 
                                              fechaNacimientoUsuario =?, 
                                              correoElectronicoUsuario =?  
                                              WHERE idUsuario =?";

    $preparada = $conn->prepare($actualizarusuario);
    $preparada->bind_param("ssssi", $nombreUsuario, $apellidosUsuario, $fechaNacimientoUsuario, $correoElectronicoUsuario, $idUsuario);

    if ($preparada->execute()) {
        $mensaje = "Usuario actualizado correctamente";
    } else {
        $mensaje = "No se ha podido actualizar el usuario";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <link rel="stylesheet" href="../estilos/perfilstyle.css">
</head>

<body>
    <div class="main-content">
        <header>
            <div>
                <a href="../index.php"><img src="../media/logoancho.png"></a>
            </div>
            <nav>
                <?php
                if (sesionN1()) {
                    echo "<div class='perfil' id='perfil' onclick='toggleMenuPerfil()'>";

                    // Mostrar la foto de perfil del usuario y su nombre
                    echo "<img class='fotoperfil' src='../" . $datosUsuario['imagenUsuario'] . "' alt='Foto de Perfil'>";
                    echo "<p class='nombre'>¡Hola, " . $datosUsuario['nombreUsuario'] . "!</p>";
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
            <a href="../perfil.php">Mi Perfil</a>
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
    <section class="profile-section">

        <article class="profile-article">
            <h2>Perfil de <?php echo $datosUsuario['nombreUsuario'] ?></h2>
            <button id="reload" style="width: auto;"><img src="media/iconos/reload.png" alt="Recargar" style="width: 20px;"></button>
            <div class="profile-image">
                <img src="<?php echo $datosUsuario['imagenUsuario'] ?>" alt="Foto de Perfil">
                <button id="change-photo-btn">Cambiar Foto de Perfil</button>
            </div>
            <form id="personal-info-form" action="#" method="post">
                <table>
                    <tr>
                        <td><label for="nombre">Nombre:</label></td>
                        <td><input type="text" id="nombreUsuario" name="nombreUsuario" value="<?php echo $datosUsuario['nombreUsuario']; ?>" readonly class="form-control editable-field"></td>
                    </tr>
                    <tr>
                        <td><label for="apellido">Apellido:</label></td>
                        <td><input type="text" id="apellidosUsuario" name="apellidosUsuario" value="<?php echo $datosUsuario['apellidosUsuario']; ?>" readonly class="form-control editable-field"></td>
                    </tr>
                    <tr>
                        <td><label for="correo">Correo Electrónico:</label></td>
                        <td><input type="email" id="correoElectronicoUsuario" name="correoElectronicoUsuario" value="<?php echo $datosUsuario['correoElectronicoUsuario']; ?>" readonly class="form-control editable-field"></td>
                    </tr>
                    <tr>
                        <td><label for="fecha">Fecha de Registro:</label></td>
                        <td><input type="text" id="fechaNacimientoUsuario" name="fechaNacimientoUsuario" value="<?php echo $datosUsuario['fechaNacimientoUsuario']; ?>" readonly class="form-control editable-field"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="button" id="edit-btn" onclick="editardatos()">Editar</button></td>
                        <td><button type="submit" name="actualizar" value="Guardar Cambios" id="save-btn" style="display: none;">Guardar Cambios</button></td>
                    </tr>
                    <tr>
                        <td><label for="password">Contraseña:</label></td>
                        <td>
                            <input type="password" id="contraseña" name="contraseña" value="<?php echo $datosUsuario['contraseña']; ?>" readonly>
                        </td>
                        <td>
                            <button id="show-password-btn" class="btn btn-info">Mostrar</button>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
            </form>
        </article>
        <article class="profile-article">
            <h2>Datos Personales</h2>
            <table>
                <tr>
                    <td><label for="edad">Edad:</label></td>
                    <td><input id="edad" name="edad"></td>
                </tr>
                <tr>
                    <td><label for="peso">Peso (kg):</label></td>
                    <td><input type="number" id="peso" name="peso"></td>
                </tr>
                <tr>
                    <td><label for="altura">Altura (cm):</label></td>
                    <td><input type="number" id="altura" name="altura"></td>
                </tr>
                <tr>
                    <td colspan="2"><button id="diets-btn">Mis Dietas</button></td>
                </tr>
            </table>
        </article>
    </section>
    <div class="container">
        <div>
            <div id='calendar' style="background-color: #ccc"></div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
    </footer>

    <script>
        function editardatos() {
            let $formcontrol = document.getElementsByClassName("form-control editable-field");
            for (let i = 0; i < $formcontrol.length; i++) {
                $formcontrol[i].removeAttribute("readonly");
            }
            document.getElementById("save-btn").style.display = "inline-block";
        }
        const reload = document.getElementById("reload");

        reload.addEventListener("click", (_) => {

            location.reload();
        });
        // CALENDARIO

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar')
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: "es",
                headerToolbar: {
                    left: 'prev, next today',
                    center: 'title',
                    right:'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                titleFormat: function() {
                    return 'Calendario de <?php echo $datosUsuario['nombreUsuario']; ?>'.toUpperCase();
                }
            });
            calendar.render()
        })
    </script>
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>