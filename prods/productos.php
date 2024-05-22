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

// Verificar si se solicita ver favoritos
$verFavoritos = isset($_GET['favoritos']) && $_GET['favoritos'] == 'true';

// Si el usuario quiere ver sus favoritos
if ($verFavoritos) {
    $idUsuario = obtenerIDUsuario();
    $consultaprod = "SELECT p.idProducto, p.nombreProducto
                     FROM productos p
                     JOIN favoritos f ON p.idProducto = f.idProductoFK
                     WHERE f.idUsuarioFK = ?";
    $preparada = $conn->prepare($consultaprod);

    // Control en la preparación
    if ($preparada === false) {
        die("Error en la preparación: " . $conn->error);
    }

    // Vincular el parámetro de ID de usuario
    $preparada->bind_param("i", $idUsuario);
} else {
    // Filtrar productos por categoría si se selecciona una categoría
    $consulta_condicional = "";
    if (isset($_GET['categoria'])) {
        $categoria_seleccionada = $_GET['categoria'];
        if ($categoria_seleccionada != 'all') {
            $consulta_condicional = " WHERE idCategoriaFK = ?";
        }
    }

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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../media/logo.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilos/prodstyle.css">
    <title>Productos</title>
</head>
<body>
<nav class="navbar navbar-expand-xl navbar-dark bg-dark fixed-top" style="background-color: #006691;">
    <div class="container-fluid">
        <a href="../index.php">
            <img class="rounded" src="../media/logoancho.png" alt="logo" width="155">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item m-2">
                    <a href="dietas/dieta.php">
                        <img src="../media/iconos/add.png" width="65" alt="Nueva Dieta">
                    </a>
                </li>
                <li class="nav-item m-2">
                    <a href="../prods/productos.php">
                        <img src="../media/iconos/productos.png" width="65" alt="Ver productos">
                    </a>
                </li>
                <li>
                    <p>&nbsp;&nbsp;&nbsp;</p>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.facebook.com/groups/798944041127303" target="_blank">&nbsp;<i class="fa-brands fa-facebook fa-lg"></i></a>
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
                            <img src="../' . $ruta_imagen . '" width="65" alt="Foto de Perfil">
                            Bienvenido: <span class="fw-bold">' . $nombre_usuario . '</span>
                        </a>
                    
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../perfil.php">Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="#">¿?¿?</a></li>
                            <form method="post">
                                <input type="hidden" name="cerses" value="true">
                                <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                            </form>
                        </ul>
                    </li>
                </ul>';
            } else { 
                echo '
                <article class="ms-auto">
                    <h2 hidden>Inicio sesión</h2>
                    <form class="d-flex align-items-center" method="post">
                        <div class="">
                            <a class="btn btn-primary" href="../php/login.php">Iniciar Sesion</a>
                            <a class="btn btn-primary" href="../php/registro.php">Registrarse</a>
                        </div>
                    </form>
                </article>';
            }
            ?>
        </div>
    </div>
</nav>

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
        <li><a href="?favoritos=true">Ver Favoritos</a></li>
    </ul>
</div>

<div class="container">
    <div id="producto" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php foreach ($registros as $registro) : ?>
            <div class="col">
                <div class="card">
                    <div class="card-shadow-sm">
                        <img src="../media/prods/<?php echo $registro['idProducto']; ?>.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $registro['nombreProducto']; ?></h5>
                            <form class="favorite-form" data-producto-id="<?php echo $registro['idProducto']; ?>">
                                <button type="submit" class="btn btn-primary">
                                    <img src="../media/iconos/addfav.png" alt="Agregar favorito">
                                </button>
                            </form>
                        </div>
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

<script>
$(document).ready(function(){
    $(".favorite-form").on("submit", function(event){
        event.preventDefault();
        var idProducto = $(this).data("producto-id");
        $.ajax({
            url: "productos.php", // Cambia esto por la ruta real
            type: "POST",
            data: { guardarFavorito: true, idProducto: idProducto },
            success: function(response) {
                // Manejar la respuesta de éxito
                alert("Producto agregado a favoritos");
            },
            error: function(xhr, status, error) {
                // Manejar la respuesta de error
                alert("Error al agregar producto a favoritos");
            }
        });
    });
});
</script>

</body>
</html>
