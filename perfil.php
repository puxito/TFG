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

// Sacar id por evento

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            </nav>
    </div>
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
    <br>
    <section class="profile-section">
        <article class="profile-article">
            <h2>Perfil de <?php echo $datosUsuario['nombreUsuario'] ?></h2>

            <button id="reload" style="width: auto;"><img src="media/iconos/reload.png" alt="Recargar" style="width: 20px;"></button>

            <form action="procesar_subida.php" method="post" enctype="multipart/form-data">
                <img class="rounded-circle border-1 border-primary" src="<?php echo $datosUsuario['imagenUsuario'] ?>" alt="Foto de Perfil" width="15%">
                <input type="file" id="imagen" name="imagen" accept="image/*"><br>
                <button class="btn">Cambiar Foto de Perfil</button>
            </form>

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
                    <td><input id="edad" name="edad" value="<?php echo getAgeForCurrentUser($idUsuario); ?>" readonly>
                    </td>
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
    <br>
    <div class="container">
        <div>
            <div id='calendar' style="background-color: #f2f2f2"></div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
    </footer>
    <div class="modal fade" id="modalAgregarEvento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarEvento" action="dietas/agregarDietas.php" method="POST">
                        <div class="form-group">
                            <label for="title">Agregue una dieta</label>
                            <input type="text" class="form-control" id="title" name="title">
                            <label for="color">Color</label>
                            <input type="color" class="form-control" id="color" name="color">
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control" id="start" name="start">
                            <input type="date" class="form-control" id="end" name="end">
                            <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $idUsuario; ?>">
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Guardar"></input>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditarEvento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- Modal de edición del evento -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditarEvento" action="dietas/actualizarDieta.php" method="POST">
                        <input type="hidden" id="editEventId" name="editEventId">
                        <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $idUsuario; ?>">
                        <div class="form-group">
                            <label for="editTitle">Título:</label>
                            <input type="text" class="form-control" id="editTitle" name="editTitle">
                        </div>
                        <div class="form-group">
                            <label for="editStart">Fecha de Inicio:</label>
                            <input type="date" class="form-control" id="editStart" name="editStart">
                        </div>
                        <div class="form-group">
                            <label for="editEnd">Fecha de Finalización:</label>
                            <input type="date" class="form-control" id="editEnd" name="editEnd">
                        </div>
                        <div class="form-group">
                            <label for="editColor">Color:</label>
                            <input type="color" class="form-control" id="editColor" name="editColor">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // EDICION DE DATOS
        function editardatos() {
            let $formcontrol = document.getElementsByClassName("form-control editable-field");
            for (let i = 0; i < $formcontrol.length; i++) {
                $formcontrol[i].removeAttribute("readonly");
            }
            document.getElementById("save-btn").style.display = "inline-block";
        }
        const reload = document.getElementById("reload");
        // RECARGAR
        reload.addEventListener("click", (_) => {

            location.reload();
        });

        // CALENDARIO
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                editable: true,
                selectable: true,
                selectMirror: true,
                allDaySlot: false,

                // Configuración para cargar eventos y pasar el correo electrónico del usuario
                events: {
                    url: 'dietas/cargarDietas.php',
                    method: 'POST',
                    extraParams: {
                        correoElectronicoUsuario: '<?php echo obtenerCorreoElectronicoUsuario(); ?>'
                    }
                },
                dateClick: function(info) {
                    $('#modalAgregarEvento').modal('show');
                    $('#start').val(info.allDay);
                },
                eventClick: function(info) {

                }
            });
            calendar.render();
        });
    </script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>