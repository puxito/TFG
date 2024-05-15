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
// Sacar la consulta
$consultaproductos = "SELECT * FROM productos LEFT JOIN categorias ON productos.idCategoriaFK = categorias.idCategoria";
$preparada = $conn->prepare($consultaproductos);

// Control en la preparación
if ($preparada === false) {
    die("Error en la preparación: " . $conn->error);
}

// Ejecutar la consulta
$preparada->execute();

// Obtener los resultados
$resultado = $preparada->get_result();
$registros = $resultado->fetch_all(MYSQLI_ASSOC);

// Control en la ejecución
if ($registros === false) {
    die("Error en la ejecución: " . $conn->error);
}

//-------------DELETE------------//
if (isset($_POST['eliminar'])) {
    $idProducto = $_POST['idProducto'];

    $borrarproducto = "DELETE FROM productos WHERE idProducto =?";

    $preparada = $conn->prepare($borrarproducto);
    $preparada->bind_param("i", $idProducto);

    if ($preparada->execute()) {
        $mensaje = "Producto eliminado correctamente";
    } else {
        $mensaje = "No se ha podido eliminar el producto";
    }
}
//-------------UPDATE------------//

if (isset($_POST["actualizar"])) {
    $idProducto = $_POST['idProducto'];
    $nombreProducto = $_POST['nombreProducto'];
    $cantidadProducto = $_POST['cantidadProducto'];
    $hcarbonoProducto = $_POST['hcarbonoProducto'];
    $caloriasProducto = $_POST['caloriasProducto'];
    $grasasProducto = $_POST['grasasProducto'];
    $proteinasProducto = $_POST['proteinasProducto'];
    $idCategoriaFK = $_POST['idCategoriaFK'];

    // Consulta para actualizar los datos
    $actualizarproducto = "UPDATE productos SET nombreProducto =?,
                                                cantidadProducto=?,
                                                hcarbonoProducto=?,
                                                caloriasProducto=?,
                                                grasasProducto=?,
                                                proteinasProducto=?,
                                                idCategoriaFK=?
                                                WHERE idProducto =?";

    $preparada = $conn->prepare($actualizarproducto);
    $preparada->bind_param("siiddddd", $nombreProducto, $cantidadProducto, $hcarbonoProducto, $caloriasProducto, $grasasProducto, $proteinasProducto, $idCategoriaFK, $idProducto);

    if ($preparada->execute()) {
        $mensaje = "Producto actualizado correctamente";
    } else {
        $mensaje = "No se ha podido actualizar el producto";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
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
            <h1 class="display-6"><strong>Administración de Productos</strong></h1>
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
    <br>
    <article class="mx-3">
        <div class="input-with-icon">
            <button id="reload"><img src="../media/iconos/reload.png" alt="Recargar"></button>
            <input type="text" id="searchInput" placeholder="Buscar por nombre...">
        </div>
        <h5 id="mensaje" style="text-align: center"><?php echo $mensaje; ?></h5>
        <br>
        <table class="table table-striped mx-auto" id="productos">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">H.Carbono</th>
                    <th scope="col">Calorías</th>
                    <th scope="col">Grasas</th>
                    <th scope="col">Proteinas</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                foreach ($registros as $registro) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $registro['idProducto'] . "</th>";
                    echo "<td>" . $registro['nombreProducto'] . "</td>";
                    echo "<td>" . $registro['cantidadProducto'] . "</td>";
                    echo "<td>" . $registro['hcarbonoProducto'] . "</td>";
                    echo "<td>" . $registro['caloriasProducto'] . "</td>";
                    echo "<td>" . $registro['grasasProducto'] . "</td>";
                    echo "<td>" . $registro['proteinasProducto'] . "</td>";
                    echo "<td>" . $registro['nombreCategoria'] . "</td>";
                    echo "<td>
                    <button type=\"button\" onclick=\"toggleForm(" . $registro['idProducto'] . ")\"><img src=\"../media/iconos/edit.png\" style=\"width:15px\"></button>
                            </td>
                            <td>
                            <form action=\"#\" method=\"post\" onsubmit=\"return confirmarEliminacion()\">
                                <input type=\"hidden\" name=\"idProducto\" value=\"" . $registro['idProducto'] . "\">
                                <button type=\"submit\" name=\"eliminar\"><img src=\"../media/iconos/delete.png\" style=\"width:15px\"></button>
                            </form>
                            </td>";
                    echo "</tr>";


                    echo "<tr id=\"form-" . $registro['idProducto'] . "\" style=\"display:none;\">
                    <td colspan=\"9\">
                        <form action=\"#\" class=\"form\" method=\"post\">
                            <fieldset class=\"w-50 mx-auto\">
                                <input type=\"hidden\" name=\"idProducto\" value=\"" . $registro['idProducto'] . "\">
                                <input class=\"form-control\" type=\"text\" name=\"nombreProducto\" value=\"" . $registro['nombreProducto'] . "\">
                                <br>
                                <input class=\"form-control\" type=\"number\" step=\".01\" name=\"cantidadProducto\" value=\"" . $registro['cantidadProducto'] . "\">
                                <br>
                                <input class=\"form-control\" type=\"number\" step=\".01\" name=\"hcarbonoProducto\" value=\"" . $registro['hcarbonoProducto'] . "\">
                                <br>
                                <input class=\"form-control\" type=\"number\" step=\".01\" name=\"caloriasProducto\" value=\"" . $registro['caloriasProducto'] . "\">
                                <br>
                                <input class=\"form-control\" type=\"number\" step=\".01\" name=\"grasasProducto\" value=\"" . $registro['grasasProducto'] . "\">
                                <br>
                                <input class=\"form-control\" type=\"number\" step=\".01\" name=\"proteinasProducto\" value=\"" . $registro['proteinasProducto'] . "\">
                                <br>
                                <select name=\"idCategoriaFK\" id=\"idCategoriaFK\">
                                    <option value=\"1\" " . ($registro['idCategoriaFK'] == 1 ? "selected" : "") . ">Carnes</option>
                                    <option value=\"2\" " . ($registro['idCategoriaFK'] == 2 ? "selected" : "") . ">Embutido</option>
                                    <option value=\"3\" " . ($registro['idCategoriaFK'] == 3 ? "selected" : "") . ">Pescados</option>
                                    <option value=\"4\" " . ($registro['idCategoriaFK'] == 4 ? "selected" : "") . ">Mariscos</option>
                                    <option value=\"5\" " . ($registro['idCategoriaFK'] == 5 ? "selected" : "") . ">Lacteos</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 6 ? "selected" : "") . ">Panes</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 7 ? "selected" : "") . ">Cereales</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 8 ? "selected" : "") . ">Frutos Secos</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 9 ? "selected" : "") . ">Pastas</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 10 ? "selected" : "") . ">Vegetales</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 11 ? "selected" : "") . ">Frutas</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 12 ? "selected" : "") . ">Especias</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 13 ? "selected" : "") . ">Salsas</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 14 ? "selected" : "") . ">Legumbres</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 15 ? "selected" : "") . ">Aceites</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 16 ? "selected" : "") . ">Vinagres</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 17 ? "selected" : "") . ">Aguas</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 18 ? "selected" : "") . ">Batidos</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 19 ? "selected" : "") . ">Zumos</option>
                                    <option value=\"6\" " . ($registro['idCategoriaFK'] == 20 ? "selected" : "") . ">Refrescos</option>
                            </select>
                            <input type=\"submit\" value=\"Actualizar\" class=\"form-control\" name=\"actualizar\">
                            </fieldset>
                        </form>
                    </td>
                </tr>";
                }
                ?>
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
        // Función para filtrar productos por nombre
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#productos tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que quieres eliminar este usuario?");
        }
        setTimeout(function() {
            document.getElementById("mensaje").style.display = "none";
        }, 2000);

        function toggleForm(idProducto) {
            var form = document.getElementById('form-' + idProducto);
            if (form.style.display === 'none') {
                form.style.display = 'table-row';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>