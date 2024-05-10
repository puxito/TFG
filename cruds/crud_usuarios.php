<?php
// ARCHIVOS

require("../php/errores.php");
require("../php/funciones.php");

// VARIABLES
$mensaje = '';
sesionN2();
// Conexión con la BBDD
$conn = conectarBBDD();

//-------------SELECT------------//

$consultausuario = "SELECT * FROM usuarios LEFT JOIN roles ON usuarios.idRolFK = roles.idRol";

$preparada = $conn->prepare($consultausuario);
if ($preparada === false) {
    die("Error en la preparación: " . $conn->error);
}

$preparada->execute();


$resultado = $preparada->get_result();
$registros = $resultado->fetch_all(MYSQLI_ASSOC);


if ($registros === false) {
    die("Error en la ejecución: " . $conn->error);
}

//-------------DELETE------------//

if (isset($_POST['eliminar'])) {
    $idUsuario = $_POST['idUsuario'];

    $borrarusuario = "DELETE FROM usuarios WHERE idUsuario =?";

    $preparada = $conn->prepare($borrarusuario);
    $preparada->bind_param("i", $idUsuario);

    if ($preparada->execute()) {
        $mensaje = "Usuario eliminado correctamente";
    } else {
        $mensaje = "No se ha podido eliminar el usuario";
    }
}
//-------------UPDATE------------//
if (isset($_POST["actualizar"])) {
    $idUsuario = $_POST["idUsuario"];
    $nombreUsuario = $_POST["nombreUsuario"];
    $apellidosUsuario = $_POST["apellidosUsuario"];
    $fechaNacimientoUsuario = $_POST["fechaNacimientoUsuario"];
    $correoElectronicoUsuario = $_POST["correoElectronicoUsuario"];
    $idRolFK = $_POST["idRolFK"];

    // Consulta para actualizar los datos
    $actualizarusuario = "UPDATE usuarios SET nombreUsuario =?, 
                                              apellidosUsuario =?, 
                                              fechaNacimientoUsuario =?, 
                                              correoElectronicoUsuario =?, 
                                              idRolFK =? 
                                              WHERE idUsuario =?";

    $preparada = $conn->prepare($actualizarusuario);
    $preparada->bind_param("ssssii", $nombreUsuario, $apellidosUsuario, $fechaNacimientoUsuario, $correoElectronicoUsuario, $idRolFK, $idUsuario);

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
    <title>Usuarios</title>
    <link rel="icon" href="../media/logo.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../estilos/adminstyle.css">
</head>

<body>
    <header>
        <div>
            <a href="../index.php"><img src="../media/logoancho.png"></a>
        </div>
        <div class="panel">
            <h1 class="display-6"><strong>Administración de Usuarios</strong></h1>
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
    <article class="mx-3">
        <div class="input-with-icon">
            <button id="reload"><img src="../media/iconos/reload.png" alt="Recargar"></button>
            <input type="text" id="searchInput" placeholder="Buscar por nombre...">
        </div>
        <h5 id="mensaje" style="text-align: center"><?php echo $mensaje;?></h5>
        <br>
        <table class="table table-striped mx-auto" id="usuarios">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Correo Electrónico</th>
                    <th scope="col">Fecha de Nacimiento</th>
                    <th scope="col">Fecha de Registro</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
    <?php
    foreach ($registros as $registro) {
        echo "<tr>";
        echo "<th scope='row'>" . $registro['idUsuario'] . "</th>";
        echo "<td>" . $registro['nombreUsuario'] . "</td>";
        echo "<td>" . $registro['apellidosUsuario'] . "</td>";
        echo "<td>" . $registro['correoElectronicoUsuario'] . "</td>";
        echo "<td>" . $registro['fechaNacimientoUsuario'] . "</td>";
        echo "<td>" . $registro['fechaRegistroUsuario'] . "</td>";
        echo "<td>" . $registro['nombreRol'] . "</td>";
        echo "<td>
                <button type=\"button\" onclick=\"toggleForm(" . $registro['idUsuario'] . ")\"><img src=\"../media/iconos/edit.png\" style=\"width:15px\"></button>
                </td>
                <td>
                <form action=\"#\" method=\"post\" onsubmit=\"return confirmarEliminacion()\">
                    <input type=\"hidden\" name=\"idUsuario\" value=\"" . $registro['idUsuario'] . "\">
                    <button type=\"submit\" name=\"eliminar\"><img src=\"../media/iconos/delete.png\" style=\"width:15px\"></button>
                </form>
                </td>";
        echo "</tr>";

        // Formulario de edición oculto para cada usuario
        echo "<tr id=\"form-" . $registro['idUsuario'] . "\" style=\"display:none;\">
                <td colspan=\"9\">
                    <form action=\"#\" class=\"form\" method=\"post\">
                        <fieldset class=\"w-50 mx-auto\">
                            <input type=\"hidden\" name=\"idUsuario\" value=\"" . $registro['idUsuario'] . "\">
                            <input class=\"form-control\" type=\"text\" name=\"nombreUsuario\" value=\"" . $registro['nombreUsuario'] . "\">
                            <br>
                            <input class=\"form-control\" type=\"text\" name=\"apellidosUsuario\" value=\"" . $registro['apellidosUsuario'] . "\">
                            <br>
                            <input class=\"form-control\" type=\"text\" name=\"correoElectronicoUsuario\" value=\"" . $registro['correoElectronicoUsuario'] . "\">
                            <br>
                            <input class=\"form-control\" type=\"date\" name=\"fechaNacimientoUsuario\" value=\"" . $registro['fechaNacimientoUsuario'] . "\">
                            <br>
                            <select name=\"idRolFK\" id=\"idRolFK\">
                                <option value=\"1\" " . ($registro['idRolFK'] == 1 ? "selected" : "") . ">Administrador</option>
                                <option value=\"2\" " . ($registro['idRolFK'] == 2 ? "selected" : "") . ">Dietista</option>
                                <option value=\"3\" " . ($registro['idRolFK'] == 3 ? "selected" : "") . ">Cliente</option>
                            </select>
                            <input type=\"submit\" value=\"Actualizar\" class=\"form-control\" name=\"actualizar\">
                        </fieldset>
                    </form>
                </td>
            </tr>";
    }
    ?>
</tbody>
        </table>
    </article>
    <footer>
        <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
    </footer>
    <script>
        const reload = document.getElementById("reload");

        reload.addEventListener("click", (_) => {
            
            location.reload();
        });
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#usuarios tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que quieres eliminar este usuario?");
        }

        function toggleForm(idUsuario) {
            var form = document.getElementById('form-' + idUsuario);
            if (form.style.display === 'none') {
                form.style.display = 'table-row';
            } else {
                form.style.display = 'none';
            }
        }

        setTimeout(function() {
            document.getElementById("mensaje").style.display = "none";
        },2000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>