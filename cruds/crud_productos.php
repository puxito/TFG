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

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="icon" href="../media/logo.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/adminstyle.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <header>
        <div>
            <p><img src="../media/logoancho.png"></p>
        </div>
        <div class="panel">
            <h1 class="display-6"><strong>Administración de Productos</strong></h1>
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
        <table class="table table-striped mx-auto" id="productos">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Calorías</th>
                    <th scope="col">Grasas</th>
                    <th scope="col">Proteinas</th>
                    <th scope="col">Imagen</th>
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
                    echo "<td>" . $registro['caloriasProducto'] . "</td>";
                    echo "<td>" . $registro['grasasProducto'] . "</td>";
                    echo "<td>" . $registro['proteinasProducto'] . "</td>";
                    echo "<td>" . $registro['imagenProducto'] . "</td>";
                    echo "<td>" . $registro['nombreCategoria'] . "</td>";
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
        // Función para filtrar productos por nombre
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#productos tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>