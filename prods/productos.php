<?php
require("../php/errores.php");
require("../php/funciones.php");

// CONEXION
$conn = conectarBBDD();

sesionN0();
// Obtener la lista de categorías
$sql_categorias = "SELECT idCategoria, nombreCategoria FROM categorias";
$stmt_categorias = $conn->prepare($sql_categorias);
$stmt_categorias->execute();
$resultado_categorias = $stmt_categorias->get_result();
$categorias = $resultado_categorias->fetch_all(MYSQLI_ASSOC);

// Filtrar productos por categoría si se selecciona una categoría
$consulta_condicional = "";
if (isset($_GET['categoria'])) {
    $categoria_seleccionada = $_GET['categoria'];
    if ($categoria_seleccionada != 'all') {
        $consulta_condicional = " WHERE idCategoriaFK = ?";
    }
}

//-------------SELECT------------//
// Sacar la consulta
$consultaprod = "SELECT idProducto, nombreProducto FROM productos" . $consulta_condicional;
$preparada = $conn->prepare($consultaprod);

// Control en la preparación
if ($preparada === false) {
    die("Error en la preparación: " . $conn->error);
}

// Vincular parámetros si hay una categoría seleccionada
if (isset($categoria_seleccionada) && $categoria_seleccionada != 'all') {
    $preparada->bind_param("i", $categoria_seleccionada);
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
//-------FAVORITOS-------//
if (isset($_POST['guardarFavorito'])) {
    $idProducto = $_POST['idProducto']; // Obtener el ID del producto
    $idUsuario = obtenerIDUsuario(); // Obtener el ID del usuario actualmente conectado

    // Guardar el producto como favorito
    if (guardarProductoFavorito($idUsuario, $idProducto)) {
        // Producto guardado como favorito exitosamente
    } else {
        // Error al guardar el producto como favorito
    }
}

$consulta_prod = "SELECT p.idProducto, p.nombreProducto
                  FROM productos p
                  LEFT JOIN favoritos f ON p.idProducto = f.idProductoFK
                  WHERE f.idUsuarioFK = ?"; // Filtrar por ID de usuario

$preparada_prod = $conn->prepare($consulta_prod);

// Control en la preparación
if ($preparada_prod === false) {
    die("Error en la preparación: " . $conn->error);
}

// Vincular el parámetro de ID de usuario
$preparada_prod->bind_param("i", $idUsuario);

// Ejecutar la consulta
$preparada_prod->execute();

// Obtener los resultados
$resultado_prod = $preparada_prod->get_result();
$registros_prod = $resultado_prod->fetch_all(MYSQLI_ASSOC);

// Control en la ejecución
if ($registros_prod === false) {
    die("Error en la ejecución: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="es">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../media/logo.png" type="image/x-icon" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../estilos/prodstyle.css">
<title>Productos</title>

<body>
    <header>
        <div>
            <a href="../index.php"><img src="../media/logoancho.png"></a>
        </div>
        <div class="panel">
            <h1 class="display-6"><strong>Productos</strong></h1>
        </div>
        <div class="perfil">
            <form action="#" method="post">
                <input type="submit" value="Cerrar Sesión" name="cerses">
            </form>
        </div>
    </header>

    <!-- Menú de categorías -->
    <div class="categorias">
        <h3><b>Categorías</b></h3>
        <ul>
            <br>
            <?php foreach ($categorias as $categoria) : ?>
                <li><img src="../media/categ/<?php echo $categoria['idCategoria']; ?>.png" alt="..."><a href="?categoria=<?php echo $categoria['idCategoria']; ?>"><?php echo $categoria['nombreCategoria']; ?></a></li>
            <?php endforeach; ?>
            <br>

        </ul>
        <hr>
        <ul>
            <li><img src="../media/categ/todos.png" alt="..."><a href="?categoria=all">Mostrar Todos</a></li>
            <li>
            <a href="?favoritos=true">Ver Favoritos</a>
        </li>
        </ul>
    </div>

    <div class="container">
        <div id="producto" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach ($registros as $registro) : ?>
                <div class="col">
                    <div class="card">
                        <div class="card-shadow-sm">
                            <img src="../media/prods/<?php echo $registro['idProducto']; ?>.png" class="card-img-top" alt="...">
                            <h5 class="card-title"><?php echo $registro['nombreProducto']; ?></h5>
                            <form action="#" method="post">
                                <input type="hidden" name="idProducto" value="<?php echo $registro['idProducto']; ?>">
                                <button type="submit" name="guardarFavorito" class="btn btn-primary">Guardar como Favorito</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <br>
    <footer>
        <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>