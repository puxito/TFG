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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="icon" href="../media/logo.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/adminstyle.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <header>
        <div>
            <a href="../index.php"><img src="../media/logoancho.png"></a>
        </div>
        <div class="panel">
            <h1 class="display-6"><strong>Administración de Usuarios</strong></h1>
        </div>
        <div class="perfil">
            <!-- Agrega contenido aquí si es necesario -->
        </div>
    </header>

    <article class="mx-3">
        <div class="input-with-icon">
            <button id="reload">Click para recargar</button>
            <input type="text" id="searchInput" placeholder="Buscar por nombre...">
        </div>
        <br>
        <table class="table table-striped mx-auto" id="usuarios">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Correo Electrónico</th>
                    <th scope="col">Fecha de Nacimiento</th>
                    <th scope="col">Contraseña</th>
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
                    echo "<td>" . $registro['contraseña'] . "</td>";
                    echo "<td>" . $registro['fechaRegistroUsuario'] . "</td>";
                    echo "<td>" . $registro['nombreRol'] . "</td>";
                    echo "<td>
                            <form action=\"#\" method=\"post\">
                                <input type=\"hidden\" name=\"idUsuario\" value=\"" . $registro['idUsuario'] . "\">
                                <button type=\"submit\" name=\"editar\"><img src=\"../media/iconos/edit.png\" style=\"width:15px\"></button>
                            </form>
                            </td>
                            <td>
                            <form action=\"#\" method=\"post\" onsubmit=\"return confirmarEliminacion()\">
                                <input type=\"hidden\" name=\"idUsuario\" value=\"" . $registro['idUsuario'] . "\">
                                <button type=\"submit\" name=\"eliminar\"><img src=\"../media/iconos/delete.png\" style=\"width:15px\"></button>
                            </form>
                            </td>";
                    echo "</tr>";
                }
                ?>
                <!-- Formulario de edición -->

                <!-- Formulario de eliminación -->

        </table>
    </article>
    <footer>
        <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
    </footer>
    <script>
        const reload = document.getElementById("reload");

        reload.addEventListener("click", (_) => {
            // el _ es para indicar la ausencia de parametros
            location.reload();
        });
        // Función para filtrar usuarios por nombre
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#usuarios tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        // Confirmación de eliminación
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que quieres eliminar este usuario?");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>