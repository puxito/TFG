<?php
require("../php/errores.php");
require("../php/funciones.php");

// Iniciar sesión y conectar a la base de datos
$conn = conectarBBDD();
sesionN1();

// Obtener el ID de la comida desde el parámetro GET
$idComida = $_GET['id'];

// Verificar si se está enviando un formulario de agregar producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_producto"])) {
    $idProducto = $_POST["id_producto"];
    $cantidad = $_POST["cantidad"];
    agregarProductoAComida($idComida, $idProducto, $cantidad);
}

// Verificar si se está enviando un formulario de eliminar producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_producto"])) {
    $idProducto = $_POST["id_producto"];
    eliminarProductoDeComida($idComida, $idProducto);
}

// Obtener los productos y los valores nutricionales de la comida
$productos = obtenerProductosPorComida($idComida);
$valoresNutricionales = obtenerTotalValoresNutricionales($idComida);

// Obtener todos los productos para el desplegable
$listaProductos = obtenerTodosLosProductos();

function agregarProductoAComida($idComida, $idProducto, $cantidad)
{
    global $conn;

    // Insertar el producto en la comida
    $stmt = $conn->prepare("INSERT INTO comidasProductos (idComidaFK, idProductoFK, cantidad) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $idComida, $idProducto, $cantidad);
    $stmt->execute();
    $stmt->close();

    // Actualizar los valores nutricionales totales de la comida
    actualizarValoresNutricionales($idComida);
}

function eliminarProductoDeComida($idComida, $idProducto)
{
    global $conn;

    // Eliminar el producto de la comida
    $stmt = $conn->prepare("DELETE FROM comidasProductos WHERE idComidaFK = ? AND idProductoFK = ?");
    $stmt->bind_param("ii", $idComida, $idProducto);
    $stmt->execute();
    $stmt->close();

    // Actualizar los valores nutricionales totales de la comida
    actualizarValoresNutricionales($idComida);
}

function actualizarValoresNutricionales($idComida)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE comidas c
                            JOIN (SELECT cp.idComidaFK,
                                         SUM(p.caloriasProducto * cp.cantidad / 100) AS totalCalorias,
                                         SUM(p.hcarbonoProducto * cp.cantidad / 100) AS totalCarbohidratos,
                                         SUM(p.grasasProducto * cp.cantidad / 100) AS totalGrasas,
                                         SUM(p.proteinasProducto * cp.cantidad / 100) AS totalProteinas
                                  FROM comidasProductos cp
                                  JOIN productos p ON cp.idProductoFK = p.idProducto
                                  WHERE cp.idComidaFK = ?
                                  GROUP BY cp.idComidaFK) AS subquery
                            ON c.idComida = subquery.idComidaFK
                            SET c.caloriasTotales = subquery.totalCalorias,
                                c.hcarbonoTotales = subquery.totalCarbohidratos,
                                c.grasasTotales = subquery.totalGrasas,
                                c.proteinasTotales = subquery.totalProteinas
                            WHERE c.idComida = ?");
    $stmt->bind_param("ii", $idComida, $idComida);
    $stmt->execute();
    $stmt->close();
}

function obtenerProductosPorComida($idComida)
{
    global $conn;

    $stmt = $conn->prepare("SELECT p.idProducto, p.nombreProducto, cp.cantidad, p.caloriasProducto, p.hcarbonoProducto, p.grasasProducto, p.proteinasProducto
                            FROM comidasProductos cp
                            JOIN productos p ON cp.idProductoFK = p.idProducto
                            WHERE cp.idComidaFK = ?");
    $stmt->bind_param("i", $idComida);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function obtenerTotalValoresNutricionales($idComida)
{
    global $conn;

    $stmt = $conn->prepare("SELECT caloriasTotales AS totalCalorias,
                                   hcarbonoTotales AS totalCarbohidratos,
                                   grasasTotales AS totalGrasas,
                                   proteinasTotales AS totalProteinas
                            FROM comidas
                            WHERE idComida = ?");
    $stmt->bind_param("i", $idComida);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result;
}

function obtenerTodosLosProductos()
{
    global $conn;

    $stmt = $conn->prepare("SELECT idProducto, nombreProducto FROM productos");
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Comida</title>
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .autocomplete-suggestions {
            border: 1px solid #ddd;
            background: #fff;
            overflow: auto;
            position: absolute;
            z-index: 1000;
        }

        .autocomplete-suggestion {
            padding: 8px;
            cursor: pointer;
        }

        .autocomplete-suggestion:hover {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #006691;">
        <div class="container-fluid">
            <a href="../index.php">
                <img class="rounded" src="../media/logoancho.png" alt="logo" width="155">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item m-2">
                        <a href="comidas.php">
                            <img src="../media/iconos/add.png" width="65" alt="Nueva Dieta">
                        </a>
                    </li>
                    <li class="nav-item m-2">
                        <a href="../prods/productos.php">
                            <img src="../media/iconos/productos.png" width="65" alt="Ver productos">
                        </a>
                    </li>
                </ul>
                <?php
                if (sesionN0()) {
                    $conexion = conectarBBDD();
                    $nombre_usuario = $_SESSION["correoElectronicoUsuario"];
                    $sql = "SELECT idRolFK FROM usuarios WHERE correoElectronicoUsuario = ?";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("s", $nombre_usuario);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $fila = $result->fetch_assoc();
                    $administrador = $fila["idRolFK"];
                    $stmt->close();
                    $conexion->close();

                    $nombre_usuario = obtenerNombreUsuario();
                    $ruta_imagen = obtenerRutaImagenUsuario();

                    echo '
                    <ul class="ms-auto m-2 navbar-nav">
                        <li class="border border-dark rounded dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <img class="rounded-circle" src=../' . $ruta_imagen . ' width="65" alt="Foto de Perfil">
                                Bienvenido: <span class="fw-bold">' . $nombre_usuario . '</span>
                            </a>
                        
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../perfil.php">Mi Perfil</a></li>';
                    if ($administrador == 1) {
                        echo '<li><a class="dropdown-item" href="../administracion/indexadmin.php">Panel de Control</a></li>';
                    }
                    echo '       
                                <form method="post">
                                    <input type="hidden" name="cerses" value="true">
                                    <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                                </form>

                            </ul>
                        </li>
                    </ul>';
                ?>
                <?php
                } else {
                ?>
                    <article class="ms-auto">
                        <h2 hidden>Inicio sesión</h2>
                        <form class="d-flex align-items-center" method="post">
                            <div class="">
                                <a class="btn btn-primary" href="../php/login.php">Iniciar Sesion</a>
                                <a class="btn btn-primary" href="../php/registro.php">Registrarse</a>
                            </div>
                        </form>
                    </article>

                <?php
                }
                ?>
                </section>
    </nav>
    <div class="container mt-5">
        <h1>Detalles de Comida</h1>

        <!-- Formulario para agregar producto -->
        <h2>Agregar Producto</h2>
        <form method="post" class="mb-4">
            <div class="mb-3">
                <label for="id_producto" class="form-label">Producto:</label>
                <input type="hidden" name="agregar_producto" value="true">
                <select id="id_producto" name="id_producto" class="form-control" required>
                    <option value="" disabled selected>Seleccione un producto</option>
                    <?php
                    while ($producto = $listaProductos->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($producto["idProducto"]) . '">' . htmlspecialchars($producto["nombreProducto"]) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad (g):</label>
                <input type="number" id="cantidad" name="cantidad" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Producto</button>
        </form>

        <!-- Tabla de productos en la comida -->
        <h2>Productos en la Comida</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad (g)</th>
                    <th>Calorías</th>
                    <th>Carbohidratos</th>
                    <th>Grasas</th>
                    <th>Proteínas</th>
                    <th>Acciones</th> <!-- Nueva columna para las acciones -->
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $productos->fetch_assoc()) {
                    echo '<tr>
                            <td>' . htmlspecialchars($row["nombreProducto"]) . '</td>
                            <td>' . htmlspecialchars($row["cantidad"]) . '</td>
                            <td>' . htmlspecialchars($row["caloriasProducto"] * $row["cantidad"] / 100) . '</td>
                            <td>' . htmlspecialchars($row["hcarbonoProducto"] * $row["cantidad"] / 100) . '</td>
                            <td>' . htmlspecialchars($row["grasasProducto"] * $row["cantidad"] / 100) . '</td>
                            <td>' . htmlspecialchars($row["proteinasProducto"] * $row["cantidad"] / 100) . '</td>
                            <td>
                                <form method="post" onsubmit="return confirm(\'¿Estás seguro de que quieres eliminar este producto?\');">
                                    <input type="hidden" name="eliminar_producto" value="true">
                                    <input type="hidden" name="id_producto" value="' . htmlspecialchars($row["idProducto"]) . '">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                          </tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Mostrar valores nutricionales totales -->
        <h2>Valores Nutricionales Totales</h2>
        <p>Calorías Totales: <?php echo htmlspecialchars($valoresNutricionales["totalCalorias"]); ?></p>
        <p>Carbohidratos Totales: <?php echo htmlspecialchars($valoresNutricionales["totalCarbohidratos"]); ?></p>
        <p>Grasas Totales: <?php echo htmlspecialchars($valoresNutricionales["totalGrasas"]); ?></p>
        <p>Proteínas Totales: <?php echo htmlspecialchars($valoresNutricionales["totalProteinas"]); ?></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
