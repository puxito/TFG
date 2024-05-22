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

$edadUsu = getAgeForCurrentUser($idUsuario);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/perfilstyle.css">
</head>

<body>
    <nav class="navbar navbar-expand-xl" style="background-color: #006691;">
        <div class="container-fluid">
            <a href="index.php">
                <img class="rounded" src="media/logoancho.png" alt="logo" width="155">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item m-2">
                        <a href="dietas/dieta.php">
                            <img src="media/iconos/add.png" width="65" alt="Nueva Dieta">
                        </a>
                    </li>
                    <li class="nav-item m-2">
                        <a href="prods/productos.php">
                            <img src="media/iconos/productos.png" width="65" alt="Ver productos">
                        </a>
                    </li>
                    <li>
                        <p>&nbsp;&nbsp;&nbsp;</p>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.facebook.com/groups/798944041127303" target="_blank">&nbsp;<i class="fa-brands fa-facebook fa-lg"></i></i></a>
                    </li>
                </ul>
                <?php
                if (sesionN0()) {
                    // El usuario ha iniciado sesión

                    $nombre_usuario = obtenerNombreUsuario();
                    $ruta_imagen = obtenerRutaImagenUsuario();

                    echo '
                    <ul class="ms-auto m-2 navbar-nav">
                        <li class="border border-dark rounded dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <img src=' . $ruta_imagen . ' width="65" alt="Foto de Perfil">
                                Bienvenido: <span class="fw-bold">' . $nombre_usuario . '</span>
                            </a>
                        
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="perfil.php">Mi Perfil</a></li>
                                <li><a class="dropdown-item" href="#">¿?¿?</a></li>
                                <form method="post">
                                    <input type="hidden" name="cerses" value="true">
                                    <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                                </form>

                            </ul>
                        </li>
                    </ul>'
                ?>
                <?php
                } else {
                ?>
                    <article class="ms-auto">
                        <h2 hidden>Inicio sesión</h2>
                        <form class="d-flex align-items-center" method="post">
                            <div class="">
                                <a class="btn btn-primary" href="/php/login.php">Iniciar Sesion</a>
                                <a class="btn btn-primary" href="/php/registro.php">Registrarse</a>
                            </div>
                        </form>
                    </article>

                <?php
                }
                ?>

                </section>
    </nav>

    <!-- -------------------------- -->
    <!-- T I T U L O    P E R F I L -->
    <!-- ----------------------------->

    <section class="profile-section">
        <article class="profile-article">
            <h2>Perfil de <?php echo $datosUsuario['nombreUsuario']; ?></h2>

            <!-- BOTON RECARGA DE LA PÁGINA -->
            <button id="reload" class="btn btn-secondary" style="width: auto;">
                <img src="media/iconos/reload.png" alt="Recargar" style="width: 20px;">
            </button>

            <!-- SUBIDA DE FOTOS PERFIL -->
            <form action="procesar_subida.php" method="post" enctype="multipart/form-data" class="mt-3">
                <img class="rounded-circle border-1 border-primary" src="<?php echo $datosUsuario['imagenUsuario']; ?>" alt="Foto de Perfil" width="15%">
                <div class="mt-2">
                    <input type="file" id="imagen" name="imagen" accept="image/*" class="form-control-file">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Cambiar Foto de Perfil</button>
            </form>

            <!-- ACTUALIZACIÓN DE DATOS -->
            <form id="personal-info-form" action="#" method="post" class="mt-4">
                <table class="table">
                    <tr>
                        <td><label for="nombreUsuario">Nombre:</label></td>
                        <td><input type="text" id="nombreUsuario" name="nombreUsuario" value="<?php echo $datosUsuario['nombreUsuario']; ?>" readonly class="form-control editable-field"></td>
                    </tr>
                    <tr>
                        <td><label for="apellidosUsuario">Apellido:</label></td>
                        <td><input type="text" id="apellidosUsuario" name="apellidosUsuario" value="<?php echo $datosUsuario['apellidosUsuario']; ?>" readonly class="form-control editable-field"></td>
                    </tr>
                    <tr>
                        <td><label for="correoElectronicoUsuario">Correo Electrónico:</label></td>
                        <td><input type="email" id="correoElectronicoUsuario" name="correoElectronicoUsuario" value="<?php echo $datosUsuario['correoElectronicoUsuario']; ?>" readonly class="form-control editable-field"></td>
                    </tr>
                    <tr>
                        <td><label for="fechaNacimientoUsuario">Fecha de Nacimiento:</label></td>
                        <td><input type="text" id="fechaNacimientoUsuario" name="fechaNacimientoUsuario" value="<?php echo $datosUsuario['fechaNacimientoUsuario']; ?>" readonly class="form-control editable-field"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="button" id="edit-btn" class="btn btn-secondary" onclick="editardatos()">Editar</button>
                            <button type="submit" name="actualizar" class="btn btn-primary" id="save-btn" style="display: none;">Guardar Cambios</button>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
            </form>
        </article>

        <!-- DATOS PERSONALES -->
        <article class="profile-article">
            <h2>Datos Personales</h2>
            <table class="table">
                <tr>
                    <td><label for="edad">Edad:</label></td>
                    <td><?php echo $edadUsu; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><a href="#">Mis Dietas</a></td>
                </tr>
            </table>
        </article>
    </section>
    <br>
    <div class="container">
        <div>
            <div id='calendar' class="mt-2 mb-4 p-3 border rounded bg-light shadow-sm"></div>
        </div>
    </div>

    <!-- MODAL AGREGAR EVENTOS -->
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

    <!-- MODAL ACTUALIZAR EVENTOS -->
    <div class="modal fade" id="modalEditarEvento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
    <script src="../scripts/funciones.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>