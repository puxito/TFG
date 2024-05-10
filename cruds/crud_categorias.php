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
$consultacategoria = "SELECT categorias.idCategoria, categorias.nombreCategoria, COUNT(productos.idProducto) AS numProductos
FROM categorias
LEFT JOIN productos ON categorias.idCategoria = productos.idCategoriaFK
GROUP BY categorias.idCategoria, categorias.nombreCategoria
";

$preparada = $conn->prepare($consultacategoria);
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
    $idCategoria = $_POST['idCategoria'];

    $borrarcategoria = "DELETE FROM categorias WHERE idCategoria =?";

    $preparada = $conn->prepare($borrarcategoria);
    $preparada->bind_param("i", $idCategoria);

    if ($preparada->execute()) {
        $mensaje = "Categoría eliminada correctamente";
    } else {
        $mensaje = "Error al eliminar la categoría";
    }
}

//-------------INSERT------------//
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
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
            <h1 class="display-6"><strong>Administración de Categorías</strong></h1>
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
    <footer>
        <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
    </footer>
    <article class="mx-3">
        <div class="input-with-icon">
            <button id="reload"><img src="../media/iconos/reload.png" alt="Recargar"></button>
            <input type="text" id="searchInput" placeholder="Buscar por nombre...">
        </div>
        <br>
        <table class="table table-striped mx-auto" id="categorias">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">NºProductos</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                foreach ($registros as $registro) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $registro['idCategoria'] . "</th>";
                    echo "<td>" . $registro['nombreCategoria'] . "</td>";
                    echo "<td>" . $registro['numProductos'] . "</td>";
                    echo "<td>
                            <form action=\"#\" method=\"post\">
                                <input type=\"hidden\" name=\"idCategoria\" value=\"" . $registro['idCategoria'] . "\">
                                <button type=\"submit\" name=\"editar\"><img src=\"../media/iconos/edit.png\" style=\"width:15px\"></button>
                            </form>
                            </td>
                            <td>
                            <form action=\"#\" method=\"post\" onsubmit=\"return confirmarEliminacion()\">
                                <input type=\"hidden\" name=\"idCategoria\" value=\"" . $registro['idCategoria'] . "\">
                                <button type=\"submit\" name=\"eliminar\"><img src=\"../media/iconos/delete.png\" style=\"width:15px\"></button>
                            </form>
                            </td>";
                    echo "</tr>";
                }
                ?>
                <!-- Formulario de edición -->

        </table>
    </article>
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
                $("#categorias tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        // Confirmación de eliminación
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que quieres eliminar este usuario?");
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>